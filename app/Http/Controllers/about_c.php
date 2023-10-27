<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use App\Models\about;
use Validator;

class about_c extends Controller
{
    function getAbout()
    {
        return about::orderBy('index', 'asc')->with(['children'])->paginate(10);
    }

    function detailAbout($scope)
    {
        return about::where(compact('scope'))->firstOrFail();
    }

    function editAbout(req $r, $scope)
    {
        // VALIDATION
        $v_rules = ['title' => 'required', 'description' => 'required'];
        $v_attr = ['title' => 'Judul', 'description' => 'Deskripsi'];
        $v = Validator::make($r->all(), $v_rules, [], $v_attr);
        if ($v->fails()) {
            return response()->json(['status' => 422, 'data' => $v->errors(), 'req' => $r->all()]);
        }
        about::updateOrCreate(compact('scope'), $r->all());
        return response()->json(['status' => 200, 'message' => 'data berhasil diupdate']);
    }
}
