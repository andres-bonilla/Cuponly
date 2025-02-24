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
      $validAccess = accessValidator($request, $id);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

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

    public function delete($id, Request $request) {
      $validAccess = accessValidator($request, $id);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $result = $this->usersService->delete($id);
    
      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function getAll(Request $request) {
      $validAccess = accessValidator($request, 0, false);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $users = $this->usersService->getAll();

      return response()->json(['error' => false, 'data' => $users], 200);
    }
    //////////////////////////////////////////
    
    public function find($id, Request $request) {
      $validAccess = accessValidator($request, $id);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $result = $this->usersService->find($id);

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
};