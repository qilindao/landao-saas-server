<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\Tenant;

use LanDao\LaravelCore\Repositories\BaseRepository;
use Module\Tenant\Models\Tenant\TenantModel;

/**
 * 租户 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class TenantRepo
 * @package Module\Tenant\Repositories
 */
class TenantRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return TenantModel::class;
    }
}
