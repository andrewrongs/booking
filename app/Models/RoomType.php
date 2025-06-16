<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'capacity',
        'image_url',
    ];

    /**
     * 取得此房型的所有房間
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * 取得此房型的所有設施
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_type_amenities')
            ->withTimestamps();
    }
} 