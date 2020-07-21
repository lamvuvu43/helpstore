<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table='bill';
    protected $primaryKey='id';
    protected $fillable=['id_res','id_user','id_table','total_price','date_price','status_b'];
    // public $timestamp=false;

    public function detail_bill()
    {
        return $this->hasOne("App\Models\DetailBill",'id_b');
    }
    public function table(){
        return $this->belongsTo('App\Models\Table','id_table');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','id_user');
    }
}
