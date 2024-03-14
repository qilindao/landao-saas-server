<?php
declare(strict_types=1);

namespace App\Services\Repositories\Tenant;

use JoyceZ\LaravelLib\Repositories\BaseRepository;
use App\Services\Models\Tenant\TenantPackageModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class TenantPackageRepo
 * @package App\Services\Repositories\Tenant;
 */
class TenantPackageRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return TenantPackageModel::class;
    }
}
