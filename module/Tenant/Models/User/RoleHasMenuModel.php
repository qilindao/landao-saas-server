<?php
declare(strict_types=1);

namespace Module\Tenant\Models\User;

use App\Services\Models\BaseModel;

class RoleHasMenuModel extends BaseModel
{
    protected $table = 'pt_role_has_menu';

    protected $fillable = [
        'role_id', 'menu_id'
    ];
}
