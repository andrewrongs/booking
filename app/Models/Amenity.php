<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amenity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'icon_url',
    ];

    /**
     * 取得擁有此設施的所有房型
     */
    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'room_type_amenities')
            ->withTimestamps();
    }
} 