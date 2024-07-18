<?php
declare(strict_types=1);

namespace Module\Tenant\Models\User;

use LanDao\LaravelCore\Model\BaseModel;

/**
 * 用户关联角色 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class UserHasRoleModel
 * @package Module\Tenant\Models\User
 */
class UserHasRoleModel extends BaseModel
{
    protected $table = 'pt_user_has_role';

    protected $fillable = [
        'role_id', 'user_id'
    ];
}
