<?php
declare(strict_types=1);

namespace App\Services\Repositories\Tenant;

use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;
use App\Services\Models\Tenant\TenantModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class TenantRepo
 * @package App\Services\Repositories\Tenant;
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
        $tenant = $this->getByPkId($tenantId);
        if(!$tenant){
            return ResultHelper::returnFormat('租户不存在',-1);
        }


    }
}
