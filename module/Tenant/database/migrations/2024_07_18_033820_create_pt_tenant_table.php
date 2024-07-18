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
        Schema::create('pt_tenant', function (Blueprint $table) {
            $table->id('tenant_id');
            $table->string('tenant_name')->default('')->comment('租户名');
            $table->unsignedInteger('user_limit')->default(0)->comment('用户数量限制,0代表不限制用户数');
            $table->unsignedTinyInteger('is_enable')->default(1)->comment('是否启用[1:启用;0:停用]');
            $table->unsignedTinyInteger('is_super')->default(0)->comment('是否超级租户[1:是;0:否]');
            $table->unsignedTinyInteger('is_free')->default(0)->comment('是否免费[1:是;0:否]');
            $table->unsignedInteger('package_id')->default(0)->index('idx_tenant_package_id')->comment('租户套餐id');
            $table->string('contact_name', 30)->default('')->comment('联系人');
            $table->string('contact_phone', 20)->default('')->comment('联系人电话');
            $table->string('domain')->default('');
            $table->string('database')->default('');
            $table->string('contact_phone_search', 500)->default('')->index('idx_tenant_phone')->comment('联系人电话');
            $table->string('remark')->default('')->comment('备注');
            $table->unsignedBigInteger('created_by')->default(0)->comment('创建人');
            $table->unsignedBigInteger('updated_by')->default(0)->comment('更新人');
            $table->unsignedInteger('expired_at')->default(0)->comment('到期时间');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
            $table->unsignedInteger('deleted_at')->default(0)->comment('删除时间');
        });
        //表注释
        DB::statement("ALTER TABLE `pt_tenant` comment '系统租户'");
        DB::statement("ALTER TABLE `pt_tenant` AUTO_INCREMENT=1001");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_tenant');
    }
};
