<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pt_tenant_package_has_menu', function (Blueprint $table) {
            $table->unsignedInteger('menu_id')->default(0)->index('pk_sys_menu_id')->comment('菜单权限id');
            $table->unsignedInteger('package_id')->default(0)->index('pk_tenant_package_id')->comment('租户套餐id');

            $table->foreign('menu_id')
                ->references('menu_id')
                ->on('sys_menu')
                ->onDelete('cascade');

            $table->foreign('package_id')
                ->references('package_id')
                ->on('pt_tenant_package')
                ->onDelete('cascade');

            $table->primary(['menu_id',  'package_id'],
                'pt_tenant_package_has_menu_primary');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `pt_tenant_package_has_menu` comment '租户套餐绑定菜单权限'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_tenant_package_has_menu');
    }
};
