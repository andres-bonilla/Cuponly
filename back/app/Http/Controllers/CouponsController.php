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

    public function create(Request $request) {
      $coupon = $this->couponsService->create($request->all());

      return response()->json(['coupon', $coupon], 201);
    }
    //////////////////////////////////////////

    public function update(Request $request) {
      $coupon = $this->couponsService->update($request->all());

      if (!$coupon) {
          return response()->json(['message' => 'Coupon update failed.'], 400);
      }

      return response()->json(['coupon' => $coupon], 200);
    }
    //////////////////////////////////////////

    public function delete(Request $request) {
      $isDeleted = $this->couponsService->delete($request->id);
      
      if (!$isDeleted) {
          return response()->json(['message' => 'Coupon not found.'], 404);
      };
    
      return response()->json(['message' => 'Coupon deleted successfully.'], 204);
    }
    //////////////////////////////////////////

    public function getAll() {
        $coupons = $this->couponsService->getAll();

        return response()->json(['coupons' => $coupons], 200);
    }
    //////////////////////////////////////////
  
    public function find(Request $request) {
      $coupon = $this->couponsService->find($request->id);

      if (!$coupon) {
        return response()->json(['message' => 'Coupon not found.'], 404);
      }
    
      return response()->json(['coupon' => $coupon], 200);
    }
    //////////////////////////////////////////
    
    public function getUsers(Request $request) {
        $users = $this->couponsService->getUsers($request->id);

        return response()->json(['users' => $users], 200);
    }
};
