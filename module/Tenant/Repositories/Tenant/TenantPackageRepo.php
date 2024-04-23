<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\Tenant;

use JoyceZ\LaravelLib\Repositories\BaseRepository;
use Module\Tenant\Models\Tenant\TenantPackageModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class TenantPackageRepo
 * @package Module\Tenant\Repositories\Tenant;
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
