<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DowngradeExpiredPlus extends Command
{
    protected $signature = 'mindhug:downgrade-expired-plus';

    protected $description = 'Downgrade users with expired Plus subscription';

    public function handle(): void
    {
        $count = User::where('role', 'plus')
            ->where('plus_expires_at', '<', now())
            ->update(['role' => 'free', 'plus_expires_at' => null]);

        $this->info("Downgraded {$count} users.");
    }
}
