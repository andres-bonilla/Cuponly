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

  public function coupon() {
    return $this->belongsTo(Coupon::class);
  }

  public function user() {
    return $this->belongsTo(User::class);
  }
}