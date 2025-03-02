<?php

namespace App\Services;

use App\Repositories\UsersRepository;
use Illuminate\Support\Facades\Hash;


class UsersService 
{
    protected $usersRepository;

    public function __construct(UsersRepository $usersRepository) 
    {
        $this->usersRepository = $usersRepository;
    }
    
  public function register(array $data)
  {
        $user = $this->usersRepository->findByEmail($data['email']);
        if ($user) {
            return [
                'error' => true, 
                'data' => 'The email provided is already registered.', 
                'code' => 400
            ];
        }

        $user = $this->usersRepository->create($data);
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
    $user = $this->usersRepository->findByEmail($data['email']);

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
        $user = $this->usersRepository->findById($id);
      
        if (!$user) {
            return ['error' => true, 'data' => 'User not found.', 'code' => 400];
        }

        $user = $this->usersRepository->update($user, $data);
        return ['error' => false, 'data' => $user, 'code' => 200];
  }
  //////////////////////////////////////////

  public function delete($id)
  {
        $user = $this->usersRepository->findById($id);
        if (!$user) {
            return  ['error' => true, 'data' => 'User not found.', 'code' => 404];
        }

        $user->tokens()->delete();
        $this->usersRepository->delete($user);
        return ['error' => false, 'data' => 'User deleted successfully.', 'code' => 204];
  }
  //////////////////////////////////////////

  public function getAll()
  {
      return $this->usersRepository->getAll();
  }
  //////////////////////////////////////////

  public function find($id)
  {
    $user = $this->usersRepository->findById($id);

    if (!$user) {
        return ['error' => true, 'data' => 'User not found.', 'code' => 404];
    }

    return ['error' => false, 'data' => $user, 'code' => 200];
  }
}