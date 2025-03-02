<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Models\CouponStatus;

class CouponsRepository
{
  public function create(array $data)
  {
    return Coupon::create($data);
  }
  //////////////////////////////////////////

  public function update(Coupon $coupon, array $data)
  {
    $coupon->update($data);
    return $coupon;
  }
  //////////////////////////////////////////

  public function delete(Coupon $coupon)
  {
    $coupon->delete();
  }
  //////////////////////////////////////////

  public function getAll()
  {
    return Coupon::all();
  }
  //////////////////////////////////////////

  public function findById($id)
  {
    return Coupon::find($id);
  }
  //////////////////////////////////////////

  public function filterByStatus($status)
  {
    return Coupon::where('status', $status)->get();
  }
  //////////////////////////////////////////

  public function countByStatus($status)
  {
    return Coupon::where('status', $status)->count();
  }
  //////////////////////////////////////////

  public function expire()
  {
    return Coupon::where('status', CouponStatus::VALID)//De los cupones validos
                  ->where('expiration', '<', now()) // Solo los que ya caducaron
                  ->update(['status' => CouponStatus::EXPIRED]); // Marcar como expirados
  }

}