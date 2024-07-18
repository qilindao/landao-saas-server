<?php
declare(strict_types=1);

namespace Module\Tenant\Models\User;

use App\Services\Model\BaseModel;
use LanDao\LaravelCore\Model\Casts\Ip4ConvertInt;

/**
 * 审计日志 - 用户登录日志 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class LoginLogModel
 * @package Module\Tenant\Models\User
 */
class LoginLogModel extends BaseModel
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'pt_user_login_log';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'log_id';

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
        'log_id',
        'user_id',
        'username',
        'user_ip',
        'user_agent',
        'from_app',
        'result',
        'tenant_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * 属性转化
     * @var array
     */
    protected $casts = [
        'user_ip' => Ip4ConvertInt::class,//登录ip
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
