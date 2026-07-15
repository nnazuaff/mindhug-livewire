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
            $start = $this->getStartDateTime();
            if ($start && $now->lt($start)) {
                return false;
            }
        }

        if ($this->ends_date) {
            $end = $this->getEndDateTime();
            if ($end && $now->greaterThan($end)) {
                return false;
            }
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        return true;
    }

    protected function getStartDateTime(): ?Carbon
    {
        if (! $this->starts_date) {
            return null;
        }

        $time = $this->normalizeStartTime($this->starts_time);
        $dateString = $this->starts_date->format('Y-m-d').' '.$time;

        return Carbon::parse($dateString, 'Asia/Jakarta');
    }

    protected function getEndDateTime(): ?Carbon
    {
        if (! $this->ends_date) {
            return null;
        }

        $time = $this->normalizeEndTime($this->ends_time);
        $dateString = $this->ends_date->format('Y-m-d').' '.$time;

        return Carbon::parse($dateString, 'Asia/Jakarta');
    }

    protected function normalizeStartTime(?string $time): string
    {
        if (blank($time)) {
            return '00:00:00';
        }

        $time = trim($time);

        // Jika format HH:MM, tambahkan :00
        if (preg_match('/^\d{1,2}:\d{2}$/', $time)) {
            return $time.':00';
        }

        // Jika sudah HH:MM:SS
        return $time;
    }

    protected function normalizeEndTime(?string $time): string
    {
        if (blank($time)) {
            return '23:59:59';
        }

        $time = trim($time);

        // Jika format HH:MM, tambahkan :00
        if (preg_match('/^\d{1,2}:\d{2}$/', $time)) {
            return $time.':00';
        }

        // Jika 00:00:00, artinya akhir hari
        if ($time === '00:00:00') {
            return '23:59:59';
        }

        return $time;
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
