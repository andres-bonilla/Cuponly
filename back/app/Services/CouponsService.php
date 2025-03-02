<?php

namespace App\Services;

use App\Repositories\CouponsRepository;


class CouponsService 
{
  protected $couponsRepository;

  public function __construct(CouponsRepository $couponsRepository) 
  {
      $this->couponsRepository = $couponsRepository;
  }
  
  public function create(array $data)
  {
    $coupon = $this->couponsRepository->create($data);
    if (!$coupon) {
        return [
            'error' => true, 
            'data' => 'Creation failed, please try again.', 
            'code' => 400
        ];
    }
    return [
        'error' => false, 
        'data' => $coupon, 
        'code' => 201
    ];
  }
  //////////////////////////////////////////

  public function expire(){
    $this->couponsRepository->expire();
     
    return $this->generate();
  }
  //////////////////////////////////////////

  public function generate(){
    $count = $this->couponsRepository->countByStatus('valid');

    if ($count >= 18) {
        return [
            'error' => false,
            'data' => 'There are already 18 valid coupons.',
            'code' => 200
          ];
    }

    $brands = ['Adidas', 'Asics', 'Fila', 'Hummel', 'Joma', 'Kelme', 'Le Coq', 'Mizuno', 'New Balance', 'Nike', 'Olympikus', 'Puma', 'Reebok', 'Under Armour', 'Umbro'];

    while ($count < 18) {
      $this->couponsRepository->create([
          'brand' => $brands[array_rand($brands)],
          'discount' => rand(2, 13) * 5,
          'status' => 'valid',
          'expiration' => now()->addDays(rand(1, 20))->addMinutes(rand(1, 4) * 15)->addSeconds(rand(1, 60)),
          'usage_period' => rand(12, 72),
      ]);
      $count++;
    }

    return [
      'error' => false,
      'data' => 'Coupons generated successfully.',
      'code' => 201
    ];
  }
  //////////////////////////////////////////

  public function update($id, array $data)
  {
    $coupon = $this->couponsRepository->findById($id);
      
    if (!$coupon) {
        return ['error' => true, 'data' => 'Coupon not found.', 'code' => 400];
    }

    $coupon = $this->couponsRepository->update($coupon, $data);
    return ['error' => false, 'data' => $coupon, 'code' => 200];
  }
  //////////////////////////////////////////

  public function delete($id)
  {
    $coupon = $this->couponsRepository->findById($id);
    if (!$coupon) {
        return  ['error' => true, 'data' => 'Coupon not found.', 'code' => 404];
    }

    $this->couponsRepository->delete($coupon);
    return ['error' => false, 'data' => 'Coupon deleted successfully.', 'code' => 204];
  }
  //////////////////////////////////////////

  public static function getAll()
  {
      return $this->couponsRepository->getAll();
  }
  //////////////////////////////////////////

  public function filter($status) {
    $coupons = $this->couponsRepository->filterByStatus($status);

    return ['error' => false, 'data' => $coupons, 'code' => 200];
  }
  //////////////////////////////////////////

  public function find($id)
  {
    $coupon = $this->couponsRepository->findById($id);

    if (!$coupon) {
        return ['error' => true, 'data' => 'Coupon not found.', 'code' => 404];
    }

    return ['error' => false, 'data' => $coupon, 'code' => 200];
  }
}