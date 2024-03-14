<?php

namespace App\Services;

use App\Services\Models\Tenant\TenantModel;
use Illuminate\Database\Eloquent\Builder;

class Tenancy
{
    public TenantModel|null $tenant = null;

    public bool $initialized = false;

    public function initialize($tenantId): void
    {
        if (!is_object($tenantId)) {
            $tenant = $this->find($tenantId);

            if (!$tenant) {
                throw new \Exception('缺少租户信息');
            }
        }

        if ($this->initialized) {
            $this->end();
        }

        $this->tenant = $tenant;

        $this->initialized = true;
    }

    public function query(): Builder
    {
        return $this->model()->query();
    }

    /**
     * @return TenantModel
     */
    public function model()
    {
        return new TenantModel();
    }

    public function find($id): ?TenantModel
    {
        return $this->model()->where($this->model()->getTenantKeyName(), $id)->first();
    }

    public function end(): void
    {
        if (!$this->initialized) {
            return;
        }
        $this->initialized = false;

        $this->tenant = null;
    }

    public function runSingleTenant($tenantId, callable $callback)
    {
        $this->initialize($tenantId);
        $callback($this->tenant);
    }

    public function getTenantKey(): int
    {
        return $this->tenant->tenant_id;
    }
}
