<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use App\Models\settings_social as social;

class settings_c extends Controller
{
    function getSocial()
    {
        return social::get();
    }

    function editSocial(req $r)
    {
        foreach ($r->all() as $name => $url) {
            social::where('name', $name)->update(compact('url'));
        }
        return response()->json(['status' => 200, 'message' => 'data berhasil diupdate']);
    }
}
