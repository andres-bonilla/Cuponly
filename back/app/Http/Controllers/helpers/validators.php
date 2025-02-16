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