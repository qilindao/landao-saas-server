<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\System;

use JoyceZ\LaravelLib\Repositories\BaseRepository;
use Module\Tenant\Models\System\DictItemModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class DictItemRepo
 * @package Module\Tenant\Repositories\System;
 */
class DictItemRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return DictItemModel::class;
    }
}
