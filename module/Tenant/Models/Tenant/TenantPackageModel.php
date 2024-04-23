<?php
declare(strict_types=1);

namespace Module\Tenant\Models\Tenant;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\Models\BaseModel;
use Module\Tenant\Models\System\MenuModel;

/**
 * 租户套餐 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class TenantPackageModel
 * @package App\Services\Models\Tenant;
 */
class TenantPackageModel extends BaseModel
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'pt_tenant_package';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'package_id';

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
        'package_id',
        'package_name',
        'is_enable',
        'is_default',
        'remark',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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
     * 租户套餐所拥有的菜单权限
     * @return BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(MenuModel::class, 'pt_tenant_package_has_menu', 'package_id', 'menu_id');
    }

    /**
     * 获取套餐下所有租户
     * @return HasMany
     */
    public function tenants(): HasMany
    {
        return $this->hasMany(TenantModel::class, 'package_id', 'package_id');
    }
}
