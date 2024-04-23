<?php
declare(strict_types=1);

namespace Module\Tenant\Models\User;

use App\Services\Models\BaseModel;
use App\Services\Models\Contracts\BelongsToTenant;
use App\Services\Models\Contracts\CreateAndUpdateModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JoyceZ\LaravelLib\Model\Concerns\SoftDeletesEx;

/**
 * 岗位 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class PostModel
 * @package App\Services\Models\User;
 */
class PostModel extends BaseModel
{
    use SoftDeletesEx, BelongsToTenant, CreateAndUpdateModel;

    /**
     * 表名
     * @var string
     */
    protected $table = 'pt_user_post';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'post_id';

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
        'post_id',
        'post_name',
        'remark',
        'is_enable',
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
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * 岗位下的用户
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(UserModel::class, 'post_id', 'post_id');
    }
}
