<?php

namespace App\Services\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use JoyceZ\LaravelLib\Model\BaseModel as LanDaoModel;

class BaseModel extends LanDaoModel
{
    use Cachable;
}
