<?php

namespace Columbia\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Http\Resources\Json\Resource;

use Illuminate\Support\Facades\Schema;

use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();

        Passport::withoutCookieSerialization();

        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
