<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\User;

use LanDao\LaravelCore\Repositories\BaseRepository;
use Module\Tenant\Models\User\OperateLogModel;

/**
 * 审计日志 - 用户操作日志 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class OperateLogRepo
 * @package Module\Tenant\Repositories\User
 */
class OperateLogRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return OperateLogModel::class;
    }
}
