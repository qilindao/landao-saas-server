<?php
declare(strict_types=1);

namespace Module\Tenant\Enums\System;

use JoyceZ\LaravelLib\Enum\EnumExtend;
use JoyceZ\LaravelLib\Enum\EnumDescription;

enum MenuTypeEnum: int
{
    use EnumExtend;

    /**
     * 目录
     * @var int
     */
    #[EnumDescription('目录')]
    case MENU_TYPE_CATALOG = 1;
    /**
     * 菜单
     * @var int
     */
    #[EnumDescription('菜单')]
    case MENU_TYPE_MENU = 2;
    /**
     * 权限
     * @var int
     */
    #[EnumDescription('权限')]
    case MENU_TYPE_PERMISSION = 3;


}
