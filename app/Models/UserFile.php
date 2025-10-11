<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_path',
        'file_type',
        'description',
    ];

    // Relation to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optional: get full URL of file
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}
