<?php

namespace App\Providers;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        
        $this->registerPolicies($gate);
 // Binding eloquent.admin to our EloquentAdminUserProvider
       Auth::provider('eloquent.admin', function($app, array $config) {
       return new EloquentAdminUserProvider($app['hash'], $config['model']);
});

    }
}
