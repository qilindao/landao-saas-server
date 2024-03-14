<?php

namespace App\Services\Enums\User;

use JoyceZ\LaravelLib\Enum\BaseEnum;

/**
 * 请说明具体哪块业务的 Enum
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/laravel-lib/enum.html>
 *
 * Class UserStatusEnum
 * @package App\Services\Enums\User;
 */
class UserStatusEnum extends BaseEnum
{

    const USER_IN_JOB = 1;


    const USER_ON_TRIAL = 2;

    const USER_INTERNSHIP = 3;

    const USER_PART_TIME_JOB = 4;

    const USER_OUTER_PACK = 5;

    const USER_REMOTE_JOB = 6;
    const USER_TEMPORARY = 7;
    const USER_DEPART = 8;

    public static function getMap(): array
    {
        return [
            self::USER_IN_JOB => '在职',
            self::USER_ON_TRIAL => '试用',
            self::USER_INTERNSHIP => '实习',
            self::USER_PART_TIME_JOB => '兼职',
            self::USER_OUTER_PACK => '外包',
            self::USER_REMOTE_JOB => '远程',
            self::USER_TEMPORARY => '临时',
            self::USER_DEPART => '离职',
        ];
    }
}
