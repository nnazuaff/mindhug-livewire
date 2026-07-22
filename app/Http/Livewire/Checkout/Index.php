<?php

namespace App\Http\Livewire\Checkout;

use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Services\MidtransService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    public array $cartItems = [];

    public array $selectedAddress = [];

    public string $paymentNotice = '';

    public bool $isSubmitting = false;

    public int $shippingCost = 15000;

    public bool $hasInactiveItems = false;

    public string $promoCode = '';

    public int $discountAmount = 0;

    public ?string $promoMessage = null;

    public ?int $appliedPromoId = null;

    public ?int $directProductId = null;

    public int $directQuantity = 1;

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
            $this->promoMessage = 'Kode tidak valid.';

            return;
        }
        if ($this->subtotal < $promo->min_order) {
            $this->promoMessage = 'Min order Rp '.number_format($promo->min_order);

            return;
        }

        $this->discountAmount = $promo->calculateDiscount($this->subtotal);
        $this->appliedPromoId = $promo->id;
        $this->promoMessage = 'Voucher diterapkan!';
    }

    public function mount(): void
    {
        $this->directProductId = request()->query('product') ? (int) request()->query('product') : null;
        $this->directQuantity = max(1, (int) request()->query('quantity', 1));
        $this->loadCart();
        if (empty($this->cartItems) && ! $this->hasInactiveItems && ! $this->directProductId) {
            $this->redirectRoute('cart');

            return;
        }
        $this->loadAddress();
    }

    public function loadCart(): void
    {
        $disk = Storage::disk('public');
        $this->hasInactiveItems = false;

        if ($this->directProductId !== null) {
            $product = Product::query()->find($this->directProductId);
            if (! $product || ! $product->is_active) {
                $this->cartItems = [];
                $this->hasInactiveItems = true;

                return;
            }
            $files = $disk->files('products/'.$product->id);
            $image = ! empty($files) ? basename($files[0]) : 'default.png';
            $this->cartItems = [[
                'id' => $product->id, 'name' => $product->name, 'price' => $product->price,
                'quantity' => $this->directQuantity, 'subtotal' => $product->price * $this->directQuantity,
                'image' => asset('storage/products/'.$product->id.'/'.$image),
            ]];

            return;
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            $this->cartItems = [];

            return;
        }

        $productIds = array_map('intval', array_keys($cart));
        $allProducts = Product::query()->whereIn('id', $productIds)->get()->keyBy('id');
        $activeItems = [];
        foreach ($cart as $pid => $qty) {
            $product = $allProducts->get((int) $pid);
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
                'id' => $product->id, 'name' => $product->name, 'price' => $product->price,
                'quantity' => $qty, 'subtotal' => $product->price * $qty,
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
            'id' => $address->id, 'label' => $address->label,
            'recipient_name' => $address->recipient_name, 'phone' => $address->phone,
            'region' => $address->region, 'street' => $address->street, 'detail' => $address->detail,
        ];
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
        if ($this->hasInactiveItems || empty($this->selectedAddress) || empty($this->cartItems)) {
            return false;
        }

        return true;
    }

    public function getCheckoutDisabledReasonProperty(): string
    {
        if ($this->hasInactiveItems) {
            return 'Produk tidak tersedia.';
        }
        if (empty($this->cartItems)) {
            return 'Keranjang kosong';
        }
        if (empty($this->selectedAddress)) {
            return 'Alamat belum dipilih';
        }

        return '';
    }

    public function placeOrder()
    {
        if (empty($this->selectedAddress)) {
            $this->paymentNotice = 'Lengkapi alamat.';

            return;
        }
        if (empty($this->cartItems)) {
            $this->paymentNotice = 'Keranjang kosong.';

            return;
        }
        if ($this->hasInactiveItems) {
            $this->paymentNotice = 'Produk tidak tersedia.';

            return;
        }

        $pending = Order::where('user_id', Auth::id())
            ->whereIn('status', ['awaiting_payment', 'awaiting_confirmation'])->exists();
        if ($pending) {
            $this->paymentNotice = 'Selesaikan pesanan sebelumnya.';

            return;
        }

        $this->isSubmitting = true;
        try {
            $order = app(OrderService::class)->createOrder(
                Auth::id(), $this->appliedPromoId ?? 0, $this->cartItems,
                $this->selectedAddress, $this->shippingCost, $this->discountAmount, 'Midtrans'
            );

            // Buat Snap token
            app(MidtransService::class)->createSnapToken($order);

            if ($this->directProductId === null) {
                session()->forget('cart');
            }
            $this->dispatch('cart-updated', 0);
            $this->isSubmitting = false;

            // Redirect ke detail order (Snap akan auto-buka via session flag)
            return redirect()->route('orders.show', $order->invoice_number);
        } catch (\Exception $e) {
            $this->isSubmitting = false;
            $this->paymentNotice = $e->getMessage();
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
