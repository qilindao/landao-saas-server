<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\Tenant;

use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;
use Module\Tenant\Models\Tenant\TenantModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class TenantRepo
 * @package Module\Tenant\Repositories\Tenant;
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

    public function read(int $tenantId): array
    {
        $tenant = $this->getInfoById($tenantId);
        if(!$tenant){
            return ResultHelper::returnFormat('租户不存在',-1);
        }


    }
}
