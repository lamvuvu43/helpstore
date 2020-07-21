<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table='restaurant';
    protected $primaryKey='id';
    protected $fillable=['id_user','name_res','address_res','note_res','accept_res','created_at','update_at'];

    public function table()
    {
        return $this->hasMany('App\Models\Table','id_res');
    }
}
