<?php
declare(strict_types=1);

namespace App\Services\Repositories\System;

use JoyceZ\LaravelLib\Repositories\BaseRepository;
use App\Services\Models\System\DictModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class DictRepo
 * @package App\Services\Repositories\System;
 */
class DictRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return DictModel::class;
    }
}
