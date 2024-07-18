<?php
declare(strict_types=1);

namespace Module\Tenant\Models\Tenant;

use App\Services\Model\Contracts\BelongsToTenant;
use LanDao\LaravelCore\Model\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use LanDao\LaravelCore\Model\Concerns\SoftDeletesEx;

/**
 * 租户附件 Eloquent ORM
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class AlbumFileModel
 * @package Module\Tenant\Models\Tenant
 */
class AlbumFileModel extends BaseModel
{
    use SoftDeletesEx, BelongsToTenant;

    /**
     * 表名
     * @var string
     */
    protected $table = 'pt_album_file';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'file_id';

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
        'file_id',
        'album_id',
        'file_name',
        'file_title',
        'file_path',
        'file_size',
        'file_ext',
        'file_type',
        'mime_type',
        'file_ip',
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
     * 要附加到模型数组表单的访问器。
     *
     * @var array
     */
    protected $appends = ['file_url'];

    /**
     * 追加附件可访问路径
     * @return Attribute
     */
    protected function fileUrl(): Attribute
    {
        return new Attribute(
            get: fn(mixed $value, array $attributes) => asset(Storage::url($attributes['file_path'])),
        );
    }
}
