<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CouponsService;

class CouponsController
{
    protected $couponsService;

    public function __construct(CouponsService $couponsService)
    {
      $this->couponsService = $couponsService;
    }
    //////////////////////////////////////////

    public function create(Request $request) {
      $validated = couponDataValidator($request);
      
      if (!$validated['error']) {
        $result = $this->couponsService->register($validated['data']);
      }
      else {
        $result = ['error'=> true, 'data' => $validated['data'], 'code' => 422];
      }

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function update($id, Request $request) {
      $validated = couponDataValidator($request);
      
      if (!$validated['error']) {
        $result = $this->couponsService->update($id, $validated['data']);
      }
      else {
        $result = ['error'=> true, 'data' => $validated['data'], 'code' => 422];
      }

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function delete(Request $request) {
      $result = $this->couponsService->delete($id);
    
      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function getAll() {
      $coupons = $this->couponsService->getAll();

      return response()->json(['error' => false, 'data' => $coupons], 200);
    }
    //////////////////////////////////////////
  
    public function find($id) {
      $result = $this->couponsService->find($id);

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////
    
    public function getUsers($id) {
      $result = $this->couponsService->getUsers($id);

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
};
