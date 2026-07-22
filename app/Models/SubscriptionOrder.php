<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionOrder extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'invoice_number', 'user_id', 'subscription_plan_id', 'amount',
        'status', 'payment_method', 'payment_proof', 'confirmed_at', 'snap_token', 'midtrans_transaction_id', 'payment_type',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}
