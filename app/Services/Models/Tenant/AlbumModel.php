<?php
declare(strict_types=1);

namespace App\Services\Models\Tenant;

use App\Services\Models\BaseModel;
use App\Services\Models\Contracts\BelongsToTenant;


/**
 * 租户上传附件 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class AlbumModel
 * @package App\Services\Models\Tenant;
 */
class AlbumModel extends BaseModel
{
    use  BelongsToTenant;

    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_album';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'album_id';

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
        'album_id',
        'album_name',
        'album_cover',
        'parent_id',
        'album_sort',
        'is_default',
        'created_by',
        'updated_by',
        'tenant_id',
        'created_at',
        'updated_at',
        'deleted_at'
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
}
