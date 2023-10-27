<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use App\Traits\Uploader;
use App\Models\banner;
use Storage;

class banner_c extends Controller
{

    use Uploader;

    function getBanner()
    {
        $banner = banner::orderBy('module', 'asc')->paginate(10)->through(function ($m) {
            $m->file = $m->file ? asset("/storage/banner/$m->file") : null;
            return $m;
        });
        return $banner;
    }

    function detailBanner($module)
    {
        $banner = banner::where('module', $module)->first();
        $banner->file = $banner->file ? asset("/storage/banner/$banner->file") : null;
        return $banner;
    }

    function editBanner(req $r, $module)
    {
        $banner = banner::where('module', $module)->firstOrFail();
        if ($banner && ($r->has('file') || $r->file)) {
            if ($banner->file && Storage::disk('local')->exists("banner/$banner->file")) {
                Storage::disk('local')->delete("banner/$banner->file");
            }
            $base64 = $r->file;
            $file = $this->fileUpload($base64, 'banner/');
            $banner->file = $file;
            // Store
            $banner->save();
            return response()->json(['status' => 200, 'success' => true, 'message' => 'Perubahan berhasil disimpan']);
        } else {
            return response()->json(['message' => 'something went wrong'], 404);
        }
    }
}
