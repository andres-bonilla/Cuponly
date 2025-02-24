<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
    'redeem_expiration'
  ];

  protected $casts = [
    'usage_status' => UsageStatus::class,
    'redeem_expiration' => 'datetime',
  ];

  protected static function booted()
  {
    static::creating(function ($userCoupon) {
      // Generar un código único para la relación
      $userId = $userCoupon->user_id;
      $couponId = $userCoupon->coupon_id;
      $userCoupon->code = $userId.'-'.Str::upper(Str::random(3)).'-'.$couponId;

      // Generar la fecha de expiracion para uso del cupon que tiene el usuario
      $usagePeriod = $userCoupon->coupon->usage_period ?? 0;
      $userCoupon->redeem_expiration = Carbon::now()->addHours($usagePeriod);
    });
  }

  public function coupon() {
    return $this->belongsTo(Coupon::class);
  }

  public function user() {
    return $this->belongsTo(User::class);
  }
}