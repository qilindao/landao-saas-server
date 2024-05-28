<?php

namespace Module\Tenant\Providers;

use Illuminate\Support\ServiceProvider;
use Module\Tenant\Http\Middleware\TenantPermission;
use Module\Tenant\Http\Middleware\UserOperateLog;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //注册中间件
        $this->app->singleton('auth.tenant', TenantPermission::class);
        $this->app->singleton('userOperate.log', UserOperateLog::class);
    }

    public function register(): void
    {
        //注册事件
        $this->app->register(EventServiceProvider::class);
    }

}
