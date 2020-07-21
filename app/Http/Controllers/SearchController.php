<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function order_food_with_res(Request $request,$id_res) // autocomplate dành cho chủ cửa hàng.
    { 
        $search=$request->search;
        if ($search == null) {
            $get_food = Food::select('id','name_f')->where("id_res", $id_res)->limit(5)->get();
        } else {
            $get_food = Food::select('id','name_f')->where("id_res", $id_res)->where("name_f", "like", "%" . $search . "%")->limit(5)->get();
        }
        $response = array(); // khai báo một mảng;

        foreach ($get_food as $item) {
            $response[] = array("value" => $item->id, "label" => $item->name_f);
        }

     
        // echo $id_res;
    
        // if($search !=null){
        //     $response[] = array("value" => 1, "label" =>$search,"test"=>"Đây rùi");
        // }
        echo json_encode($response);
        exit;
    }
}
