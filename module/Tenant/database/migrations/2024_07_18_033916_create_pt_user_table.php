<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pt_user', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('dept_id')->default(0)->index('idx_dept_id')->comment('所属部门');
            $table->unsignedBigInteger('post_id')->default(0)->index('idx_post_id')->comment('所属岗位');
            $table->string('username', 50)->default('')->comment('登录名');
            $table->unsignedTinyInteger('gender')->default(1)->comment('性别[1:男;2:女;0:未知]');
            $table->string('nickname', 50)->default('')->comment('昵称');
            $table->string('real_name')->default('')->comment('真实姓名');
            $table->string('mobile', 168)->default('')->comment('手机号[加密值]');
            $table->string('mobile_search', 54)->index('idx_user_mobile')->default('')->comment('手机号,用于搜索');
            $table->string('password')->default('')->comment('密码');
            $table->string('pwd_salt')->default('')->comment('密码加密盐，加密值]');
            $table->string('avatar', 256)->default('')->comment('头像');
            $table->string('introduce', 500)->default('')->comment('个人简介');
            $table->unsignedTinyInteger('is_super')->default(0)->comment('是否每个租户超级管理员[1 是 0 否]');
            $table->unsignedTinyInteger('is_enable')->default(1)->comment('是否启用[1:启用;0:停用]');
            $table->unsignedInteger('reg_date')->default(0)->index('idx_user_reg_date')->comment('注册时间');
            $table->unsignedBigInteger('reg_ip')->default(0)->comment('注册时ip');
            $table->unsignedBigInteger('refresh_ip')->default(0)->comment('刷新ip');
            $table->unsignedBigInteger('last_login_ip')->default(0)->comment('最后一次登录ip');
            $table->unsignedInteger('last_login_time')->default(0)->comment('最后一次登录时间');
            $table->unsignedTinyInteger('status')->default(1)->index('idx_user_status')->comment('用户状态。可选值[1:在职;2:试用;3:实习;4:兼职;5:外包;6:远程;7:临时;8:离职]');
            $table->unsignedBigInteger('created_by')->default(0)->comment('创建人');
            $table->unsignedBigInteger('updated_by')->default(0)->comment('更新人');
            $table->unsignedBigInteger('tenant_id')->default(0)->index('idx_user_tenant_id')->comment('所属租户');
            $table->rememberToken();
            $table->unsignedInteger('pwd_modify_at')->default(0)->comment('密码修改时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
            $table->unsignedInteger('refresh_time')->default(0)->comment('刷新时间');

            $table->unique(['mobile', 'tenant_id'], 'uk_user_mobile_by_tenant_id');
//            $table->unique(['username', 'tenant_id'], 'uk_user_username_by_tenant_id');
        });
        //表注释
        DB::statement("ALTER TABLE `pt_user` comment '用户'");
        DB::statement("ALTER TABLE `pt_user` AUTO_INCREMENT=1001");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_user');
    }
};
