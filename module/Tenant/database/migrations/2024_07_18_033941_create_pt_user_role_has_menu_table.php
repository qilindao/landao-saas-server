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
        Schema::create('pt_user_role_has_menu', function (Blueprint $table) {
            $table->unsignedInteger('menu_id')->default(0)->index('pk_sys_menu_id')->comment('菜单权限id');
            $table->unsignedBigInteger('role_id')->default(0)->index('pk_role_id')->comment('角色id');

            $table->foreign('menu_id')
                ->references('menu_id')
                ->on('sys_menu')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('role_id')
                ->on('pt_user_role')
                ->onDelete('cascade');

            $table->primary(['menu_id', 'role_id'],
                'pt_role_has_menu_primary');
        });
        //表注释
        DB::statement("ALTER TABLE `pt_user_role_has_menu` comment '角色绑定菜单权限'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_user_role_has_menu');
    }
};
