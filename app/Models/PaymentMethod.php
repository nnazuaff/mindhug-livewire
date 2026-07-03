<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['code', 'name', 'subtitle', 'is_active', 'sort_order'])]
class PaymentMethod extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
