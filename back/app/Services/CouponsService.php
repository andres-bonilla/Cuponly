<?php

namespace App\Services;

use App\Models\Coupon;

class CouponsService 
{
  public function create(array $data)
  {
      return Coupon::create($data);
  }
  //////////////////////////////////////////

  public function update(array $data)
  {
        $coupon = $this->find($data['id']);
      
        if (!$coupon) {
            return null;
        }

        $coupon->update($data);
        return $coupon;
  }
  //////////////////////////////////////////

  public function delete($id)
  {
        $coupon = $this->find($id);

        if (!$coupon) {
            return false;
        }

          
        $coupon->delete();
        return true;
  }
  //////////////////////////////////////////

  public static function getAll()
  {
      return Coupon::all();
  }
  //////////////////////////////////////////

  public function find($id)
  {
      return Coupon::find($id);
  }
  //////////////////////////////////////////

  public function getUsers($id)
  {
        $coupon = $this->find($id);

        if (!$coupon) {
        return null;
        }

        return $coupon->users;
  }
}