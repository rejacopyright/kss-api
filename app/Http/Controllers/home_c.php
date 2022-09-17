<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use App\Traits\Uploader;
use App\Models\home_banner as banner;
use App\Models\home_assets as assets;
use Storage;

class home_c extends Controller
{
    use Uploader;

    function getBanner()
    {
        $banner = banner::orderBy('index', 'desc')->paginate(10)->through(function ($m) {
            $m->file = asset("/storage/home/banner/$m->file");
            return $m;
        });
        return $banner;
    }

    function addBanner(req $r)
    {
        $base64 = $r->file;
        $file = $this->fileUpload($base64, 'home/banner/');
        // Store
        $index = banner::count() + 1;
        $banner = new banner;
        $banner->index = $index;
        $banner->title = $r->title;
        $banner->description = $r->description;
        $banner->file = $file;
        $banner->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => "Berhasil menambahkan $banner->title"]);
    }

    function editBanner(req $r, $id)
    {
        $banner = banner::find($id);
        if ($r->has('file') || $r->file) {
            if (Storage::disk('local')->exists("home/banner/$banner->file")) {
                Storage::disk('local')->delete("home/banner/$banner->file");
            }
            $base64 = $r->file;
            $file = $this->fileUpload($base64, 'home/banner/');
            $banner->file = $file;
        }
        // Store
        $banner->title = $r->title;
        $banner->description = $r->description;
        $banner->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => 'Perubahan berhasil disimpan']);
    }

    function deleteBanner($id)
    {
        $banner = banner::findOrFail($id);
        $banner_name = $banner->title;
        $images = $banner->img;
        // $banner->delete(); // Soft Delete
        $banner->forceDelete();
        return response()->json(['success' => true, 'message' => "Berhasil menghapus $banner_name"]);
    }

    function getAssets()
    {
        return assets::orderBy('index', 'asc')->paginate(10);
    }

    function addAssets(req $r)
    {
        // Store
        $index = assets::count() + 1;
        $assets = new assets;
        $assets->index = $index;
        $assets->count = $r->count;
        $assets->title = $r->title;
        $assets->description = $r->description;
        $assets->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => "Berhasil menambahkan $assets->title"]);
    }

    function editAssets(req $r, $id)
    {
        // Store
        $assets = assets::find($id);
        $assets->count = $r->count;
        $assets->title = $r->title;
        $assets->description = $r->description;
        $assets->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => 'Perubahan berhasil disimpan']);
    }

    function deleteAssets($id)
    {
        $assets = assets::findOrFail($id);
        $assets_name = $assets->title;
        $assets->forceDelete();
        return response()->json(['success' => true, 'message' => "Berhasil menghapus $assets_name"]);
    }
}
