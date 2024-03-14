<?php

namespace App\Services\Models\User;

use App\Services\Models\BaseModel;

class UserHasRoleModel extends BaseModel
{
    protected $table = 'pt_user_has_role';

    protected $fillable = [
        'role_id', 'user_id'
    ];
}
