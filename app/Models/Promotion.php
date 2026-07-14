<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order', 'max_discount',
        'max_uses', 'used_count', 'starts_date', 'starts_time',
        'ends_date', 'ends_time', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'starts_date' => 'date',
            'ends_date' => 'date',
        ];
    }

    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        $now = now();

        if ($this->starts_date) {
            $start = Carbon::parse($this->starts_date->format('Y-m-d').' '.($this->starts_time ?? '00:00:00'));
            if ($now->lt($start)) {
                return false;
            }
        }

        if ($this->ends_date) {
            $end = Carbon::parse($this->ends_date->format('Y-m-d').' '.($this->ends_time ?? '23:59:59'));
            if ($now->gt($end)) {
                return false;
            }
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(int $subtotal): int
    {
        if ($subtotal < $this->min_order) {
            return 0;
        }

        $discount = $this->type === 'percent'
            ? (int) ($subtotal * $this->value / 100)
            : $this->value;

        if ($this->max_discount) {
            $discount = min($discount, $this->max_discount);
        }

        return $discount;
    }
}
