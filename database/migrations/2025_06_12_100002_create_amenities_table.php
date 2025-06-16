<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('設施名稱');
            $table->text('description')->nullable()->comment('設施描述');
            $table->string('icon_url')->nullable()->comment('設施圖示URL');
            $table->timestamps();
            $table->softDeletes()->comment('軟刪除時間戳');
        });
    }

    public function down()
    {
        Schema::dropIfExists('amenities');
    }
}; 