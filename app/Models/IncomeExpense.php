<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeExpense extends Model
{
    protected $fillable = [
        'type', 'source', 'description', 'amount', 'transaction_date',
        'subscription_order_id', 'admin_id',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
        ];
    }

    public function subscriptionOrder()
    {
        return $this->belongsTo(SubscriptionOrder::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
