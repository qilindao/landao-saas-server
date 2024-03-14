<?php

namespace App\Services\Enums\System;

use JoyceZ\LaravelLib\Enum\BaseEnum;

/**
 * 菜单权限 Enum
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/laravel-lib/enum.html>
 *
 * Class MenuTypeEnum
 * @package App\Services\Enums\System;
 */
class MenuTypeEnum extends BaseEnum
{
    /**
     * 目录
     * @var int
     */
    const MENU_TYPE_CATALOG = 0;
    /**
     * 功能
     * @var int
     */
    const MENU_TYPE_MENU = 1;
    /**
     * 权限
     * @var int
     */
    const MENU_TYPE_PERMISSION= 2;
    public static function getMap(): array
    {
        return [
            self::MENU_TYPE_CATALOG => '目录',
            self::MENU_TYPE_MENU => '功能',
            self::MENU_TYPE_PERMISSION => '权限'
        ];
    }
}
