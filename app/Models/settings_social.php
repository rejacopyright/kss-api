<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class settings_social extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $table = 'settings_social';
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
        static::deleting(function ($media) {
            if ($media->isForceDeleting()) {
                // if (Storage::disk('local')->exists("news/media/$media->file")) {
                //     Storage::disk('local')->delete("news/media/$media->file");
                // }
            }
        });
    }
}
