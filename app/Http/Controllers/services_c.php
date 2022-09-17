<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use App\Traits\Uploader;
use App\Models\services;
use Storage;

class services_c extends Controller
{
    use Uploader;

    function getServices(req $r)
    {
        $limit = $r->has('limit') ? $r->limit : 10;
        $type = $r->has('type') ? $r->type : 'general';
        $services = services::where(compact('type'))->orderBy('created_at', 'desc')->paginate($limit)->through(function ($m) {
            $m->file = $m->file ? asset("/storage/services/$m->file") : null;
            return $m;
        });
        return $services;
    }

    function detailServices($id)
    {
        $services = services::findOrFail($id);
        $services->file = $services->file ? asset("/storage/services/$services->file") : null;
        return $services;
    }

    function addServices(req $r)
    {
        $base64 = $r->file;
        if ($base64) {
            $file = $this->fileUpload($base64, 'services/');
        }
        // Store
        $index = services::count() + 1;
        $services = new services;
        $services->index = $index;
        $services->type = $r->type;
        $services->title = $r->title;
        $services->description = $r->description;
        if ($base64) {
            $services->file = $file;
        }
        $services->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => "Berhasil menambahkan $services->title"]);
    }

    function editServices(req $r, $id)
    {
        $services = services::find($id);
        if ($r->has('file') || $r->file) {
            if (Storage::disk('local')->exists("services/$services->file") && !empty($services->file)) {
                Storage::disk('local')->delete("services/$services->file");
            }
            $base64 = $r->file;
            $file = !empty($base64) ? $this->fileUpload($base64, 'services/') : null;
            $services->file = $file;
        }
        // Store
        $services->title = $r->title;
        $services->description = $r->description;
        $services->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => 'Perubahan berhasil disimpan']);
    }

    function deleteServices($id)
    {
        $services = services::findOrFail($id);
        $services_name = $services->title;
        $services->forceDelete();
        return response()->json(['success' => true, 'message' => "Berhasil menghapus $services_name"]);
    }
}
