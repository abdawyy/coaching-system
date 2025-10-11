<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'link',
        'description',
        'package_id',
    ];

    // Relation to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation to Package (optional)
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
