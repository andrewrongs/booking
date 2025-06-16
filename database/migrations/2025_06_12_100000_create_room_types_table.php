<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('房型名稱');
            $table->text('description')->comment('房型描述');
            $table->decimal('price', 10, 2)->comment('房型價格');
            $table->integer('capacity')->comment('可容納人數');
            $table->string('image_url')->nullable()->comment('房型圖片URL');
            $table->timestamps();
            $table->softDeletes()->comment('軟刪除時間戳');
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_types');
    }
}; 