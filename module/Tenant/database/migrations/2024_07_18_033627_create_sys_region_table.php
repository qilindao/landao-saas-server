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
        Schema::create('sys_region', function (Blueprint $table) {
            $table->unsignedInteger('region_id')->default(0)->primary()->comment('行政区域划分ID');
            $table->unsignedInteger('parent_id')->default(0)->index('idx_sys_region_parent_id')->comment('行政区域划分父ID');
            $table->unsignedSmallInteger('depth')->default(1)->comment('深度');
            $table->string('name',32)->default('')->comment('行政简称');
            $table->string('fullname',60)->default('')->comment('行政全称');
            $table->string('pinyin')->default('')->comment('拼音');
            $table->string('pinyin_arr')->default('')->comment('拼音,逗号隔开');
            $table->decimal('latitude',10,8)->default(0.0)->comment('纬度');
            $table->decimal('longitude',11,8)->default(0.0)->comment('经度');
            $table->unique('region_id','uk_sys_region_id');
        });
        //表注释
        DB::statement("ALTER TABLE `sys_region` comment '行政区域划分'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_region');
    }
};
