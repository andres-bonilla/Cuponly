<?php

namespace App\Services;

use App\Models\User;

class UsersService 
{
  public function register(array $data)
  {
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            return [
                'error' => true, 
                'data' => 'The email provided is already registered.', 
                'code' => 400
            ];
        }

        $user = User::create($data);
        if (!$user) {
            return [
                'error' => true, 
                'data' => 'Registration failed, please try again.', 
                'code' => 400
            ];
        }

        $token = $user->createToken('API Token')->plainTextToken;
        return [
            'error' => false, 
            'data' => ['user' => $user, 'token' => $token], 
            'code' => 201
        ];
  }
  //////////////////////////////////////////

  public function login($data) {
    $user = User::where('email', $data['email'])->first();

    // Si no existe o la contraseña es incorrecta, lanzar error
    if (!$user || !Hash::check($data['password'], $user->password)) {
        return ['error'=> true, 'data' => 'Invalid credentials.', 'code' => 401];
    }

    $token = $user->createToken('API Token')->plainTextToken;
    return [
        'error'=> false, 
        'data' => ['user' => $user, 'token' => $token], 
        'code' => 200
    ];
  }
  //////////////////////////////////////////

  public function update($id, array $data)
  {
        $user = $this->find($id);
      
        if (!$user) {
            return ['error' => true, 'data' => 'User not found.', 'code' => 400];
        }

        $user->update($data);
        return ['error' => false, 'data' => $user, 'code' => 200];
  }
  //////////////////////////////////////////

  public function delete($id)
  {
        $user = $this->find($id);
        if (!$user) {
            return  ['error' => true, 'data' => 'User not found.', 'code' => 404];
        }

        $user->delete();
        return ['error' => false, 'data' => 'User deleted successfully.', 'code' => 204];
  }
  //////////////////////////////////////////

  public static function getAll()
  {
      return User::all();
  }
  //////////////////////////////////////////

  public function find($id)
  {
    $user = $this->find($id);

    if (!$user) {
        return ['error' => true, 'data' => 'User not found.', 'code' => 404];
    }

    return ['error' => false, 'data' => $user, 'code' => 200];
  }
  //////////////////////////////////////////

  public function getCoupons($id)
  {
        $user = $this->find($id);

        if (!$user) {
            return ['error' => true, 'data' => 'User not found.', 'code' => 404];
        }

        return ['error' => false, 'data' => $user->coupons, 'code' => 200];
  }
}