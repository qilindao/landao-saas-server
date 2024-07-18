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
        Schema::create('pt_user_login_log', function (Blueprint $table) {
            $table->id('log_id');
            $table->unsignedBigInteger('user_id')->default(0)->index('idx_login_log_user_id')->comment('用户id');
            $table->string('username')->default('')->comment('登录用户名');
            $table->bigInteger('user_ip')->default(0)->comment('ip地址');
            $table->string('user_agent', 512)->default(0)->comment('浏览器 UA');
            $table->string('from_app',10)->default('PC')->comment('日志来源端');
            $table->string('result')->default('')->comment('登录结果');
            $table->unsignedBigInteger('tenant_id')->default(0)->index('idx_login_log_tenant_id')->comment('所属租户');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
            $table->unsignedInteger('deleted_at')->default(0)->comment('删除时间');
        });
        //表注释
        DB::statement("ALTER TABLE `pt_user_login_log` comment '用户登录日志'");
        DB::statement("ALTER TABLE `pt_user_login_log` AUTO_INCREMENT=1001");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_user_login_log');
    }
};
