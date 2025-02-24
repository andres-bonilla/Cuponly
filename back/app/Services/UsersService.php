<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


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

  public function login(array $data) {
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

    public function logout($request)
    {
        //$request->user()->tokens->each(function ($token) {
          //  $token->delete();
        //});

        if ($request->user()) {
            $request->user()->tokens->each(function ($token) {
                $token->delete();
            });
        } else {
            return [
                'error' => true,
                'data' => 'User is not authenticated',
                'code' => 401];
        }

        return [
            'error' => false,
            'data' => 'Logged out successfully.',
            'code' => 200
        ];
    }
    //////////////////////////////////////////

  public function update($id, array $data)
  {
        $user = User::find($id);
      
        if (!$user) {
            return ['error' => true, 'data' => 'User not found.', 'code' => 400];
        }

        $user->update($data);
        return ['error' => false, 'data' => $user, 'code' => 200];
  }
  //////////////////////////////////////////

  public function delete($id)
  {
        $user = User::find($id);
        if (!$user) {
            return  ['error' => true, 'data' => 'User not found.', 'code' => 404];
        }

        $user->tokens()->delete();
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
    $user = User::find($id);

    if (!$user) {
        return ['error' => true, 'data' => 'User not found.', 'code' => 404];
    }

    return ['error' => false, 'data' => $user, 'code' => 200];
  }
}