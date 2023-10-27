<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use App\Models\settings_social as social;
use App\Models\settings_contact as contact;

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
    function getContact()
    {
        return contact::firstOrFail();
    }

    function editContact(req $r)
    {
        $contact = contact::firstOrFail();
        $contact->contact = $r->contact;
        $contact->map = $r->map;
        $contact->whatsapp = $r->whatsapp;
        $contact->save();
        return response()->json(['status' => 200, 'message' => 'data berhasil diupdate']);
    }
}
