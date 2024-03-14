<?php

namespace App\Services\Models\User;

use App\Services\Models\BaseModel;

class RoleHasMenuModel extends BaseModel
{
    protected $table = 'pt_role_has_menu';

    protected $fillable = [
        'role_id', 'menu_id'
    ];
}
