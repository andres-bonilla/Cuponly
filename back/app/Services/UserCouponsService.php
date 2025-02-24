<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;
use App\Models\UserCoupon;
use App\Models\UsageStatus;
use Carbon\Carbon;
use Exception;


class UserCouponsService 
{
  public function getCoupons($id)
  {
        $user = User::find($id);

        if (!$user) {
            return ['error' => true, 'data' => 'User not found.', 'code' => 404];
        }

        return ['error' => false, 'data' => $user->coupons, 'code' => 200];
  }
  //////////////////////////////////////////

  public function getUsers($couponId)
  {
    $coupon = Coupon::find($couponId);

    if (!$coupon) {
        return ['error' => true, 'data' => 'Coupon not found.', 'code' => 404];
    }

    return ['error' => false, 'data' => $coupon->users, 'code' => 200];
  }
  //////////////////////////////////////////

  public function assign($id, $couponId)
  {
    $coupon = Coupon::find($couponId);
    $user = User::find($id);
    if (!$coupon || !$user) {
      return ['error' => true, 'data' => 'Resource not found.', 'code' => 400];
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


  public function update($id, $couponId, $status)
  {
    $userCoupon = UserCoupon::where('user_id', $id)
                            ->where('coupon_id', $couponId)
                            ->first();
    
    if (!$userCoupon) {
      return [
        'error' => true, 
        'data' => 'Update failed, please try again.', 
        'code' => 400
      ];
    }
    
    $userCoupon->usage_status = $status;
    $userCoupon->save();

    return [
      'error' => false, 
      'data' => $userCoupon, 
      'code' => 200
    ];
  }
  //////////////////////////////////////////

  public function invalidate($id){
    try {
      $now = Carbon::now();

      UserCoupon::where('user_id', $id) // Filtrar por usuario específico
        ->where('usage_status', UsageStatus::USED) // Solo cupones usados
        ->whereHas('coupon') // Solo si el cupón asociado existe
        ->get()
        ->each(function ($userCoupon) use ($now) { 
          //calculamos si ya paso el periodo de uso
            $period = $userCoupon->coupon->usage_period;
            $created = $userCoupon->created_at->copy();

            $expirationTime = $created->addHours($period);
            
            if ($expirationTime->lessThan($now)) {
                $userCoupon->update(['usage_status' => UsageStatus::INVALID]);
            }
        });
      
      return [
        'error' => false,
        'data' => 'Coupons invalidated successfully.',
        'code' => 200
      ];
    }
    catch (\Exception $e) {
      return [
        'error' => true,
        'data' => 'Failed to update coupons status.',
        'code' => 400
      ];
    }
  }
}