<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Image;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ImageResize;
use Symfony\Component\Console\Input\Input;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_res = Restaurant::where('id_user', Auth::id())->get();
        return view('template_admin.food.list', compact('get_res'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_res = Restaurant::where('id_user', Auth::id())->get();
        return view('template_admin.food.create', compact('get_res'));
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
        // dd($request->file('image_f')[1]);
        $request['price_f'] = str_replace(',', '', $request['price_f']); // xoá dấu , đi.
        $request['price_f'] = str_replace('.', '', $request['price_f']); // xoá dấu , đi.


        $rules = [
            'name_f' => 'required',
            'price_f' => 'required|Numeric',
            'note_f' => 'max:500',
            'image_f' => 'max:3',
        ];
        $message = [
            'name_f.required' => 'Tên món ăn không được trống',
            'price_f.required' => 'Vui lòng nhập giá tiền',
            'image_f.max' => 'Hình ảnh quá nhiều vui lòng kiểm tra lại',
            'price_f.numeric' => 'Tiền phải là số',
            'image_f.mimes' => 'Sai chuẩn hình ảnh được hỗ trợ rùi'
        ];
        $vali = Validator::make($request->all(), $rules, $message);
        // dd($request->all());
        if ($vali->fails()) {
            return redirect()->back()->withErrors($vali)->withInput();
        } else {

            // dd( $image = $request->file('image_f'));
            if ($request->file('image_f') != null) {
                for ($i = 0; $i < count($request->file('image_f')); $i++) {
                    $image = $request->file('image_f')[$i];

                    // $input['imagename'] = $i . time() . '.' . $image->extension(); // lấy thời gian làm tên file khỏi bị đụng độ
                    // $destinationPath = public_path('//storage//thumbnail');

                    // $image_resize = ImageResize::make($image->path());


                    Cloudder::upload($image, 'uploads/' . $image, array("width" => 300, "height" => 200, "crop" => "scale"));
                    // dd('/stogare/thumbnail/'.$image_resize->basename);
                    $url_image = Cloudder::show('uploads/' . $image, array("width" => 300, "height" => 200, "crop" => "scale"));
                    $cloudinary_id = Cloudder::getPublicId();
                    $id_f = Food::insertGetId(Arr::except($request->all(), ['_token', 'image_f']));
                    Image::create(['id_f' => $id_f, 'link_image' => $url_image, 'cloudinary_id' => $cloudinary_id]);
                }
            } else {
                Food::create(Arr::except($request->all(), ['_token', 'image_f']));
            }
        }
        return redirect()->back()->with('success', 'Đã thêm món ăn thành công')->withInput($request->only('id_res')); // vẫn giữ nguyên cửa hàng khi đã thêm món
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
        $response = array();
        foreach ($get_food as $item) {
            $link_image = array();
            if (count($item->image) > 0) {
                foreach ($item->image as $item_img) {
                    $link_image[] = array('link_image' => $item_img->link_image);
                }
            } else {
                $link_image[] = array('link_image' => 'Chưa có hình');
            }
            $response[] = array('id' => $item->id, 'name_f' => $item->name_f, 'price_f' => number_format($item->price_f), 'link_image' => $link_image, 'note_f' => $item->note_f);
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
        // dd($request->all());
        $request['price_f'] = str_replace(',', '', $request['price_f']); // xoá dấu , đi.
        Food::where('id', $request['id_f'])->update(Arr::except($request->all(), ['_token', 'id_f']));
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Food::destroy($id);
        echo "Đã xoá xong";
    }
    public function edit_image_show($id_f)
    {
        $get_image = Image::where('id_f', $id_f)->get();
        return view('template_admin.food.edit_image', compact('get_image', 'id_f'));
    }

    public function add_image_food($id_f, Request $request)
    {
        // dd($id_f, $request->file('add_file_image'));
        $image = $request->file('add_file_image');



        Cloudder::upload($image, 'uploads/' . $image, array("width" => 300, "height" => 200, "crop" => "scale"));
        // dd('/stogare/thumbnail/'.$image_resize->basename);

        $url_image = Cloudder::show('uploads/' . $image, array("width" => 300, "height" => 200, "crop" => "scale"));
        $cloudinary_id = Cloudder::getPublicId();


        Image::create(['id_f' => $id_f, 'link_image' => $url_image, 'cloudinary_id' => $cloudinary_id]);
        return redirect()->back()->with('success', 'Đã thêm hình ảnh thành công');
    }

    public function update_image(Request $request)
    {
        // dd($request->all());
        $image = $request->file('file_image');


        // try{
        $get_id_image =  Image::where('id_f', $request['id_image'])->first();
        if ($get_id_image->link_image != '') {
            Cloudder::destroy($get_id_image->cloudinary_id);
            Cloudder::upload($image, 'uploads/' . $image, array("width" => 300, "height" => 200, "crop" => "scale"));
            // dd('/stogare/thumbnail/'.$image_resize->basename);
            $url_image = Cloudder::show('uploads/' . $image, array("width" => 300, "height" => 200, "crop" => "scale"));
            $cloudinary_id = Cloudder::getPublicId();
            Image::where('id', $request['id_image'])->update(['link_image' => $url_image, 'cloudinary_id' => $cloudinary_id]);
        } else {
            Cloudder::upload($image, 'uploads/' . $image, array("width" => 300, "height" => 200, "crop" => "scale"));
            // dd('/stogare/thumbnail/'.$image_resize->basename);
            $url_image = Cloudder::show('uploads/' . $image, array("width" => 300, "height" => 200, "crop" => "scale"));
            $cloudinary_id = Cloudder::getPublicId();
            Image::where('id', $request['id_image'])->update(['link_image' => $url_image, 'cloudinary_id' => $cloudinary_id]);
        }
        return redirect()->back()->with('success', 'Đã cập nhật hình ảnh thành công');
    }
}
