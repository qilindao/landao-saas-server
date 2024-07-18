<?php
declare(strict_types=1);

namespace Module\Tenant\Models\Tenant;

use LanDao\LaravelCore\Model\BaseModel;

/**
 * 请说明具体哪块业务的 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class TenantPackageHasMenuModel
 * @package Module\Tenant\Models\Tenant
 */
class TenantPackageHasMenuModel extends BaseModel
{
    protected $table = 'pt_tenant_package_has_menu';

    protected $fillable = [
        'package_id', 'menu_id'
    ];
}
