<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table='food';
    protected $primaryKey='id';
    protected $fillable=['id_res','name_f','price_f','note_f'];
     public function image()
     {
         return $this->hasMany('App\Models\Image','id_f');
     }
}
