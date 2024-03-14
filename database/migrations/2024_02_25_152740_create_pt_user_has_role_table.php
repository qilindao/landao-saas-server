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
        Schema::create('pt_user_has_role', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->default(0)->index('pk_user_id')->comment('用户id');
            $table->unsignedBigInteger('role_id')->default(0)->index('pk_role_id')->comment('角色id');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('pt_user')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('role_id')
                ->on('pt_user_role')
                ->onDelete('cascade');

            $table->primary(['user_id', 'role_id'],
                'pt_user_has_role_primary');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `pt_user_has_role` comment '用户绑定角色'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_user_has_role');
    }
};
