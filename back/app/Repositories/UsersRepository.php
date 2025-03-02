<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository
{
  public function create(array $data)
  {
    return User::create($data);
  }
  //////////////////////////////////////////

  public function update(User $user, array $data)
  {
    $user->update($data);
    return $user;
  }
  //////////////////////////////////////////

  public function delete(User $user)
  {
    $user->delete();
  }
  //////////////////////////////////////////

  public function getAll()
  {
    return User::all();
  }
  //////////////////////////////////////////

  public function findById($id)
  {
    return User::find($id);
  }
  //////////////////////////////////////////

  public function findByEmail($email)
  {
    return User::where('email', $email)->first();
  }
}