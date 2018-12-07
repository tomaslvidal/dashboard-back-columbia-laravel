<?php

namespace Columbia\Providers;

use Illuminate\Support\ServiceProvider;

use Columbia\Http\Controllers\Auth\Passwords\PasswordBrokerManager;

class PasswordResetServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPasswordBroker();
    }

    /**
     * Register the password broker instance.
     *
     * @return void
     */
    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password_two', function ($app) {
            return new PasswordBrokerManager($app);
        });

        $this->app->bind('auth.password_two.broker', function ($app) {
            return $app->make('auth.password_two')->broker_();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auth.password_two', 'auth.password_two.broker'];
    }
}
