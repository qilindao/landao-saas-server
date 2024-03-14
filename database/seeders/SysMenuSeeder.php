<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SysMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::insert("INSERT INTO `sys_menu` (`menu_id`, `name`, `title`, `icon`, `type`, `redirect`, `path`, `parent_id`, `component`, `auth_code`, `order_no`, `keep_alive`, `hidden`, `created_at`, `updated_at`) VALUES ('1001', 'SystemManage', '系统管理', 'setting', '0', '', '', '0', 'LAYOUT', '', '0', '0', '0', '1630393533', '1704686873');");
        DB::insert("INSERT INTO `sys_menu` (`menu_id`, `name`, `title`, `icon`, `type`, `redirect`, `path`, `parent_id`, `component`, `auth_code`, `order_no`, `keep_alive`, `hidden`, `created_at`, `updated_at`) VALUES ('1002', 'AuthManage', '权限管理', '', '0', '', '', '1001', 'BLANK', '', '0', '0', '0', '1630393533', '1630393533');");
        DB::insert("INSERT INTO `sys_menu` (`menu_id`, `name`, `title`, `icon`, `type`, `redirect`, `path`, `parent_id`, `component`, `auth_code`, `order_no`, `keep_alive`, `hidden`, `created_at`, `updated_at`) VALUES ('1003', 'MenuManage', '菜单管理', '', '1', '', '/sys/menu', '1001', 'system/menu/index', '', '0', '0', '0', '1630393533', '1704426215');");
    }
}
