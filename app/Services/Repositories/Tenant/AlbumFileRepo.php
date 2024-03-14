<?php
declare(strict_types=1);

namespace App\Services\Repositories\Tenant;

use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Repositories\BaseRepository;
use App\Services\Models\Tenant\AlbumFileModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class AlbumFileRepo
 * @package App\Services\Repositories\Tenant;
 */
class AlbumFileRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return AlbumFileModel::class;
    }

    public function doLocalUpload(Request $request): array
    {

    }
}
