<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as req;
use App\Models\admin;
use Mail;
use Validator;
use Hash;

class admin_password_c extends Controller
{
    function forgot(req $r)
    {
        $admin = admin::where('username', $r->user)->orWhere('email', $r->user)->first();
        if ($admin !== null) {
            if ($admin->email) {
                $token = auth('admin-api')->setTTL(60 * 2)->claims(['created_at' => strtotime('now'), 'user' => $admin])->fromUser($admin);
                $data = ['url' => $r->url, 'token' => $token];
                Mail::send(['html' => 'mail.forgot-password'], compact('data'), function ($mail) use ($admin) {
                    $mail->to($admin->email, $admin->name)->subject('Reset Password Request');
                    // $mail->from('test@gmail.com', 'Krakatau Samudera Solusi');
                });
                return response()->json(['success' => true, 'user' => $admin], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Anda belum mendaftarkan email. Silahkan hubungi bantuan teknisi'], 401);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Kami tidak dapat menemukan username atau email yang anda masukan'], 401);
        }
        return $admin->email;
        return ['success' => false, 'data' => $admin];
    }

    function reset(req $r)
    {
        // VALIDATION
        $v_rules = ['password' => 'confirmed'];
        $v_attr = ['password' => 'Kata sandi'];
        $v = Validator::make($r->all(), $v_rules, [], $v_attr);
        if ($v->fails()) {
            return response()->json(['data' => $v->errors(), 'req' => $r->all()], 422);
        }

        $payload = auth('admin-api')->getPayload($r->token);
        $id = $payload['user']['id'];
        if (!$id || !auth('admin-api')->parseToken()->check(true)) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses untuk merubah password'], 403);
        }

        $admin = admin::find($id);
        if (!empty($r->password)) {
            $admin->password = Hash::make($r->password);
        }

        $admin->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => 'Password berhasil dirubah']);
    }

    function invalidateToken(req $r)
    {
        auth('admin-api')->invalidate(new \Tymon\JWTAuth\Token($r->token), false);
        return response()->json(['success' => true]);
    }
}
