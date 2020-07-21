<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\DetailBill;
use App\Models\Food;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\TempOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_res)
    {
        $get_temp = TempOrder::where('id_user', Auth::id())->where('id_res', $id_res)->get();
        if (count($get_temp) > 0) {
            foreach ($get_temp as $i => $item) {
                $i++;
                echo "<tr>";
                echo " <td class='" . $item->id . "_modal' style='display:none'>" . $item->id . "</td>";
                echo "<td>" . $i . "</td>";
                echo "<td style='display:none'><input type='text' name='id_f[]' value='" . $item->id . "' class='id_temp' ></td>";
                echo "<td>" . $item->food->name_f . "</td>";
                echo "<td class='price_f'>" . number_format($item->food->price_f) . "</td>";
                echo "<td><input type='number' min='1' max='100' name='amount_f[]' maxleght='3' value='" . $item->amount . "' class='form-control amount_select'></td>";
                echo "<td><input type='text' class='form-control note_f' name='note_db' value='" . $item->note_f . "' style='border:1px solid #CED4DA'></td>";
                echo "<td class='pay money'>" . number_format($item->amount * $item->food->price_f) . "</td>";
                echo "<td><button class='btn btn-danger btn_remove_f'><i class='far fa-trash-alt'></i></button></td>";
                "</tr>";
            }
        } else {
            echo "<tr style='font-size:20px; text-align:center'><td colspan='6'>Chưa có gì trong gỏi hàng</td></tr>";
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_res = Restaurant::where('id_user', Auth::id())->get();
        return view('template_admin.order.create', compact('get_res'));
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

                $id_b = Bill::insertGetId(['id_res' => $request['id_res'], 'id_table' => $request['id_table'], 'total_price' => $total_price, 'date_price' => date('Y-m-d H:i:s'), 'status_b' => 'accept']);
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
        $get_food = Food::where('id_res', $id)->get();
        // echo $id;
        foreach ($get_food as $i => $item) {
            $i++;
            echo "<tr>
                <td class='".$item->id."' style='display:none'>" . $item->id . "</td>
                <td>" . $i . "</td>
                <td class='text-left name_f'>" . $item->name_f . "</td>";
            echo "<td class='text-left'>";
            foreach ($item->image as $item_img) {
                echo "<img src='" . $item_img->link_image . "' class='image_f_order'>";
            }
            echo "</td>";
            echo "<td class='money'>" . number_format($item->price_f) . "</td>
                <td><input type='number' min='1' max='100' value='1' maxlenght='3' class='form-control amount'></td>";
            echo "<td><input type='text' name='note_f' value='' class='form-control note_food'></td>";
            echo   "<td ><button class='btn btn-primary add_food' style='border-radius:50%'><i class='fas fa-plus'></i></button></td>
            </tr>";
        }
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
        // echo $request['amount'];
        TempOrder::where('id', $id)->update(['amount' => $request['amount']]);
        echo "Change amount complete";
    }
    public function update_note_f(Request $request, $id)
    {
        TempOrder::where('id', $id)->update(['note_f' => $request['note_f']]);
        // echo "Change amount complete";
        echo $request['note_f'];
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TempOrder::destroy($id);
        echo "Delete complete";
    }

    public function send_required(Request $request, $id_res)
    {
        // echo $request['note_f'];
        TempOrder::create(['id_res' => $id_res, 'id_f' => $request['id_f'], 'amount' => $request['amount_f'], 'id_user' => Auth::id(), 'note_f' => $request['note_f']]);
        echo "Complete";
    }

    public function list()
    {
        $get_res = Restaurant::where('id_user', Auth::id())->get();
        return view('template_admin.order.list', compact('get_res'));
    }
    public function filter_list($filter, $id_res,$today)
    {
        $response = array();
        // echo $filter;
        if ($filter == 'all') {
            $get_bill = Bill::where('id_res', $id_res)->orderBy('date_price', 'DESC')->get();
        } else {
            if($today=='today'){
                $get_bill = Bill::where('id_res', $id_res)->where('status_b', $filter)->where('date_price', '>=', date('Y-m-d') . ' 00:00:00')->orderBY('date_price', 'DESC')->get();
            }else{
                $get_bill = Bill::where('id_res', $id_res)->where('status_b', $filter)->orderBY('date_price', 'DESC')->get();
            }
        }
        foreach ($get_bill as $i=> $item) {
            $i++;
            if ($item->user == '') {
                $response[] = array('stt'=>$i,'id_bill' => $item->id, 'username' => '', 'table' => $item->table->name_table, 'total_price' => number_format($item->total_price), 'date' => $item->date_price, 'status' => $item->status_b);
            } else {
                $response[] = array('stt' => $i,'id_bill' => $item->id, 'username' => $item->user->username, 'table' => $item->table->name_table, 'total_price' =>number_format($item->total_price), 'date' => $item->date_price, 'status' => $item->status_b);
            }
        }
        echo json_encode($response);
    }

    public function update_status($status, $id)
    {
        if ($status != 'payed') {
            Bill::where('id', $id)->update(['status_b' => $status]);
            echo "Update status complete";
        } else {
            $get_id_table = Bill::select('id_table')->where('id', $id)->first();
            Bill::where('id', $id)->update(['status_b' => $status]);
            Table::where('id', $get_id_table->id_table)->update(['status' => '']);
            echo "thanh toán thành công";
        }
    }

    public function get_name_res($id_res)
    {
        $get_res =  Restaurant::where('id', $id_res)->first();
        echo $get_res->name_res . "-" . $get_res->address_res . "-" . $get_res->note_res;
    }

    public function get_table($id_res)
    {
        $get_table = Table::where('id_res', $id_res)->get();
        if (count($get_table) > 0) {
            foreach ($get_table as $item) {
                if ($item->status == 'full') {
                    echo "<div  class='col-4 col-md-3 col-lg-2 mt-2 pr-0  '>";
                    echo "<div class='table_select_full  choose_table '> <div>" . $item->name_table . " </div> </div>";
                    echo "<div class='id_table' style='display:none' >" . $item->id . "</div>";
                    echo "</div>";
                } else {
                    echo "<div  class='col-4 col-md-3 col-lg-2  mt-2  pr-0  '>";
                    echo "<div class='table_select choose_table '><div>" . $item->name_table . " </div> </div>";
                    echo "<div class='id_table' style='display:none' >" . $item->id . "</div>";
                    echo "</div>";
                }
            }
        } else {
            echo "Cửa hàng chưa có bàn";
        }
    }


    public function detail_bill($id_bill)
    {
        $get_detail_bill = DetailBill::where('id_b', $id_bill)->get();
        $response = array();
        foreach ($get_detail_bill as $i => $item) {
            $i++;
            $response[] = array('stt' => $i, 'name' => $item->name_f, 'amount' => $item->amount_food, 'price' => number_format($item->price_f), "total" => number_format($item->total_price_of_food), 'note' => $item->note_db);
        }

        echo json_encode($response);
    }
}
