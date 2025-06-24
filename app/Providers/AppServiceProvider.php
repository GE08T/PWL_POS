<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         if (env('APP_ENV') !== 'local' && str_contains(env('NGROK_URL'), request()->getHost())) {
            URL::forceScheme('https');
            URL::forceRootUrl(env('NGROK_URL'));
        }
    }
}
