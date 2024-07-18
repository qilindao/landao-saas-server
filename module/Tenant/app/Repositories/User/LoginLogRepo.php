<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\User;

use LanDao\LaravelCore\Repositories\BaseRepository;
use Module\Tenant\Models\User\LoginLogModel;

/**
 * 审计日志 - 用户登录日志 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class LoginLogRepo
 * @package Module\Tenant\Repositories\User
 */
class LoginLogRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return LoginLogModel::class;
    }
}
