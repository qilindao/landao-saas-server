<?php
declare(strict_types=1);

namespace Module\Tenant\Models\User;

use LanDao\LaravelCore\Model\BaseModel;

/**
 * 角色关联菜单权限 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class RoleHasMenuModel
 * @package Module\Tenant\Models\User
 */
class RoleHasMenuModel extends BaseModel
{
    protected $table = 'pt_role_has_menu';

    protected $fillable = [
        'role_id', 'menu_id'
    ];
}
