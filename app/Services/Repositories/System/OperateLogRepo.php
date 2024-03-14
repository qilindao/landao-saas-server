<?php
declare(strict_types=1);

namespace App\Services\Repositories\System;

use JoyceZ\LaravelLib\Repositories\BaseRepository;
use App\Services\Models\System\OperateLogModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class OperateLogRepo
 * @package App\Services\Repositories\System;
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
