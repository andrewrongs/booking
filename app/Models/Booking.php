<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'total_price',
        'status',  
        'guest_count',
        'special_requests',
        'coupon_id',
        'discount_amount',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    /**
     * 預訂狀態常數
     */
    const STATUS_PENDING = 1;      // 待確認
    const STATUS_CONFIRMED = 2;    // 已確認
    const STATUS_CANCELLED = 3;    // 已取消
    const STATUS_COMPLETED = 4;    // 已完成

    /**
     * 取得此預訂的用戶
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 取得此預訂的房間
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * 取得此預訂的優惠券
     */
    public function coupon()
    {
        return $this->belongsTo(Coupons::class);
    }

    /**
     * 取得此預訂的評價
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * 檢查預訂是否可以被取消
     */
    public function canBeCancelled()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    /**
     * 計算預訂天數
     */
    public function getNightsAttribute()
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }
} 