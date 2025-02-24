<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CouponsService;

include_once(app_path('Http/Controllers/helpers/validators.php'));

class CouponsController
{
    protected $couponsService;

    public function __construct(CouponsService $couponsService)
    {
      $this->couponsService = $couponsService;
    }
    //////////////////////////////////////////

    public function create(Request $request) {
      $validAccess = accessValidator($request, 0, false);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $validated = couponDataValidator($request);
      
      if (!$validated['error']) {
        $result = $this->couponsService->create($validated['data']);
      }
      else {
        $result = ['error'=> true, 'data' => $validated['data'], 'code' => 422];
      }

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function expire() {
      $result = $this->couponsService->expire();
    
      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function update($id, Request $request) {
      $validAccess = accessValidator($request, 0, false);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

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

    public function delete($id, Request $request) {
      $validAccess = accessValidator($request, 0, false);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $result = $this->couponsService->delete($id);
    
      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function getAll(Request $request) {
      $validAccess = accessValidator($request, 0, false);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $coupons = $this->couponsService->getAll();

      return response()->json(['error' => false, 'data' => $coupons], 200);
    }
    //////////////////////////////////////////

    public function filter($status, Request $request) {
      $validAccess = accessValidator($request, 0, false);
      if (!($status == 'valid' || $validAccess)) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $validated = couponStatusValidator($status);
      
      if (!$validated['error']) {
        $result = $this->couponsService->filter($status);
      }
      else {
        $result = ['error'=> true, 'data' => $validated['data'], 'code' => 422];
      }

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    /////////////////////////////////////////
  
    public function find($id) {
      $result = $this->couponsService->find($id);

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
};
