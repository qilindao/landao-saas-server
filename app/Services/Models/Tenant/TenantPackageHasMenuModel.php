<?php

namespace App\Services\Models\Tenant;

use App\Services\Models\BaseModel;

class TenantPackageHasMenuModel extends BaseModel
{
    protected $table = 'pt_tenant_package_has_menu';

    protected $fillable = [
        'package_id', 'menu_id'
    ];
}
