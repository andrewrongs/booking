<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade')->comment('預訂ID');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('用戶ID');
            $table->integer('rating')->comment('評分(1-5)');
            $table->text('comment')->comment('評論內容');
            $table->boolean('is_public')->default(true)->comment('是否公開');
            $table->timestamps();
            $table->softDeletes()->comment('軟刪除時間戳');
            
            // 確保一個預訂只能有一個評價
            $table->unique('booking_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}; 