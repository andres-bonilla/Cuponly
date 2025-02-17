<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponStatus;

class CouponsService 
{
  public function create(array $data)
  {
    $coupon = Coupon::create($data);
    if (!$coupon) {
        return [
            'error' => true, 
            'data' => 'Creation failed, please try again.', 
            'code' => 400
        ];
    }
    return [
        'error' => false, 
        'data' => $coupon, 
        'code' => 201
    ];
  }
  //////////////////////////////////////////

  public function assign($couponId, $id)
  {
    $coupon = Coupon::find($couponId);
    $user = User::find($id);
    if (!$coupon || !$user) {
      return ['error' => true, 'data' => 'Resourse not found.', 'code' => 400];
    }

    $userCoupon = UserCoupon::create([
      'user_id' => $id,
      'coupon_id' => $couponId,
    ]);
    if (!$userCoupon) {
      return [
          'error' => true, 
          'data' => 'Creation failed, please try again.', 
          'code' => 400
      ];
    }

    return [
        'error' => false, 
        'data' => 'Coupon assigned successfully.', 
        'code' => 201
    ];
  }
  //////////////////////////////////////////

  public function generate(){
    $count = Coupon::where('status', CouponStatus::VALID)->count();

    if ($count >= 20) {
        return [
            'error' => false,
            'data' => 'There are already 20 valid coupons.',
            'code' => 200
          ];
    }

    $brands = ['Nike', 'Adidas', 'Puma', 'Reebok', 'Under Armour'];

    while ($count < 20) {
      Coupon::create([
          'brand' => $brands[array_rand($brands)],
          'discount' => rand(1, 13) * 5,
          'status' => CouponStatus::VALID,
          'expiration' => now()->addDays(rand(1, 20)),
          'usage_period' => rand(12, 72),
      ]);
      $count++;
    }

    return [
      'error' => false,
      'data' => 'Coupons generated successfully.',
      'code' => 201
    ];
  }
  //////////////////////////////////////////

  public function update($id, array $data)
  {
    $coupon = Coupon::find($id);
      
    if (!$coupon) {
        return ['error' => true, 'data' => 'Coupon not found.', 'code' => 400];
    }

    $coupon->update($data);
    return ['error' => false, 'data' => $coupon, 'code' => 200];
  }
  //////////////////////////////////////////

  public function delete($id)
  {
    $coupon = Coupon::find($id);
    if (!$coupon) {
        return  ['error' => true, 'data' => 'Coupon not found.', 'code' => 404];
    }

    $coupon->delete();
    return ['error' => false, 'data' => 'Coupon deleted successfully.', 'code' => 204];
  }
  //////////////////////////////////////////

  public static function getAll()
  {
      return Coupon::all();
  }
  //////////////////////////////////////////

  public function filter($status) {
    $coupons = Coupon::where('status', $status)->get();

    return ['error' => false, 'data' => $coupons, 'code' => 200];
  }
  //////////////////////////////////////////

  public function find($id)
  {
    $coupon = Coupon::find($id);

    if (!$coupon) {
        return ['error' => true, 'data' => 'Coupon not found.', 'code' => 404];
    }

    return ['error' => false, 'data' => $coupon, 'code' => 200];
  }
  //////////////////////////////////////////

  public function getUsers($id)
  {
    $coupon = Coupon::find($id);

    if (!$coupon) {
        return ['error' => true, 'data' => 'Coupon not found.', 'code' => 404];
    }

    return ['error' => false, 'data' => $coupon->users, 'code' => 200];
  }
}