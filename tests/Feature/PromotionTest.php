<?php

use App\Models\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Promotion validity', function () {
    it('treats midnight end time as end of day', function () {
        $promotion = Promotion::create([
            'code' => 'SAVE10',
            'type' => 'percent',
            'value' => 10,
            'min_order' => 10000,
            'max_discount' => 5000,
            'starts_date' => now()->subDay()->toDateString(),
            'starts_time' => '00:00:00',
            'ends_date' => now()->toDateString(),
            'ends_time' => '00:00:00',
            'is_active' => true,
        ]);

        $this->travelTo(now()->setTime(12, 0));

        expect($promotion->fresh()->isValid())->toBeTrue();
    });

    it('becomes invalid after the configured end time has passed', function () {
        $promotion = Promotion::create([
            'code' => 'SAVE20',
            'type' => 'fixed',
            'value' => 1000,
            'min_order' => 10000,
            'starts_date' => now()->toDateString(),
            'starts_time' => '00:00:00',
            'ends_date' => now()->toDateString(),
            'ends_time' => '22:00',
            'is_active' => true,
        ]);

        $this->travelTo(now()->setTime(22, 20));

        expect($promotion->fresh()->isValid())->toBeFalse();
    });
});
