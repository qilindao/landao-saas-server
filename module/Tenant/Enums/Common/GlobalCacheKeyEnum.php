<?php

namespace Module\Tenant\Enums\Common;

use JoyceZ\LaravelLib\Enum\EnumDescription;
use JoyceZ\LaravelLib\Enum\EnumExtend;

enum GlobalCacheKeyEnum: string
{
    use EnumExtend;

    #[EnumDescription('菜单权限缓存')]
    case LAN_DAO_MENU = 'lanDao_system_all_menu';
}
