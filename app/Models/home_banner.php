<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class home_banner extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $table = 'home_banner';
    protected $guarded = [];
    // protected $casts = [
    //     'created_at' => 'date:Y-m-d H:i:s',
    //     'updated_at' => 'date:Y-m-d H:i:s',
    //     'deleted_at' => 'date:Y-m-d H:i:s',
    // ];

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function boot()
    {
        parent::boot();
        static::generateId();
        static::deleting(function ($banner) {
            if ($banner->isForceDeleting()) {
                if (Storage::disk('local')->exists("home/banner/$banner->file")) {
                    Storage::disk('local')->delete("home/banner/$banner->file");
                }
            }
        });
    }
}
