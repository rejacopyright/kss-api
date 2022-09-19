<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use App\Models\news_carreer as carreer;

class news_carreer_c extends Controller
{
  function getCarreer(req $r)
  {
    $limit = $r->has('limit') ? $r->limit : 10;
    $carreer = carreer::orderBy('created_at', 'desc')->paginate($limit);
    return $carreer;
  }

  function detailCarreer($id)
  {
    return carreer::findOrFail($id);
  }

  function addCarreer(req $r)
  {
    // Store
    $carreer = new carreer;
    $carreer->title = $r->title;
    $carreer->description = $r->description;
    $carreer->save();
    return response()->json(['status' => 200, 'success' => true, 'message' => "Berhasil menambahkan $carreer->title"]);
  }

  function editCarreer(req $r, $id)
  {
    $carreer = carreer::find($id);
    // Store
    $carreer->title = $r->title;
    $carreer->description = $r->description;
    $carreer->save();
    return response()->json(['status' => 200, 'success' => true, 'message' => 'Perubahan berhasil disimpan']);
  }

  function deleteCarreer($id)
  {
    $carreer = carreer::findOrFail($id);
    $carreer_name = $carreer->title;
    $carreer->forceDelete();
    return response()->json(['success' => true, 'message' => "Berhasil menghapus $carreer_name"]);
  }
}
