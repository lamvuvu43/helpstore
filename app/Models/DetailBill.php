<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBill extends Model
{
    protected $table = 'detail_bill';
    protected $primaryKey = 'id';
    protected $fillable = ['id_b', 'name_f', 'amount_food','price_f','total_price_of_food','note_db'];
}
