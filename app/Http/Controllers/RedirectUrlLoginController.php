<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectUrlLoginController extends Controller
{
    public function redirect_url()
    {
       
        if(Auth::user()->id_per==3){
            return redirect()->route('staff.create_order');
        }else{
            return redirect()->route('order.create');
        }
    }
}
