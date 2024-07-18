<?php

use App\Http\Middleware\UserOperateLog;
use App\Http\Middleware\TenantPermission;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'userOperate.log' => UserOperateLog::class,//用户审计日记
            'auth.tenant' => TenantPermission::class,//租户权限
            'api.case.converter'=>\LanDao\LaravelCore\Middleware\ApiCaseConverter::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
