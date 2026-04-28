<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Watch;
use App\Models\Client;
use App\Models\Appraisal;
use App\Models\User;
use App\Policies\WatchPolicy;
use App\Policies\ClientPolicy;
use App\Policies\AppraisalPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Watch::class => WatchPolicy::class,
        Client::class => ClientPolicy::class,
        Appraisal::class => AppraisalPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
