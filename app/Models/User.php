<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',      // added mobile
        'package_id',  // linked package
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation: User has many workouts
     */
    public function workouts()
    {
        return $this->hasMany(UserWorkout::class);
    }

    /**
     * Relation: User has many uploaded files
     */
    public function files()
    {
        return $this->hasMany(UserFile::class);
    }

    /**
     * Relation: User belongs to a package
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
