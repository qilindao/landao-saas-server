<?php
declare(strict_types=1);

namespace Module\Tenant\Models\User;

use App\Services\Model\Contracts\BelongsToTenant;
use App\Services\Model\Contracts\CreateAndUpdateModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LanDao\LaravelCore\Model\Casts\EncryptDataIndex;
use LanDao\LaravelCore\Model\Casts\EncryptTableDb;
use LanDao\LaravelCore\Model\Casts\Ip4ConvertInt;
use Laravel\Sanctum\HasApiTokens;
use Module\Tenant\Models\Tenant\TenantModel;


/**
 * B端用户 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class UserModel
 * @package Module\Tenant\Models
 */
class UserModel extends Authenticatable
{
    use HasApiTokens, Notifiable, BelongsToTenant, CreateAndUpdateModel;

    /**
     * 表名
     * @var string
     */
    protected $table = 'pt_user';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'user_id';

    const CREATED_AT = 'reg_date'; //创建时间，注册时间
    const UPDATED_AT = 'updated_at'; //修改时间

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

    protected $guarded = [];

    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'password', 'pwd_salt', 'mobile_search', 'pivot'
    ];

    /**
     * 字段信息
     * @var array
     */
    protected $fillable = [
        'user_id',
        'dept_id',
        'post_id',
        'username',
        'gender',
        'nickname',
        'real_name',
        'mobile',
        'mobile_search',
        'password',
        'pwd_salt',
        'avatar',
        'introduce',
        'is_super',
        'reg_date',
        'reg_ip',
        'refresh_ip',
        'last_login_ip',
        'last_login_time',
        'status',
        'created_by',
        'updated_by',
        'tenant_id',
        'pwd_modify_at',
        'updated_at',
        'refresh_time',
    ];

    /**
     * 属性转化
     * @var array
     */
    protected $casts = [
        'pwd_salt' => 'encrypted',
        'mobile' => EncryptTableDb::class,
        'mobile_search' => EncryptDataIndex::class . ':phone',
        'reg_ip' => Ip4ConvertInt::class,//注册ip
        'refresh_ip' => Ip4ConvertInt::class,//刷新ip
        'last_login_ip' => Ip4ConvertInt::class,//最后登录ip地址
        'is_super' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * 用户所拥有的角色
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(RoleModel::class, UserHasRoleModel::class, 'user_id', 'role_id');
    }

    /**
     * 用户所属租户
     * @return BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(TenantModel::class, 'tenant_id', 'tenant_id');
    }

    /**
     * 用户所属部门
     * @return BelongsTo
     */
    public function dept(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'dept_id', 'dept_id');
    }

    /**
     * 用户所属岗位
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(PostModel::class, 'post_id', 'post_id');
    }

    /**
     * 用于校验是否前端用户
     * @return bool
     */
    public function isFrontendUser(): bool
    {
        return false;
    }
}
