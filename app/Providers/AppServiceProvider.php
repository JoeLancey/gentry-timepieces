<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ActivityLog;
use App\Policies\ActivityLogPolicy;
use Illuminate\Support\Facades\Gate;

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
        Gate::policy(ActivityLog::class, ActivityLogPolicy::class);

        // Ensure PHP's default timezone matches the app timezone (Asia/Manila)
        date_default_timezone_set(config('app.timezone'));
    }
}
