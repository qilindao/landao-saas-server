<?php
declare(strict_types=1);

namespace App\Services\Models\User;

use App\Services\Models\Contracts\BelongsToTenant;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\Models\BaseModel;
use JoyceZ\LaravelLib\Model\Concerns\SoftDeletesEx;

/**
 * 部门 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class DeptModel
 * @package App\Services\Models\User;
 */
class DeptModel extends BaseModel
{
    use SoftDeletesEx,BelongsToTenant;
    /**
     * 表名
     * @var string
     */
    protected $table = 'pt_user_dept';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'dept_id';

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
        'dept_id',
        'dept_name',
        'parent_id',
        'leader_uid',
        'created_by',
        'is_enable',
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
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * 部门所有用户
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(UserModel::class, 'dept_id', 'dept_id');
    }
}
