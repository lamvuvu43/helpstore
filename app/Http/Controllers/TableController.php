<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_res = Restaurant::where('id_user', Auth::id())->get();
        return view('template_admin.table.list', compact('get_res'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_res = Restaurant::where('id_user', Auth::id())->get();
        return view('template_admin.table.create', compact('get_res'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_res = $request['id_res'];
        for ($i = 1; $i <= $request['amount_table']; $i++) {
            Table::create(['id_res' => $id_res, 'name_table' => 'Bàn ' . $i]);
        }
        return redirect()->back()->with('success', 'Bạn đã thêm thành công bàn');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_res)
    {
        $get_table = Table::select('id', 'name_table')->where('id_res', $id_res)->get();
        $response = array();
        foreach ($get_table as $i => $item) {
            $i++;
            // echo "<tr>";
            // echo "<td>" . $i . "</td>";
            // echo "<td style='display:none' class='" . $item->id . "'>" . $item->id . "</td>";
            // echo "<td class='name_table'>" . $item->name_table . "</td>";
            // echo "<td><button class='btn btn-primary btn_edit_table mr-2' data-toggle=\"modal\" data-target=\"#modal_edit\">Sửa</button><button class='btn btn-danger btn_delete_table' data-toggle=\"modal\" data-target=\"#modal_delete\">Xoá</button></td>";
            // echo "</tr>";
            $response[] = array('id' => $item->id, 'stt' => $i, 'name_table' => $item->name_table);
        }
        echo json_encode($response);
        // empty($response);
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id_table = $request['id_table'];
        $name_table = $request['name_table'];
        Table::where('id', $id_table)->update(['name_table' => $name_table]);

        $response = array();
        $response[] = array("id_table" => $id_table, "name_table" => $name_table);
        echo json_encode($response);
        exit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Table::destroy($id);
        echo $id;
    }
}
