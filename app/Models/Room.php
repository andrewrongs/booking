<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_type_id',
        'room_number',
        'status',
        'floor',
    ];

    /**
     * 房間狀態常數
     */
    const STATUS_AVAILABLE = 1;     // 可用
    const STATUS_BOOKED = 2;        // 已預訂
    const STATUS_MAINTENANCE = 3;   // 維護中

    /**
     * 取得此房間的房型
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * 取得此房間的所有預訂
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * 檢查房間是否可用
     */
    public function isAvailable() : bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }
} 