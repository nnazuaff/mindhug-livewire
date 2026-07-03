<?php

namespace App\Http\Livewire\Checkout;

use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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

    public int $discountPercent = 0;

    public ?int $directProductId = null;

    public int $directQuantity = 1;

    public function mount(): void
    {
        $this->directProductId = request()->query('product') ? (int) request()->query('product') : null;
        $this->directQuantity = max(1, (int) request()->query('quantity', 1));

        $this->loadCart();
        $this->loadAddress();
        $this->loadPaymentMethods();
    }

    public function loadCart(): void
    {
        if ($this->directProductId !== null) {
            $product = Product::query()->find($this->directProductId);

            if (! $product) {
                $this->cartItems = [];

                return;
            }

            $this->cartItems = [[
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $this->directQuantity,
                'subtotal' => $product->price * $this->directQuantity,
            ]];

            return;
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            $this->cartItems = [];

            return;
        }

        $productIds = array_map('intval', array_keys($cart));
        $products = Product::query()
            ->get()
            ->filter(fn ($product) => in_array($product->id, $productIds, true))
            ->keyBy('id');

        $this->cartItems = collect($cart)
            ->map(function ($quantity, $productId) use ($products) {
                $product = $products->get((int) $productId);

                if (! $product) {
                    return null;
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    public function loadAddress(): void
    {
        /** @var User|null $user */
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
                ['id' => 1, 'code' => 'bank_transfer', 'label' => 'Bank Transfer', 'subtitle' => 'Transfer antar bank'],
                ['id' => 2, 'code' => 'ewallet', 'label' => 'E-Wallet', 'subtitle' => 'Dana / OVO / ShopeePay'],
                ['id' => 3, 'code' => 'qris', 'label' => 'QRIS', 'subtitle' => 'Scan QR untuk bayar'],
            ];

            return;
        }

        $this->paymentMethods = PaymentMethod::query()
            ->get()
            ->filter(fn ($method) => (bool) $method->is_active)
            ->sortBy('sort_order')
            ->values()
            ->map(fn ($method) => [
                'id' => $method->id,
                'code' => $method->code,
                'label' => $method->name,
                'subtitle' => $method->subtitle,
            ])
            ->all();
    }

    public function getSubtotalProperty(): int
    {
        return array_sum(array_column($this->cartItems, 'subtotal'));
    }

    public function getDiscountAmountProperty(): int
    {
        return (int) round($this->subtotal * ($this->discountPercent / 100));
    }

    public function getTotalProperty(): int
    {
        return $this->subtotal + $this->shippingCost - $this->discountAmount;
    }

    public function placeOrder(): void
    {
        if (empty($this->selectedAddress)) {
            $this->paymentNotice = 'Silakan lengkapi alamat pengiriman Anda terlebih dahulu untuk melanjutkan pembayaran.';

            return;
        }

        if (! $this->selectedPayment) {
            $this->paymentNotice = 'Pilih metode pembayaran terlebih dahulu.';

            return;
        }

        $this->paymentNotice = '';
        $this->isSubmitting = true;

        sleep(1);

        $this->isSubmitting = false;

        if ($this->directProductId === null) {
            session()->forget('cart');
        }

        $this->dispatchBrowserEvent('order-placed', ['message' => 'Pesanan berhasil dibuat.']);
        $this->loadCart();
    }

    public function render()
    {
        return view('livewire.checkout.index', [
            'subtotal' => $this->subtotal,
            'discountAmount' => $this->discountAmount,
            'total' => $this->total,
        ]);
    }
}
