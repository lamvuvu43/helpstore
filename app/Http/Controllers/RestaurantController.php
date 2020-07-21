<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('template_admin.restaurant.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request['accept_res'] = 'yes';
        $request['id_user'] = Auth::id();
        // dd($request->except('_token'));
        $rules = [
            'name_res' => 'required|max:50',
            'address_res' => 'required|max:255',
            'note_res' => 'max:500',
        ];

        $message = [
            'name_res.required' => 'Vui lòng nhập tên cửa hàng',
            'name_res.max' => 'Chiều dài tối đa là 5o ký tự',
            'address_res.required' => 'Vui lòng nhập địa chỉ cửa hàng',
            'address_res.max' => 'Độ dài tối đa là 500 kí tự',
            'note_res.max' => 'Chiều dài vượt qua giới hạng',
        ];
        $vali = Validator::make($request->all(), $rules, $message);
        if ($vali->fails()) {
            return redirect()->back()->withErrors($vali)->withInput();
        } else {
            Restaurant::create($request->except('_token'));
            return redirect()->back()->with('success', 'Bạn đã thêm cửa hàng thành công');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $list_restaurant = Restaurant::where('id_user', Auth::id())->get();
        // dd();
        return view('template_admin.restaurant.list', compact('list_restaurant'));
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

        Restaurant::where('id', $request['id_res'])->update([
            'name_res' => $request['name_res'],
            'address_res' => $request['address_res'],
            'note_res' => $request['note_res'],
        ]);
        return redirect()->back()->with('update_success', 'Bạn cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Restaurant::where('id', $id)->first();
        if ($res->id_user == Auth::id()) {
            Restaurant::destroy($id);
        } else {
            return redirect()->route('home');
        }
    }
}
