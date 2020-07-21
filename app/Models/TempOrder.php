<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempOrder extends Model
{
    protected $table='temp_order';
    protected $primaryKey='id';
    protected $fillable=['id_res','id_f','amount','id_user','note_f'];
   
    public function food()
    {
        return $this->belongsTo('App\Models\Food','id_f');
    }
    // public $timestamps = false;
}
