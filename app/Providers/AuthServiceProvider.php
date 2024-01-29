<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{

    const ADMIN = 'admin';
    const USER = 'Regular User';
    const MODERATOR = 'Moderator';

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('access_admin_panel', function ($user) {
            return $user->role === self::ADMIN;
        });

        Gate::define('access_moderator_panel', function ($user) {
            return in_array($user->role, [self::ADMIN, self::MODERATOR]);
        });

    }
}
