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
        Schema::create('pt_album', function (Blueprint $table) {
            $table->id('album_id');
            $table->string('album_name',60)->default('')->comment('相册名称');
            $table->string('album_cover',256)->default('')->comment('相册封面图片');
            $table->unsignedInteger('parent_id')->default(0)->comment('上级相册id');
            $table->unsignedInteger('album_sort')->default(0)->comment('排序');
            $table->unsignedTinyInteger('is_default')->default(0)->comment('是否默认[ 0 否 1 是 ]默认相册不可删除，删除其他分组时会将图片转移到默认分组下');
            $table->unsignedBigInteger('created_by')->default(0)->comment('创建人');
            $table->unsignedBigInteger('updated_by')->default(0)->comment('更新人');
            $table->unsignedBigInteger('tenant_id')->default(0)->index('idx_album_tenant_id')->comment('所属租户');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
            $table->unsignedInteger('deleted_at')->default(0)->comment('删除时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `pt_album` comment '附件专辑'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `pt_album` AUTO_INCREMENT=1001");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_album');
    }
};
