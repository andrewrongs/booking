<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained()->onDelete('cascade')->comment('房型ID');
            $table->string('room_number')->unique()->comment('房間號碼');
            $table->integer('status')->comment('房間狀態：1:可用 2:已預訂 3:維護中');
            $table->integer('floor')->comment('樓層');
            $table->timestamps();
            $table->softDeletes()->comment('軟刪除時間戳');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}; 