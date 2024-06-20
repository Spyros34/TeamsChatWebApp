<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'tbluser'; // Specify the table name

    protected $fillable = [
        'full_name',
        'user_id'
    ];

    public function sentDiscussions()
    {
        return $this->hasMany(Discussion::class, 'user_from_id');
    }

    public function receivedDiscussions()
    {
        return $this->hasMany(Discussion::class, 'user_to_id');
    }
}