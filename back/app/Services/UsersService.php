<?php

namespace App\Services;

use App\Models\User;

class UsersService 
{
  public function create(array $data)
  {
      return User::create($data);
  }
  //////////////////////////////////////////

  public function update(array $data)
  {
        $user = $this->find($data['id']);
      
        if (!$user) {
            return null;
        }

        $user->update($data);
        return $user;
  }
  //////////////////////////////////////////

  public function delete($id)
  {
        $user = $this->find($id);

        if (!$user) {
            return false;
        }

        $user->delete();
        return true;
  }
  //////////////////////////////////////////

  public static function getAll()
  {
      return User::all();
  }
  //////////////////////////////////////////

  public function find($id)
  {
      return User::find($id);
  }
  //////////////////////////////////////////

  public function getCoupons($id)
  {
        $user = $this->find($id);

        if (!$user) {
        return null;
        }

        return $user->coupons;
  }
}