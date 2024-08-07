<?php

namespace App\Services\Model\Contracts;

use App\Services\Model\TenantScope;
use Module\Tenant\Models\Tenant\TenantModel;

trait BelongsToTenant
{
    public static $tenantIdColumn = 'tenant_id';

    public function tenant()
    {
        return $this->belongsTo(TenantModel::class, self::$tenantIdColumn);
    }

    public static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            if (!$model->getAttribute(self::$tenantIdColumn) && !$model->relationLoaded('tenant')) {
                if (tenancy()->initialized) {
                    $model->setAttribute(self::$tenantIdColumn, tenant()->getTenantKey());
                    $model->setRelation('tenant', tenant());
                }
            }
        });
    }
}
