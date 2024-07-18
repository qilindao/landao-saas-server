<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\System;

use LanDao\LaravelCore\Repositories\BaseRepository;
use Module\Tenant\Models\System\RegionModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class RegionRepo
 * @package Module\Tenant\Repositories\System
 */
class RegionRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return RegionModel::class;
    }
}
