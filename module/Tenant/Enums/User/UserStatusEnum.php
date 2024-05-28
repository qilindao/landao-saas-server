<?php

namespace Module\Tenant\Enums\User;

use LanDao\LaravelCore\Attributes\Description;
use LanDao\LaravelCore\Enum\EnumExtend;

enum UserStatusEnum: int
{
    use EnumExtend;

    #[Description('在职')]
    case USER_IN_JOB = 1;

    #[Description('试用')]
    case USER_ON_TRIAL = 2;

    #[Description('实习')]
    case USER_INTERNSHIP = 3;

    #[Description('兼职')]
    case USER_PART_TIME_JOB = 4;

    #[Description('外包')]
    case USER_OUTER_PACK = 5;

    #[Description('远程')]
    case USER_REMOTE_JOB = 6;

    #[Description('临时')]
    case USER_TEMPORARY = 7;

    #[Description('离职')]
    case USER_DEPART = 8;
}
