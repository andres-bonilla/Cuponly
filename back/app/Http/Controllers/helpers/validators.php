<?php

use Illuminate\Validation\ValidationException;

function userDataValidator($request){
  try {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|confirmed|min:8',
    ]);

    return ['error' => false, 'data' => $data];
  }
  catch (ValidationException $error) {
    return ['error' => true, 'data' => 'Registration data not valid.'];
  }
}

function userCredentialsValidator($request) {
  try {
    $data = $request->validate([
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    return ['error' => false, 'data' => $data];
  }
  catch (ValidationException $error) {
    return ['error' => true, 'data' => 'Credential data not valid.'];
  }
}

function couponDataValidator($request) {
  try {
    $data = $request->validate([
      'brand' => 'required|string|max:255',
      'discount' => 'required|integer|min:1|max:100',
      'expiration' => 'required|date|after:today',
      'usage_period' => 'required|integer|min:1'
    ]);

    return ['error' => false, 'data' => $data];
  }
  catch (ValidationException $error) {
    return ['error' => true, 'data' => 'Coupon data not valid.'];
  }
}

function couponStatusValidator($status) {
    $validStatuses = ['valid', 'drained', 'expired'];

    if (!in_array($status, $validStatuses)) {
        return ['error' => true, 'data' => 'Invalid status provided.','code' => 400];
    }

    return ['error' => false, 'data' => $status,'code' => 200];
}