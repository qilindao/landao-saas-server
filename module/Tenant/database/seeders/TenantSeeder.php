<?php

namespace Module\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Module\Tenant\Models\User\UserModel;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nowTime = now()->timestamp;
        DB::table('pt_tenant_package')->insertGetId([
            'package_name' => '平台管理',
            'is_default' => 1,
            'remark' => '平台运营方，不可删除',
            'created_by' => 1001,
            'created_at' => $nowTime,
            'updated_at' => $nowTime
        ]);
        DB::table('pt_tenant')->insertGetId([
            'tenant_name' => '平台租户',
            'package_id' => 1001,
            'is_super' => 1,
            'is_free' => 1,
            'remark' => '平台运营方，不可删除',
            'created_by' => 1001,
            'created_at' => $nowTime,
            'updated_at' => $nowTime
        ]);
        $salt = Str::random(6);

        UserModel::create([
            'username' => 'peadmin',
            'nickname' => '超级管理员',
            'real_name' => '超级管理员',
            'mobile' => '13600000000',
            'mobile_search' => '13600000000',
            'password' => Crypt::encryptString('123456qwe@A' . $salt),
            'pwd_salt' => $salt,
            'avatar' => '',
            'is_super' => 1,
            'reg_date' => $nowTime,
            'reg_ip' => '127.0.0.1',
            'last_login_ip' => '127.0.0.1',
            'last_login_time' => $nowTime,
            'status' => 1,
            'created_by' => 1001,
            'tenant_id' => 1001,
            'updated_at' => $nowTime
        ]);

        //创建角色
        $roleId = DB::table('pt_user_role')->insertGetId([
            'role_name' => '超级管理员',
            'is_default' => 1,
            'tenant_id' => 1001,
            'remark' => '超级管理员角色，不可操作',
            'created_at' => $nowTime,
            'updated_at' => $nowTime
        ]);
        //绑定角色
        DB::table('pt_user_has_role')->insert([
            [
                'role_id' => 1001,
                'user_id' => 1001
            ]
        ]);

        DB::table('pt_album')->insert([
            'album_name' => '默认目录',
            'is_default' => 1,
            'tenant_id' => 1001,
            'created_by' => 1001,
            'created_at' => $nowTime,
            'updated_at' => $nowTime
        ]);
    }
}
