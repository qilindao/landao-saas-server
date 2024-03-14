<?php
declare(strict_types=1);

namespace App\Services\Models\User;

use App\Services\Models\Contracts\BelongsToTenant;
use App\Services\Models\System\MenuModel;
use App\Services\Models\Tenant\TenantModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Services\Models\BaseModel;
use JoyceZ\LaravelLib\Model\Concerns\SoftDeletesEx;

/**
 * 请说明具体哪块业务的 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class RoleModel
 * @package App\Services\Models\User;
 */
class RoleModel extends BaseModel
{
    use SoftDeletesEx, BelongsToTenant;


    /**
     * 表名
     * @var string
     */
    protected $table = 'pt_user_role';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'role_id';

    /**
     * 指示是否自动维护时间戳
     * @var bool
     */
    public $timestamps = true;

    /**
     * 模型日期列的存储格式。
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 字段信息
     * @var array
     */
    protected $fillable = [
        'role_id',
        'role_name',
        'is_default',
        'is_enable',
        'remark',
        'created_by',
        'updated_by',
        'tenant_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = ['deleted_at'];

    /**
     * 属性转化
     * @var array
     */
    protected $casts = [
        'is_enable' => 'boolean',
        'is_default' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * 角色所拥有的菜单全西安
     * @return BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(MenuModel::class, 'pt_user_role_has_menu', 'role_id', 'menu_id');
    }

    /**
     * 角色所拥有的用户
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(UserModel::class, 'pt_user_has_role', 'role_id', 'user_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(TenantModel::class, 'tenant_id', 'tenant_id');
    }
}
