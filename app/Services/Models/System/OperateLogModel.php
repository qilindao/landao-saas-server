<?php
declare(strict_types=1);

namespace App\Services\Models\System;

use JoyceZ\LaravelLib\Model\BaseModel;
use JoyceZ\LaravelLib\Model\Casts\Ip4ConvertInt;

/**
 * 审计日志 - 用户操作日志 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class OperateLogModel
 * @package App\Services\Models\System;
 */
class OperateLogModel extends BaseModel
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_operate_log';

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
        'module',
        'name',
        'request_params',
        'request_method',
        'request_url',
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
        'request_params' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
