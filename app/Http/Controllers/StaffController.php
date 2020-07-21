<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Arr;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_res = Restaurant::where('id_user', Auth::id())->get();
        return view('template_admin.staff.list', compact('get_res'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_res = Restaurant::where('id_user', Auth::id())->get();
        return view('template_admin.staff.create', compact('get_res'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name_mem' => 'required',
            'phone' => 'unique:users|min:10|required',
            'email' => 'unique:users|required',
            'password' => 'required',
        ];
        $message = [
            'name_mem.required' => 'Tên không được rỗng',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'email.unique' => 'Email đã tồn tại',
            'phone.min' => 'Số điện thoại không đúng',
            'phone.required' => 'Số điện thoại không được rỗng',
            'email.required' => 'Email không được rỗng',
            'password.required' => 'Mật khẩu không được rỗng',
        ];
        $vali = Validator::make($request->all(), $rules, $message);
        // dd($vali);
        if ($vali->fails()) {
            return redirect()->back()->withErrors($vali)->withInput();
        } else {
            $password = bcrypt($request['password']);
            $id_user = User::insertGetId(['id_per' => '3', 'username' => $request['name_mem'], 'email' => $request['email'], 'phone' => $request['phone'], 'password' => $password, 'created_at' => date('Y-m-d h:i:s'), 'address' => $request['address_mem']]);
            Staff::insert(['id_res' => $request['id_res'], 'id_user' => $id_user, 'note_mem' => $request['note_mem'], 'created_at' => date('Y-m-d h:i:s')]);
            return redirect()->back()->with('success', 'Đã thêm nhân viên thành công')->withInput($request->only('id_res'));
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
        $get_mem = Staff::where('id_res', $id)->get();
        $response = array();
        foreach ($get_mem as $item) {
            $response[] = array('id_user' => $item->user->id, 'username' => $item->user->username, 'phone' => $item->user->phone, 'email' => $item->user->email, 'address' => $item->user->address, 'note_mem' => $item->note_mem,'status'=>$item->status);
        }
        echo json_encode($response);
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

        $request['password'] = bcrypt($request['password']);
        // unset($request['_token']);
        // dd($request->all());


        if ($request['password'] != null) {
            User::where('id', $request['id'])->update(['username' => $request['name_mem'], 'email' => $request['email'], 'phone' => $request['phone'], 'password' => $request['password'], 'address' => $request['address_mem'], 'updated_at' => date('Y-m-d H:i:s')]);
            Staff::where('id_user', $request['id'])->update(['note_mem' => $request['note_mem'], 'status' => $request['status']]);
            return redirect()->back()->with('success', 'Cập nhật nhân viên thành công');
        } else {
            User::where('id', $request['id'])->update(['username' => $request['name_mem'], 'email' => $request['email'], 'phone' => $request['phone'], 'address' => $request['address_mem'], 'updated_at' => date('Y-m-d H:i:s')]);
            Staff::where('id_user', $request['id'])->update(['note_mem' => $request['note_mem'], 'status' => $request['status']]);
            return redirect()->back()->with('success', 'Cập nhật nhân viên thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Staff::destroy($id);
        echo "Đã xoá xong";
    }
}
