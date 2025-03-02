<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Coupon;
use App\Models\UserCoupon;
use App\Models\UsageStatus;
use Carbon\Carbon;

class UserCouponsRepository
{
    public function getCoupons(User $user)
    {
        return $user->coupons;
    }
    //////////////////////////////////////////

    public function getUsers(Coupon $coupon)
    {
        return $coupon->users;
    }
    //////////////////////////////////////////

    public function assign($userId, $couponId)
    {
        return UserCoupon::create([
            'user_id' => $userId,
            'coupon_id' => $couponId,
        ]);
    }
    //////////////////////////////////////////

    public function find($userId, $couponId)
    {
        return UserCoupon::where('user_id', $userId)
                          ->where('coupon_id', $couponId)
                          ->first();
    }
    //////////////////////////////////////////

    public function updateStatus(UserCoupon $userCoupon, $status)
    {
      $userCoupon->update(['usage_status' => $status]);
      return $userCoupon;
    }
    //////////////////////////////////////////

    public function invalidate($userId)
    {
      $now = Carbon::now();

      return UserCoupon::where('user_id', $userId) // Filtrar por usuario específico
        ->where('usage_status', UsageStatus::USED) // Solo cupones usados
        ->whereHas('coupon') // Solo si el cupón asociado existe
        ->get() // Por cada cupon calculamos si ya paso el periodo de uso
        ->each(function ($userCoupon) use ($now) { 
            $period = $userCoupon->coupon->usage_period;
            $created = $userCoupon->created_at->copy();

            // Calculamos fecha de expiracion
            $expirationTime = $created->addHours($period);
            
            if ($expirationTime->lessThan($now)) {
                $userCoupon->update(['usage_status' => UsageStatus::INVALID]);
            }
        });
    }
}