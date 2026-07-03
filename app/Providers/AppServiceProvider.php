<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Wajib di-import di paling atas file!

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Memaksa semua URL asset & route menggunakan HTTPS jika diakses via Ngrok/Proxy
        if (str_contains(request()->header('X-Forwarded-Proto'), 'https') || str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
