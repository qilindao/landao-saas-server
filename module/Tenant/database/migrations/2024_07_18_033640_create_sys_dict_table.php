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
        Schema::create('sys_dict', function (Blueprint $table) {
            $table->increments('dict_id');
            $table->string('name')->default('')->comment('字典键名');
            $table->string('title')->default('')->comment('中文释义');
            $table->unsignedTinyInteger('is_enable')->default(1)->comment('是否启用[1:启用;0:停用]');
            $table->string('remark')->default('')->comment('备注');
            $table->unsignedBigInteger('created_by')->default(0)->comment('创建人');
            $table->unsignedBigInteger('updated_by')->default(0)->comment('更新人');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
            $table->unsignedInteger('deleted_at')->default(0)->comment('删除时间');

            $table->unique('name', 'uk_sys_dict_name');
        });
        //表注释
        DB::statement("ALTER TABLE `sys_dict` comment '字典类型'");
        DB::statement("ALTER TABLE `sys_dict` AUTO_INCREMENT=1001");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_dict');
    }
};
