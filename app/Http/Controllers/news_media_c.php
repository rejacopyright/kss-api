<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use App\Traits\Uploader;
use App\Models\news_media as media;
use Storage;

class news_media_c extends Controller
{
    use Uploader;

    function getMedia(req $r)
    {
        $limit = $r->has('limit') ? $r->limit : 10;
        $orderCol = $r->orderCol ?? 'created_at';
        $orderDir = $r->orderDir ?? 'desc';
        $media = media::orderBy($orderCol, $orderDir);
        if ($r->has('keyword')) {
            $media = $media->where(function ($q) use ($r) {
                $q->where('title', 'LIKE', '%' . $r->keyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $r->keyword . '%');
            });
        }
        $media = $media->paginate($limit)->through(function ($m) {
            $m->file = $m->file ? asset("/storage/news/media/$m->file") : null;
            return $m;
        });
        return $media;
    }

    function detailMedia($id)
    {
        $media = media::findOrFail($id);
        $media->file = $media->file ? asset("/storage/news/media/$media->file") : null;
        return $media;
    }

    function addMedia(req $r)
    {
        $base64 = $r->file;
        if ($base64) {
            $file = $this->fileUpload($base64, 'news/media/');
        }
        // Store
        $media = new media;
        $media->title = $r->title;
        $media->description = $r->description;
        if ($base64) {
            $media->file = $file;
        }
        $media->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => "Berhasil menambahkan $media->title"]);
    }

    function editMedia(req $r, $id)
    {
        $media = media::find($id);
        if ($r->has('file') || $r->file) {
            if (Storage::disk('local')->exists("news/media/$media->file") && !empty($media->file)) {
                Storage::disk('local')->delete("news/media/$media->file");
            }
            $base64 = $r->file;
            $file = !empty($base64) ? $this->fileUpload($base64, 'news/media/') : null;
            $media->file = $file;
        }
        // Store
        $media->title = $r->title;
        $media->description = $r->description;
        $media->save();
        return response()->json(['status' => 200, 'success' => true, 'message' => 'Perubahan berhasil disimpan']);
    }

    function deleteMedia($id)
    {
        $media = media::findOrFail($id);
        $media_name = $media->title;
        $media->forceDelete();
        return response()->json(['success' => true, 'message' => "Berhasil menghapus $media_name"]);
    }
}
