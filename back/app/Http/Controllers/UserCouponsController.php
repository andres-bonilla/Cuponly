<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserCouponsService;

include_once(app_path('Http/Controllers/helpers/validators.php'));

class UserCouponsController
{
    protected $userCouponsService;

    public function __construct(UserCouponsService $userCouponsService)
    {
      $this->userCouponsService = $userCouponsService;
    }
    //////////////////////////////////////////
    
    public function getCoupons(Request $request, $id) {
      $validAccess = accessValidator($request, $id);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $result = $this->userCouponsService->getCoupons($id);

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////
    
    public function getUsers(Request $request, $couponId) {
      $validAccess = accessValidator($request, 0, false);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $result = $this->userCouponsService->getUsers($couponId);

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function assign(Request $request, $id, $couponId) {
      $validAccess = accessValidator($request, $id);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $result = $this->userCouponsService->assign($id, $couponId);
    
      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    //////////////////////////////////////////

    public function update($id, $couponId, Request $request) {
      $validAccess = accessValidator($request, $id);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }

      $validated = usageStatusValidator($request);

      if (!$validated['error']) {
        $result = $this->userCouponsService->update($id, $couponId, $validated['data']['status']);
      }
      else {
        $result = ['error'=> true, 'data' => $validated['data'], 'code' => 422];
      }

      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
    ////////////////////////////////////////

    public function invalidate(Request $request, $id) {
      $validAccess = accessValidator($request, $id);
      if (!$validAccess) {
        return response()->json(['error' => true, 'data' => 'Unauthorized'], 403);
      }
      
      $result = $this->userCouponsService->invalidate($id);
    
      return response()->json(['error' => $result['error'], 'data' => $result['data']], $result['code']);
    }
  }