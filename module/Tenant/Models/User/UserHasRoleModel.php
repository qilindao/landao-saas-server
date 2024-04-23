<?php
declare(strict_types=1);

namespace Module\Tenant\Models\User;

use App\Services\Models\BaseModel;

class UserHasRoleModel extends BaseModel
{
    protected $table = 'pt_user_has_role';

    protected $fillable = [
        'role_id', 'user_id'
    ];
}
