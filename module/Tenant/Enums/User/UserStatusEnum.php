<?php

namespace Module\Tenant\Enums\User;

use JoyceZ\LaravelLib\Enum\EnumExtend;
use JoyceZ\LaravelLib\Enum\EnumDescription;
enum UserStatusEnum: int
{
    use EnumExtend;
    #[EnumDescription('在职')]
    case USER_IN_JOB = 1;

    #[EnumDescription('试用')]
    case USER_ON_TRIAL = 2;

    #[EnumDescription('实习')]
    case USER_INTERNSHIP = 3;

    #[EnumDescription('兼职')]
    case USER_PART_TIME_JOB = 4;

    #[EnumDescription('外包')]
    case USER_OUTER_PACK = 5;

    #[EnumDescription('远程')]
    case USER_REMOTE_JOB = 6;

    #[EnumDescription('临时')]
    case USER_TEMPORARY = 7;

    #[EnumDescription('离职')]
    case USER_DEPART = 8;
}
