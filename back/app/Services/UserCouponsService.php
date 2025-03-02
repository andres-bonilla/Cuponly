<?php

namespace App\Services;

use App\Repositories\UsersRepository;
use App\Repositories\CouponsRepository;
use App\Repositories\UserCouponsRepository;
use Exception;


class UserCouponsService 
{
  protected $userCouponsRepository;
  protected $usersRepository;
  protected $couponsRepository;

  public function __construct(UserCouponsRepository $userCouponsRepository, UsersRepository $usersRepository, CouponsRepository $couponsRepository) 
  {
      $this->userCouponsRepository = $userCouponsRepository;
      $this->usersRepository = $usersRepository;
      $this->couponsRepository = $couponsRepository;
  }
  
  public function getCoupons($id)
  {
        $user = $this->usersRepository->findById($id);
        if (!$user) {
            return ['error' => true, 'data' => 'User not found.', 'code' => 404];
        }

        $coupons = $this->userCouponsRepository->getCoupons($user);
        return ['error' => false, 'data' => $coupons, 'code' => 200];
  }
  //////////////////////////////////////////

  public function getUsers($couponId)
  {
    $coupon = $this->couponsRepository->findById($couponId);
    if (!$coupon) {
        return ['error' => true, 'data' => 'Coupon not found.', 'code' => 404];
    }

    $users = $this->userCouponsRepository->getUsers($coupon);
    return ['error' => false, 'data' => $users, 'code' => 200];
  }
  //////////////////////////////////////////

  public function assign($id, $couponId)
  {
    $coupon = $this->couponsRepository->findById($couponId);
    $user = $this->usersRepository->findById($id);
    if (!$coupon || !$user) {
      return ['error' => true, 'data' => 'Resource not found.', 'code' => 400];
    }

    $userCoupon = $this->userCouponsRepository->assign($id, $couponId);
    if (!$userCoupon) {
      return [
          'error' => true, 
          'data' => 'Creation failed, please try again.', 
          'code' => 400
      ];
    }

    return [
        'error' => false, 
        'data' => 'Coupon assigned successfully.', 
        'code' => 201
    ];
  }
  //////////////////////////////////////////


  public function update($id, $couponId, $status)
  {
    $userCoupon = $this->userCouponsRepository->find($id, $couponId);
    
    if (!$userCoupon) {
      return [
        'error' => true, 
        'data' => 'Update failed, please try again.', 
        'code' => 400
      ];
    }
    
    $userCoupon = $this->userCouponsRepository->updateStatus($userCoupon, $status);

    return [
      'error' => false, 
      'data' => $userCoupon, 
      'code' => 200
    ];
  }
  //////////////////////////////////////////

  public function invalidate($id){
    try {
      $this->userCouponsRepository->invalidate($id);
      
      return [
        'error' => false,
        'data' => 'Coupons invalidated successfully.',
        'code' => 200
      ];
    }
    catch (\Exception $e) {
      return [
        'error' => true,
        'data' => 'Failed to update coupons status.',
        'code' => 400
      ];
    }
  }
}