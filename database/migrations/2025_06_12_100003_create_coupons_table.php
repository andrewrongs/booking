<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('優惠碼');
            $table->integer('discount_type')->comment('折扣類型：1:固定金額 2:百分比');
            $table->decimal('discount_value', 10, 2)->comment('折扣值');
            $table->integer('usage_limit')->nullable()->comment('使用次數限制');
            $table->integer('used_count')->default(0)->comment('已使用次數');
            $table->date('start_date')->comment('開始日期');
            $table->date('end_date')->comment('結束日期');
            $table->boolean('status')->default(true)->comment('狀態：啟用/停用');
            $table->decimal('minimum_amount', 10, 2)->default(0)->comment('最低消費金額');
            $table->decimal('maximum_discount', 10, 2)->nullable()->comment('最高折扣金額');
            $table->timestamps();
            $table->softDeletes()->comment('軟刪除時間戳');
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}; 