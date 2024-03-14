<?php
declare(strict_types=1);

namespace App\Services\Repositories\System;

use JoyceZ\LaravelLib\Helpers\StrHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;
use App\Services\Models\System\LoginLogModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class LoginLogRepo
 * @package App\Services\Repositories\System;
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
