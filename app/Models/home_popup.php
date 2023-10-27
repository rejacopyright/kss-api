<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class home_popup extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $table = 'home_popup';
    protected $guarded = [];
    protected $casts = [
        'index' => 'integer',
        'status' => 'integer',
        // 'created_at' => 'date:Y-m-d H:i:s',
        // 'updated_at' => 'date:Y-m-d H:i:s',
        // 'deleted_at' => 'date:Y-m-d H:i:s',
    ];

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function boot()
    {
        parent::boot();
        static::generateId();
        static::deleting(function ($popup) {
            if ($popup->isForceDeleting()) {
                if (Storage::disk('local')->exists("home/popup/$popup->file")) {
                    Storage::disk('local')->delete("home/popup/$popup->file");
                }
            }
        });
    }
}
