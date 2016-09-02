<?php

namespace App\Providers;

use Auth;
use App\Extensions\MyUserProvider;
use App\Extensions\MyGuard;
use App\Extensions\AdminUserProvider;


use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Auth::provider('donotuse-user-provider', function($app, array $config) {
            return new MyUserProvider();
        });

        Auth::extend('donotuse-guard-driver', function($app, $name, array $config) {
            return new MyGuard();
        });

        Auth::provider('admin-user-provider', function($app, array $config) {
            return new AdminUserProvider($app['hash'], $config['model']);
        });
    }
}
