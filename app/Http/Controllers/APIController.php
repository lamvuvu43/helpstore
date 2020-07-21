<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    public function getTable(Request $request)
    {
        $email = $request['email'];
        $password = $request['pass'];
        $check = Auth::attempt(['email' => $email, 'password' => $password]);
        $listtable = array();
        if ($check == true) {
            $id_res = Restaurant::select('id')->where('id_user', Auth::id())->first();
            $table = Table::select('id', 'name_table')->where('id_res', $id_res->id)->get();

            foreach ($table as $i => $item) {
                $i++;
                $listtable[] = array('stt' => $i, 'id' => $item->id,'name'=>$item->name_table);

            }
        }
       echo json_encode($listtable);
    }
}
