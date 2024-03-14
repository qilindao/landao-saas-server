<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pt_user_role', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('role_name',50)->default('')->comment('角色名');
            $table->unsignedTinyInteger('is_default')->default(0)->comment('是否默认[1:是;0:否]');
            $table->string('remark')->default('')->comment('备注');
            $table->unsignedTinyInteger('is_enable')->default(1)->comment('是否启用[1:启用;0:停用]');
            $table->unsignedBigInteger('created_by')->default(0)->comment('创建人');
            $table->unsignedBigInteger('updated_by')->default(0)->comment('更新人');
            $table->unsignedBigInteger('tenant_id')->default(0)->index('idx_role_tenant_id')->comment('所属租户');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
            $table->unsignedInteger('deleted_at')->default(0)->comment('删除时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `pt_user_role` comment '角色'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `pt_user_role` AUTO_INCREMENT=1001");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_user_role');
    }
};
