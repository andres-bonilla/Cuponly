<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsersService;

include_once(app_path('Http/Controllers/helpers/validators.php'));

class UsersController
{
    protected $usersService;

    public function __construct(UsersService $usersService)
    {
      $this->usersService = $usersService;
    }
    //////////////////////////////////////////

    public function register(Request $request) {
      $validated = userDataValidator($request);
      
      if (!$validated['error']) {
        $result = $this->usersService->register($validated['data']);
      }
      else {
        $result = ['error'=> true, 'data' => $validated['data'], 'code' => 422];
      }

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function login(Request $request) {
      $validated = userCredentialsValidator($request);

      if (!$validated['error']) {
        $result = $this->usersService->login($validated['data']);
      }
      else {
        $result = ['error'=> true, 'data' => $validated['data'], 'code' => 422];
      }

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function logout(Request $request) {
      $result = $this->usersService->logout($request);

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function update($id, Request $request) {
      $validated = userDataValidator($request);
      
      if (!$validated['error']) {
        $result = $this->usersService->update($id, $validated['data']);
      }
      else {
        $result = ['error'=> true, 'data' => $validated['data'], 'code' => 422];
      }

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function delete($id) {
      $result = $this->usersService->delete($id);
    
      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function getAll() {
        $users = $this->usersService->getAll();

        return response()->json(['error' => false, 'data' => $users], 200);
    }
    //////////////////////////////////////////
    
    public function find($id) {
      $result = $this->usersService->find($id);

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////
    
    public function getCoupons($id) {
        $result = $this->usersService->getCoupons($id);

        return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
};