<?php

namespace App\Providers;

use App\Services\Models\Tenant\TenantModel;
use App\Services\Tenancy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(Tenancy::class);

        $this->app->bind(TenantModel::class, function ($app) {
            return $app[Tenancy::class]->tenant;
        });
    }

    /**
     * Bootstrap any application services.
     * @return void
     * @throws \ReflectionException
     */
    public function boot(): void
    {
        //
    }
}
