<?php

use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

function userDataValidator($request){
  try {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|confirmed|min:8',
      'is_admin' => 'boolean'
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

function usageStatusValidator($request) {
  try {
    $data = $request->validate([
      'status' => ['required', Rule::in(['used', 'redeemed', 'invalid'])]
    ]);

    return ['error' => false, 'data' => $data];
  }
  catch (ValidationException $error) {
    return ['error' => true, 'data' => 'Invalid status provided.'];
  }
}

function accessValidator($request, $id, $checkId = true, $checkAdmin = true) {
  if ($request->user()) {
    $isSameId = $checkId ? $request->user()->id == $id : false;
    $isAdmin = $checkAdmin ? $request->user()->is_admin : false;

    return $isSameId || $isAdmin;
  }

  return false;
}