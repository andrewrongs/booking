<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('room_type_amenities', function (Blueprint $table) {
            $table->id()->comment('關聯ID');
            $table->foreignId('room_type_id')->constrained()->onDelete('cascade')->comment('房型ID');
            $table->foreignId('amenity_id')->constrained()->onDelete('cascade')->comment('設施ID');
            $table->timestamps();
            
            // 確保一個房型不會重複關聯同一個設施
            $table->unique(['room_type_id', 'amenity_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_type_amenities');
    }
}; 