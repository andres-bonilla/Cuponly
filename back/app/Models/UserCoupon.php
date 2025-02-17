<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

enum UsageStatus: string {
  case USED = 'used';
  case REDEEMED = 'redeemed';
  case INVALID = 'invalid';
}

class UserCoupon extends Model {
  protected $fillable = [
    'user_id',
    'coupon_id',
    'code',
    'usage_status',
  ];

  protected $casts = [
    'usage_status' => UsageStatus::class,
  ];

  protected static function booted()
  {
    static::creating(function ($userCoupon) {
      // Generar un código único para la relación
      $userCoupon->code = Str::random(4).'-'.Str::random(3); 
    });
  }

  public function coupon() {
    return $this->belongsTo(Coupon::class);
  }

  public function user() {
    return $this->belongsTo(User::class);
  }
}