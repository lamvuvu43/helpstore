<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;
use App\Models\Bill;
use App\Models\DetailBill;
use App\Models\TempOrder;
use App\Models\Table;

class StaffOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $check_staff = Staff::where('id_user', Auth::id())->first();

        return view('template_staff.order.create', compact('check_staff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        // dd($request->all());
        if ($request['id_table'] != 0) {
            if ($request['total_amount'] != 0) {
                $get_temp = TempOrder::where('id_user', Auth::id())->get();
                $total_price = str_replace(',', '', $request['total_price']);

                $id_b = Bill::insertGetId(['id_res' => $request['id_res'], 'id_user' => Auth::id(), 'id_table' => $request['id_table'], 'total_price' => $total_price, 'date_price' => date('Y-m-d H:i:s'), 'status_b' => 'no_accept']);
                Table::where('id', $request['id_table'])->update(['status' => 'full']);
                foreach ($get_temp as $item) {
                    DetailBill::create(['id_b' => $id_b, 'name_f' => $item->food->name_f, 'amount_food' => $item->amount, 'price_f' => $item->food->price_f, 'total_price_of_food' => $item->amount * $item->food->price_f, 'note_db' => $item->note_f]);
                }
                TempOrder::where('id_user', Auth::id())->delete();
                return redirect()->back()->with('success', 'Đã gửi đơn hàng');
            } else {
                return redirect()->back()->with('fail', 'Oops!!! Đơn hàng rỗng');
            }
        } else {
            return redirect()->back()->with('fail', 'Oops!!! Lỗi chưa chọn bàn ăn. Vui lòng chọn bàn và thực hiện lại');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Auth::id();
        $check_staff = Staff::where('id_user', $id)->first();

        return view('template_staff.order.list', compact('check_staff'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filter_list($filter, $id_res)
    {
        $response = array();
        // echo $filter;

        $get_bill = Bill::where('id_res', $id_res)->where('status_b', $filter)->where('id_user',Auth::id())->where('date_price', '>=', date('Y-m-d') . ' 00:00:00')->orderBY('date_price', 'DESC')->get();
        foreach ($get_bill as $item) {
            if ($item->user == '') {
                $response[] = array('id_bill' => $item->id, 'username' => '', 'table' => $item->table->name_table, 'total_price' => number_format($item->total_price), 'date' => $item->date_price, 'status' => $item->status_b);
            } else {
                $response[] = array('id_bill' => $item->id, 'username' => $item->user->username, 'table' => $item->table->name_table, 'total_price' => number_format($item->total_price), 'date' => $item->date_price, 'status' => $item->status_b);
            }
        }
        echo json_encode($response);
    }
}
