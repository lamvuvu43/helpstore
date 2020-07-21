<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['id_per','username', 'email', 'email_verified_at', 'phone', 'password', 'remember_token','address'];

    
}
