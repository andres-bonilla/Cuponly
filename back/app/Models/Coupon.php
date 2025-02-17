<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

enum CouponStatus: string {
  case VALID = 'valid';
  case DRAINED = 'drained';
  case EXPIRED = 'expired';
}

class Coupon extends Model {
  protected $fillable = [
    'brand',
    'discount',
    'status',
    'expiration',
    'usage_period'
  ];

  protected function casts(): array 
  {
    return [
      'status' => CouponStatus::class,
      'discount' => 'integer',
      'expiration' => 'datetime',
      'usage_period' => 'integer',
    ];
  }

  public function users() {
    return $this->belongsToMany(User::class, 'user_coupons')
        ->withPivot('usage_status', 'code')
        ->withTimestamps();
  }
}