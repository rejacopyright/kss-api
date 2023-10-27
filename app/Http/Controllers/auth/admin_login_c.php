<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Str;

class admin_login_c extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin-api', ['except' => ['login']]);
  }

  function login(Request $r)
  {
    $credentials = $r->only('username', 'password');
    $token = auth('admin-api')->attempt($credentials);
    if (!$token) {
      return response()->json(['success' => false, 'message' => 'username dan password tidak cocok']);
    } else {
      // return auth('admin-api')->user();
      $token = auth('admin-api')->claims(['updated_at' => strtotime('now'), 'user' => auth('admin-api')->user()->first()])->attempt($credentials);
      $user = auth('admin-api')->user();
      $user->avatar = $user->avatar ? asset("/storage/admin/$user->avatar") : null;
      $token = $this->respondWithToken($token)->original;
      return response()->json([
        'success' => true,
        'user' => $user,
        'token' => $token,
        'message' => 'berhasil login'
      ]);
      return response()->json(compact('user', 'token'));
    }
  }

  public function logout()
  {
    auth()->logout(true);
    return response()->json(['message' => 'Successfully logged out']);
  }

  public function refresh()
  {
    return $this->respondWithToken(auth('admin-api')->refresh());
  }

  protected function respondWithToken($token)
  {
    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth('admin-api')->factory()->getTTL() * 1
    ]);
  }

  public function me()
  {
    return response()->json(auth('admin-api')->user());
  }
}
