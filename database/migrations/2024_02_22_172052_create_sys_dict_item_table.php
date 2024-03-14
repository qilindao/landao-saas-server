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
        Schema::create('sys_dict_item', function (Blueprint $table) {
            $table->increments('dict_iid');
            $table->unsignedInteger('dict_id')->default(0)->index('idx_dict_item_id')->comment('字典类型');
            $table->string('label')->default('')->comment('字典标签');
            $table->string('value')->default('')->comment('字典键值');
            $table->unsignedMediumInteger('sort_num')->default(0)->comment('排序');
            $table->unsignedTinyInteger('is_enable')->default(1)->comment('是否启用[1:启用;0:停用]');
            $table->string('remark')->default('')->comment('备注');
            $table->unsignedBigInteger('created_by')->default(0)->comment('创建人');
            $table->unsignedBigInteger('updated_by')->default(0)->comment('更新人');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
            $table->unsignedInteger('deleted_at')->default(0)->comment('删除时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sys_dict_item` comment '字典类型'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sys_dict_item` AUTO_INCREMENT=1001");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_dict_item');
    }
};
