<?php

namespace App\Providers;

use App\Services\Tenancy;
use Illuminate\Support\ServiceProvider;
use Module\Tenant\Models\Tenant\TenantModel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerTenancy();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * 注册租户相关服务
     * @return void
     */
    private function registerTenancy(): void
    {
        $this->app->singleton(Tenancy::class);
        $this->app->bind(TenantModel::class, function ($app) {
            return $app[Tenancy::class]->tenant;
        });
    }
}
