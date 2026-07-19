<?php

namespace App\Http\Livewire\Checkout;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Promotion;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    public array $cartItems = [];

    public array $selectedAddress = [];

    public array $paymentMethods = [];

    public ?int $selectedPayment = null;

    public string $paymentNotice = '';

    public bool $isSubmitting = false;

    public int $shippingCost = 15000;

    public bool $hasInactiveItems = false;

    public string $promoCode = '';

    public int $discountAmount = 0;

    public ?string $promoMessage = null;

    public ?int $appliedPromoId = null;

    public function applyPromo(): void
    {
        $this->promoMessage = null;
        $this->discountAmount = 0;
        $this->appliedPromoId = null;

        if (empty(trim($this->promoCode))) {
            return;
        }

        $promo = Promotion::query()->where('code', strtoupper($this->promoCode))->first();

        if (! $promo || ! $promo->isValid()) {
            $this->promoMessage = 'Kode voucher tidak valid atau sudah kadaluarsa.';

            return;
        }

        if ($this->subtotal < $promo->min_order) {
            $this->promoMessage = 'Minimal order Rp '.number_format($promo->min_order).'.';

            return;
        }

        $this->discountAmount = $promo->calculateDiscount($this->subtotal);
        $this->appliedPromoId = $promo->id;
        $this->promoMessage = 'Voucher berhasil diterapkan!';
    }

    public function mount(): void
    {
        $this->loadCart();

        if (empty($this->cartItems) && ! $this->hasInactiveItems) {
            $this->redirectRoute('cart');

            return;
        }

        $this->loadAddress();
        $this->loadPaymentMethods();
    }

    public function loadCart(): void
    {
        $disk = Storage::disk('public');
        $this->hasInactiveItems = false;

        $cart = session()->get('cart', []);
        if (! empty($cart)) {
            $allIds = array_keys($cart);
            $existingIds = Product::query()->whereIn('id', $allIds)->pluck('id')->toArray();
            foreach ($cart as $pid => $qty) {
                if (! in_array((int) $pid, $existingIds)) {
                    unset($cart[$pid]);
                }
            }
            session()->put('cart', $cart);
        }

        if (empty($cart)) {
            $this->cartItems = [];

            return;
        }

        $productIds = array_map('intval', array_keys($cart));
        $allProducts = Product::query()->whereIn('id', $productIds)->get()->keyBy('id');

        $activeItems = [];
        foreach ($cart as $productId => $quantity) {
            $product = $allProducts->get((int) $productId);
            if (! $product) {
                continue;
            }
            if (! $product->is_active) {
                $this->hasInactiveItems = true;

                continue;
            }
            $files = $disk->files('products/'.$product->id);
            $image = ! empty($files) ? basename($files[0]) : 'default.png';
            $activeItems[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity,
                'image' => asset('storage/products/'.$product->id.'/'.$image),
            ];
        }

        $this->cartItems = $activeItems;
    }

    public function loadAddress(): void
    {
        $user = Auth::user();
        if (! $user) {
            $this->selectedAddress = [];

            return;
        }
        $address = $user->addresses()->where('is_primary', true)->first();
        if (! $address) {
            $this->selectedAddress = [];

            return;
        }
        $this->selectedAddress = [
            'id' => $address->id,
            'label' => $address->label,
            'recipient_name' => $address->recipient_name,
            'phone' => $address->phone,
            'region' => $address->region,
            'street' => $address->street,
            'detail' => $address->detail,
        ];
    }

    public function selectPayment(int $methodId): void
    {
        $this->selectedPayment = $methodId;
    }

    public function loadPaymentMethods(): void
    {
        if (! Schema::hasTable('payment_methods')) {
            $this->paymentMethods = [
                ['id' => 1, 'code' => 'bank_transfer', 'label' => 'Bank Transfer', 'subtitle' => 'Transfer antar bank', 'icon' => null],
                ['id' => 2, 'code' => 'ewallet', 'label' => 'E-Wallet', 'subtitle' => 'Dana / OVO / ShopeePay', 'icon' => null],
                ['id' => 3, 'code' => 'qris', 'label' => 'QRIS', 'subtitle' => 'Scan QR untuk bayar', 'icon' => null],
            ];

            return;
        }
        $this->paymentMethods = PaymentMethod::query()->where('is_active', true)->orderBy('sort_order')->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'code' => $m->code,
                'label' => $m->name,
                'subtitle' => $m->subtitle,
                'icon' => $m->icon ? Storage::url($m->icon) : null,
            ])
            ->all();
    }

    public function getSubtotalProperty(): int
    {
        return array_sum(array_column($this->cartItems, 'subtotal'));
    }

    public function getTotalProperty(): int
    {
        return $this->subtotal + $this->shippingCost - $this->discountAmount;
    }

    public function getCanCheckoutProperty(): bool
    {
        if ($this->hasInactiveItems) {
            return false;
        }
        if (empty($this->selectedAddress)) {
            return false;
        }
        if (! $this->selectedPayment) {
            return false;
        }
        if (empty($this->cartItems)) {
            return false;
        }

        return true;
    }

    public function getCheckoutDisabledReasonProperty(): string
    {
        if ($this->hasInactiveItems) {
            return 'Beberapa produk tidak tersedia. Hapus dari keranjang.';
        }
        if (empty($this->cartItems)) {
            return 'Keranjang kosong';
        }
        if (empty($this->selectedAddress)) {
            return 'Alamat belum dipilih';
        }
        if (! $this->selectedPayment) {
            return 'Metode bayar belum dipilih';
        }

        return '';
    }

    public function placeOrder()
    {
        if (empty($this->selectedAddress)) {
            $this->paymentNotice = 'Silakan lengkapi alamat pengiriman Anda terlebih dahulu.';

            return;
        }
        if (! $this->selectedPayment) {
            $this->paymentNotice = 'Pilih metode pembayaran terlebih dahulu.';

            return;
        }
        if (empty($this->cartItems)) {
            $this->paymentNotice = 'Keranjang belanja kosong.';

            return;
        }
        if ($this->hasInactiveItems) {
            $this->paymentNotice = 'Beberapa produk tidak tersedia. Hapus dari keranjang.';

            return;
        }

        $pendingOrder = Order::query()
            ->where('user_id', Auth::id())
            ->whereIn('status', ['awaiting_payment', 'awaiting_confirmation'])
            ->exists();

        if ($pendingOrder) {
            $this->paymentNotice = 'Selesaikan pesanan sebelumnya terlebih dahulu.';

            return;
        }

        $itemIds = array_column($this->cartItems, 'id');
        $validCount = Product::query()->whereIn('id', $itemIds)->where('is_active', true)->count();
        if ($validCount !== count($this->cartItems)) {
            $this->paymentNotice = 'Maaf, beberapa produk sudah tidak tersedia. Pesanan gagal diproses.';
            $this->loadCart();

            return;
        }

        $this->paymentNotice = '';
        $this->isSubmitting = true;

        try {
            $paymentMethod = collect($this->paymentMethods)->firstWhere('id', $this->selectedPayment);

            $orderService = app(OrderService::class);
            $order = $orderService->createOrder(
                Auth::id(),
                $this->appliedPromoId ?? 0,
                $this->cartItems,
                $this->selectedAddress,
                $this->shippingCost,
                $this->discountAmount,
                $paymentMethod['label'] ?? 'Unknown'
            );

            session()->forget('cart');
            $this->dispatch('cart-updated', 0);
            $this->isSubmitting = false;

            return redirect()->route('orders.show', $order->invoice_number);
        } catch (\Exception $e) {
            $this->isSubmitting = false;
            $this->paymentNotice = $e->getMessage();
            Log::error('Order failed: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.checkout.index', [
            'subtotal' => $this->subtotal,
            'total' => $this->total,
        ]);
    }
}
