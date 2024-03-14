<?php
declare(strict_types=1);

namespace App\Services\Models\System;

use Illuminate\Database\Eloquent\Relations\HasMany;
use JoyceZ\LaravelLib\Model\BaseModel;

/**
 * 数据字典分类 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class DictModel
 * @package App\Services\Models\System;
 */
class DictModel extends BaseModel
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_dict';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'dict_id';

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
        'dict_id',
        'name',
        'title',
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

    /**
     * 字典值
     * @return HasMany
     */
    public function dictItems(): HasMany
    {
        return $this->hasMany(DictItemModel::class, 'dict_id', 'dict_id');
    }
}
