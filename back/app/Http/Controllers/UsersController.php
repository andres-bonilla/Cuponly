<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsersService;

class UsersController
{
    protected $usersService;

    public function __construct(UsersService $usersService)
    {
      $this->usersService = $usersService;
    }

    public function create(Request $request) {
      $user = $this->usersService->create($request->all());

      return response()->json(['user', $user], 201);
    }
    //////////////////////////////////////////


    public function update(Request $request) {
      $user = $this->usersService->update($request->all());

      if (!$user) {
          return response()->json(['message' => 'User update failed.'], 400);
      }

      return response()->json(['user' => $user], 200);
    }
    //////////////////////////////////////////

    public function delete(Request $request) {
      $isDeleted = $this->usersService->delete($request->id);
      
      if (!$isDeleted) {
          return response()->json(['message' => 'User not found.'], 404);
      };
    
      return response()->json(['message' => 'User deleted successfully.'], 204);
    }
    //////////////////////////////////////////

    public function getAll() {
        $users = $this->usersService->getAll();

        return response()->json(['users' => $users], 200);
    }
    //////////////////////////////////////////
    
    public function find(Request $request) {
      $user = $this->usersService->find($request->id);

      if (!$user) {
          return response()->json(['message' => 'User not found.'], 404);
      }
      
      return response()->json(['user' => $user], 200);
    }
    //////////////////////////////////////////
    
    public function getCoupons(Request $request) {
        $coupons = $this->usersService->getCoupons($request->id);

        return response()->json(['coupons' => $coupons], 200);
    }
};