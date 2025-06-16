<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'user_id',
        'rating',
        'comment',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * 取得此評價的預訂
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * 取得此評價的用戶
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 評分範圍驗證規則
     */
    public static function ratingRules()
    {
        return ['required', 'integer', 'min:1', 'max:5'];
    }
} 