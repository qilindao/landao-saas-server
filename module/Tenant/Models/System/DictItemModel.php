<?php
declare(strict_types=1);

namespace Module\Tenant\Models\System;

use JoyceZ\LaravelLib\Model\BaseModel;

/**
 * 数据字典 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class DictItemModel
 * @package App\Services\Models\System;
 */
class DictItemModel extends BaseModel
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_dict_item';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'dict_iid';

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
        'dict_iid',
        'dict_id',
        'label',
        'value',
        'sort_num',
        'is_enable',
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
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
