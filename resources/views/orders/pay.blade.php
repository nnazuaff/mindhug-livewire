<x-layouts.app title="Pembayaran - {{ $order->invoice_number }}">
    <livewire:orders.pay :order="$order" />
</x-layouts.app>
