<?php

namespace Module\Tenant\Enums\Common;

use JoyceZ\LaravelLib\Enum\EnumExtend;
use LanDao\LaravelCore\Attributes\Description;

enum GlobalCacheKeyEnum: string
{
    use EnumExtend;

    #[Description('菜单权限缓存')]
    case LAN_DAO_MENU = 'lanDao_system_all_menu';
}
