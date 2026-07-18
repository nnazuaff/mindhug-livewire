<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'MindHug Plus Bulanan',
            'slug' => 'plus-bulanan',
            'price' => 29000,
            'duration_days' => 30,
            'features' => [
                'Curhat tanpa batas',
                'Respon prioritas dari tim MindHug',
                'Badge Plus eksklusif di profil',
                'Akses fitur terbaru lebih awal',
                'Mendukung pengembangan MindHug',
            ],
            'is_active' => true,
        ]);
    }
}
