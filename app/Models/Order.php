<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'total_amount',
        'status',
        'cancellation_reason',
        'cancel_reason',
        'cancel_rejected_reason',
        'cancel_requested_at',
        'payment_method',
        'shipping_method',
        'shipping_fee',
        'handling_fee',
        'payment_proof',
        'shipping_address',
        'snap_token',
        'midtrans_transaction_id',
        'payment_type',
        'payment_channel',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'cancel_requested_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function trackingEvents(): HasMany
    {
        return $this->hasMany(OrderTrackingEvent::class)->orderByDesc('occurred_at');
    }

    public function latestTrackingEvent()
    {
        return $this->hasOne(OrderTrackingEvent::class)->latestOfMany('occurred_at');
    }

    public function shipment()
    {
        return $this->hasOne(OrderShipment::class);
    }
}
