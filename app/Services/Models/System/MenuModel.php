<?php
declare(strict_types=1);

namespace App\Services\Models\System;

use App\Services\Models\User\RoleModel;
use App\Services\Models\Tenant\TenantPackageModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use JoyceZ\LaravelLib\Model\BaseModel;

/**
 * 系统菜单权限 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class MenuModel
 * @package App\Services\Models\System;
 */
class MenuModel extends BaseModel
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_menu';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'menu_id';

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
        'menu_id',
        'parent_id',
        'name',
        'title',
        'icon',
        'type',
        'redirect',
        'path',
        'parent_id',
        'component',
        'auth_code',
        'order_no',
        'keep_alive',
        'hidden',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * 属性转化
     * @var array
     */
    protected $casts = [
        'hidden' => 'boolean',
        'keep_alive' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = [
        'pivot'
    ];

    /**
     * 菜单权限所拥有的角色
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(RoleModel::class, 'pt_user_role_has_menu', 'menu_id', 'role_id');
    }

    /**
     * 菜单全西安所拥有的租户套餐
     * @return BelongsToMany
     */
    public function tenantPackages(): BelongsToMany
    {
        return $this->belongsToMany(TenantPackageModel::class, 'pt_tenant_package_has_menu', 'menu_id', 'package_id');
    }
}
