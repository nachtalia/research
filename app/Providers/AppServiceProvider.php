<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        // Example of Inertia asset versioning (optional)
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });

        // Ensure Vite works correctly (no need for `Vite::prefetch`)
    }
}
