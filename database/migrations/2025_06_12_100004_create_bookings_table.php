<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('用戶ID');
            $table->foreignId('room_id')->constrained()->onDelete('cascade')->comment('房間ID');
            $table->date('check_in_date')->comment('入住日期');
            $table->date('check_out_date')->comment('退房日期');
            $table->decimal('total_price', 10, 2)->comment('總價格');
            $table->integer('status')->comment('狀態：1:待確認 2:已確認 3:已取消 4:已完成');
            $table->integer('guest_count')->comment('入住人數');
            $table->text('special_requests')->nullable()->comment('特殊要求');
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete()->comment('優惠券ID');
            $table->decimal('discount_amount', 10, 2)->default(0)->comment('折扣金額');
            $table->timestamps();
            $table->softDeletes()->comment('軟刪除時間戳');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}; 