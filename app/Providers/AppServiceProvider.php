<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::routes(null, ['middleware' => [
            'universal',
            InitializeTenancyByDomain::class
        ]]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('userstamps', function () {
            $this->foreignId('created_by')->nullable();
            $this->foreignId('updated_by')->nullable();
            $this->foreignId('deleted_by')->nullable();
        });
    }
}
