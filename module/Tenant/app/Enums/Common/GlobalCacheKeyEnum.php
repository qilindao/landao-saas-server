<?php
declare(strict_types=1);

namespace Module\Tenant\Enums\Common;

use LanDao\LaravelCore\Attributes\Description;
use LanDao\LaravelCore\Enum\EnumExtend;

/**
 * 缓存key Enum
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/laravel-lib/enum.html>
 *
 * Class GlobalCacheKeyEnum
 * @package Module\Tenant\Enums\Common
 */
enum GlobalCacheKeyEnum: string
{
    use EnumExtend;

    #[Description('菜单权限缓存')]
    case LAN_DAO_MENU = 'lanDao_system_all_menu';
}
