<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use App\Traits\Uploader;
use App\Models\home_popup as popup;
use App\Models\home_banner as banner;
use App\Models\home_assets as assets;
use App\Models\home_customer as customer;
use Storage;

class home_c extends Controller
{
    use Uploader;

    function getPopup()
    {
        $popup = popup::orderBy('index', 'desc')->paginate(10)->through(function ($m) {
            $m->file = asset("/storage/home/popup/$m->file");
            return $m;
        });
        return $popup;
    }

    function addPopup(req $r)
    {
        $base64 = $r->file;
        $file = $this->fileUpload($base64, 'home/popup/');
        // Store
        $index = popup::count() + 1;
        $popup = new popup;
        $popup->index = $index;
        $popup->title = $r->title;
        $popup->description = $r->description;
        $popup->file = $file;
        $popup->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => "Berhasil menambahkan $popup->title"]);
    }

    function editPopup(req $r, $id)
    {
        $popup = popup::find($id);
        if ($r->has('file') || $r->file) {
            if (Storage::disk('local')->exists("home/popup/$popup->file")) {
                Storage::disk('local')->delete("home/popup/$popup->file");
            }
            $base64 = $r->file;
            $file = $this->fileUpload($base64, 'home/popup/');
            $popup->file = $file;
        }
        // Store
        $popup->title = $r->title;
        $popup->description = $r->description;
        $popup->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => 'Perubahan berhasil disimpan']);
    }

    function statusPopup(req $r, $id)
    {
        $popup = popup::find($id);
        // Store
        $popup->status = $r->status;
        $popup->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => 'Perubahan berhasil disimpan']);
    }

    function deletePopup($id)
    {
        $popup = popup::findOrFail($id);
        $popup_name = $popup->title;
        $images = $popup->img;
        // $popup->delete(); // Soft Delete
        $popup->forceDelete();
        return response()->json(['success' => true, 'message' => "Berhasil menghapus $popup_name"]);
    }

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

    function getCustomer(req $r)
    {
        $limit = $r->has('limit') ? $r->limit : 10;
        $customer = customer::orderBy('index', 'desc')->paginate($limit)->through(function ($m) {
            $m->file = $m->file ? asset("/storage/home/customer/$m->file") : null;
            return $m;
        });
        return $customer;
    }

    function addCustomer(req $r)
    {
        $base64 = $r->file;
        $file = $this->fileUpload($base64, 'home/customer/');
        // Store
        $index = customer::count() + 1;
        $customer = new customer;
        $customer->index = $index;
        $customer->title = $r->title;
        $customer->description = $r->description;
        $customer->file = $file;
        $customer->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => "Berhasil menambahkan $customer->title"]);
    }

    function editCustomer(req $r, $id)
    {
        $customer = customer::find($id);
        if ($r->has('file') || $r->file) {
            if (Storage::disk('local')->exists("home/customer/$customer->file") && $customer->file !== null) {
                Storage::disk('local')->delete("home/customer/$customer->file");
            }
            $base64 = $r->file;
            $file = $this->fileUpload($base64, 'home/customer/');
            $customer->file = $file;
        }
        // Store
        $customer->title = $r->title;
        $customer->description = $r->description;
        $customer->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => 'Perubahan berhasil disimpan']);
    }

    function deleteCustomer($id)
    {
        $customer = customer::findOrFail($id);
        $customer_name = $customer->title;
        $images = $customer->img;
        // $customer->delete(); // Soft Delete
        $customer->forceDelete();
        return response()->json(['success' => true, 'message' => "Berhasil menghapus $customer_name"]);
    }
}
