<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use App\Traits\Uploader;
use App\Models\admin;
use Storage;
use Validator;
use Hash;

class admin_c extends Controller
{
    use Uploader;

    function getAdmin(req $r)
    {
        $limit = $r->has('limit') ? $r->limit : 10;
        $admin = admin::where('id', '!=', auth('admin-api')->user()->id)
            ->where(function ($q) {
                $q->whereNot('role_id', 1)
                    ->orWhereNull('role_id');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($limit)
            ->through(function ($m) {
                $m->avatar = $m->avatar ? asset("/storage/admin/$m->avatar") : null;
                return $m;
            });
        return $admin;
    }

    function detailAdmin($id)
    {
        $admin = admin::find($id);
        $admin->avatar = $admin->avatar ? asset("/storage/admin/$admin->avatar") : null;
        return $admin;
    }

    function addAdmin(req $r)
    {
        // VALIDATION
        $v_rules = ['name' => 'required', 'username' => 'required|unique:admin', 'email' => 'required|email|unique:admin', 'password' => 'required|confirmed'];
        $v_attr = ['name' => 'Full Name', 'username' => 'Username'];
        $v = Validator::make($r->all(), $v_rules, [], $v_attr);
        if ($v->fails()) {
            return response()->json(['data' => $v->errors(), 'req' => $r->all()], 422);
        }

        // Store
        $admin = new admin;
        $admin->name = $r->name;
        $admin->username = $r->username;
        $admin->email = $r->email;
        $admin->password = Hash::make($r->password);
        if ($r->has('avatar') && !empty($r->avatar)) {
            $base64 = $r->avatar;
            $avatar = $this->fileUpload($base64, 'admin/');
            $admin->avatar = $avatar;
        }
        $admin->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => "Berhasil menambahkan $admin->username"]);
    }

    function editAdmin(req $r, $id)
    {
        // VALIDATION
        $v_rules = ['name' => 'required', 'username' => "required|unique:admin,username,$id", 'email' => "required|email|unique:admin,email,$id", 'password' => 'confirmed'];
        $v_attr = ['name' => 'Full Name', 'username' => 'Username'];
        $v = Validator::make($r->all(), $v_rules, [], $v_attr);
        if ($v->fails()) {
            return response()->json(['data' => $v->errors(), 'req' => $r->all()], 422);
        }

        $admin = admin::find($id);
        // Store
        $admin->name = $r->name;
        $admin->username = $r->username;
        $admin->email = $r->email;
        if (!empty($r->password)) {
            $admin->password = Hash::make($r->password);
        }
        if ($r->has('avatar') || $r->avatar) {
            if (Storage::disk('local')->exists("admin/$admin->avatar") && $admin->avatar !== null) {
                Storage::disk('local')->delete("admin/$admin->avatar");
            }
            $base64 = $r->avatar;
            $avatar = $this->fileUpload($base64, 'admin/');
            $admin->avatar = $avatar;
        }
        $admin->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => 'Perubahan berhasil disimpan']);
    }

    function deleteAdmin($id)
    {
        $admin = admin::findOrFail($id);
        $admin_name = $admin->username;
        // $images = $admin->img;
        // $admin->delete(); // Soft Delete
        $admin->forceDelete();
        return response()->json(['success' => true, 'message' => "Berhasil menghapus $admin_name"]);
    }
}
