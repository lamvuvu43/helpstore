<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table='member';
    protected $primaryKey ='id';
    protected $fillable=['id_res','id_user','note_mem','status'];
    public function user()
    {       
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant','id_res');
    }
}
