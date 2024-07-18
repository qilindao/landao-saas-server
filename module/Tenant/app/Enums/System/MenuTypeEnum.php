<?php
declare(strict_types=1);

namespace Module\Tenant\Enums\System;

use LanDao\LaravelCore\Attributes\Description;
use LanDao\LaravelCore\Enum\EnumExtend;

/**
 * 系统菜单类型 Enum
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/laravel-lib/enum.html>
 *
 * Class MenuTypeEnum
 * @package Module\Tenant\Enums\System
 */
enum MenuTypeEnum: int
{
    use EnumExtend;

    /**
     * 目录
     * @var int
     */
    #[Description('目录')]
    case MENU_TYPE_CATALOG = 1;
    /**
     * 菜单
     * @var int
     */
    #[Description('菜单')]
    case MENU_TYPE_MENU = 2;
    /**
     * 权限
     * @var int
     */
    #[Description('权限')]
    case MENU_TYPE_PERMISSION = 3;
}
