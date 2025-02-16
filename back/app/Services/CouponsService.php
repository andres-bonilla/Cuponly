<?php

namespace App\Services;

use App\Models\Coupon;

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

  public function update($id, array $data)
  {
    $coupon = $this->find($id);
      
    if (!$coupon) {
        return ['error' => true, 'data' => 'Coupon not found.', 'code' => 400];
    }

    $coupon->update($data);
    return ['error' => false, 'data' => $coupon, 'code' => 200];
  }
  //////////////////////////////////////////

  public function delete($id)
  {
    $coupon = $this->find($id);
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

  public function find($id)
  {
    $coupon = $this->find($id);

    if (!$coupon) {
        return ['error' => true, 'data' => 'Coupon not found.', 'code' => 404];
    }

    return ['error' => false, 'data' => $coupon, 'code' => 200];
  }
  //////////////////////////////////////////

  public function getUsers($id)
  {
    $coupon = $this->find($id);

    if (!$coupon) {
        return ['error' => true, 'data' => 'Coupon not found.', 'code' => 404];
    }

    return ['error' => false, 'data' => $coupon->users, 'code' => 200];
  }
}