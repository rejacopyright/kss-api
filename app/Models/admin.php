<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Spatie\Permission\Traits\HasRoles;

class admin extends Authenticatable implements JWTSubject
{
    use HasRoles, HasApiTokens, HasFactory, Uuids, SoftDeletes;
    protected $table = 'admin';
    protected $guard_name = 'admin-api';
    protected $guarded = [];
    protected $hidden = ['password'];
    protected $cast = ['address' => 'array', 'role_id' => 'integer'];

    function getJWTIdentifier()
    {
        return $this->getKey();
    }

    function getJWTCustomClaims()
    {
        return [];
    }

    public static function boot()
    {
        parent::boot();
        static::generateId();
        static::deleting(function ($admin) {
            if ($admin->isForceDeleting()) {
                if (Storage::disk('local')->exists("admin/$admin->avatar") && !empty($admin->avatar)) {
                    Storage::disk('local')->delete("admin/$admin->avatar");
                }
            }
        });
    }
}
