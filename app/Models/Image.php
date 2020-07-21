<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table='images';
    protected $primaryKey='id';
    protected $fillable=['id_f','link_image','cloudinary_id','size_image'];
}
