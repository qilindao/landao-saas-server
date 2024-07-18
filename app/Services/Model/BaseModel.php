<?php

namespace App\Services\Model;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use LanDao\LaravelCore\Model\BaseModel as LanModelBaseModel;

class BaseModel extends LanModelBaseModel
{
    use Cachable;
}
