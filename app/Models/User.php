<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, Uuids, SoftDeletes;
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'array',
    ];

    function getJWTIdentifier()
    {
        return $this->getKey();
    }

    function getJWTCustomClaims()
    {
        return [];
    }

    static function boot()
    {
        parent::boot();
        static::generateId();
        static::deleting(function ($user) {
            if ($user->isForceDeleting()) {
                if (Storage::disk('local')->exists("user/$user->file")) {
                    Storage::disk('local')->delete("user/$user->file");
                }
            }
        });
    }
}
