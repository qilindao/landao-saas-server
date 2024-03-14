<?php
declare(strict_types=1);

use App\Services\Tenancy;
use App\Services\Models\Tenant\TenantModel;

if (!function_exists('tenancy')) {
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
     */
    function tenancy()
    {
        return app(Tenancy::class);
    }
}

if (!function_exists('tenant')) {
    /**
     * Get a key from the current tenant's storage.
     *
     */
    /**
     * @param $key
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed|void|null
     */
    function tenant($key = null)
    {
        dd(app()->bound(TenantModel::class));
        if (!app()->bound(TenantModel::class)) {
            return;
        }

        if (is_null($key)) {
            return app(TenantModel::class);
        }

        return optional(app(TenantModel::class))->getAttribute($key) ?? null;
    }
}

