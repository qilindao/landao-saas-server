<?php
declare(strict_types=1);

namespace App\Services\Models\Tenant;

use App\Services\Models\BaseModel;
use App\Services\Models\User\RoleModel;
use App\Services\Models\User\UserModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JoyceZ\LaravelLib\Model\Casts\EncryptDataIndex;

/**
 * 租户 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class TenantModel
 * @package App\Services\Models\Tenant;
 */
class TenantModel extends BaseModel
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'pt_tenant';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'tenant_id';

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
        'tenant_id',
        'tenant_name',
        'user_limit',
        'is_enable',
        'is_super',
        'is_free',
        'package_id',
        'contact_name',
        'contact_phone',
        'contact_phone_search',
        'remark',
        'expired_at',
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
        'is_super' => 'boolean',
        'is_free' => 'boolean',
        'contact_phone' => 'encrypted',
        'contact_phone_search' => EncryptDataIndex::class . ':phone',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getTenantKeyName(): string
    {
        return $this->primaryKey;
    }

    public function getTenantKey()
    {
        return $this->getAttribute($this->getTenantKeyName());
    }

    public function run(callable $callback)
    {
        // TODO: Implement run() method.
    }


    /**
     * 租户所属套餐
     * @return BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(TenantPackageModel::class, 'package_id', 'package_id');
    }

    /**
     * 租户所拥有用户
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(UserModel::class, 'tenant_id', 'tenant_id');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(RoleModel::class, 'tenant_id', 'tenant_id');
    }

}
