@extends('template_admin.index')
@section('pageTitle', 'Thêm nhân vien')
@section('create-staff')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12 ">
        <div class="container">
            <h2 class="mt-4 pr-2">Thêm nhân viên cho cửa hàng</h2>
            @if (session('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ session('success') }}
            </div>
            @endif



            <form action="{{ route('create.staff.store') }}" method="post" class="form-group">
                @csrf
                <div class="form-group">
                    <label for="id_res" style="font-size: 18px">Thêm <span style="color:red">nhân viên</span> cho <span style="color:red">cửa hàng</span></label>
                    <select name="id_res" class="form-control select_res">

                        @if(count($get_res)>0)
                        @foreach($get_res as $item)
                        <option value="{{ $item->id }}" <?php echo($item->id == old('id_res'))? 'selected': '' ?>>{{ $item->name_res }} - {{ $item->address_res }} - {{$item->note_res }}</option>
                        @endforeach
                        @else
                        <option value="">Bạn chưa có cửa hàng!!!. Vui lòng thêm cửa hàng trước khi thực hiện</option>
                        @endif

                    </select>
                </div>
                <div class="form-group">
                    <label for="name_mem" style="font-size: 18px">Tên nhân viên</label>
                    <input type="text" placeholder="Nguyễn Văn A" name="name_mem" id="name_mem" class=" @error('name_mem') is-invalid @enderror form-control" value="{{ old('name_mem') }}" maxlength="50">
                    @error('name_mem')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone_mem" style="font-size: 18px">Số điện thoại</label>
                    <input type="text" placeholder="0374885769" name="phone" id="phone_mem" class="@error('phone_mem') is-invalid @enderror form-control" value="{{old('phone') }}" maxlength="255">
                    @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email_mem" style="font-size: 18px">Email nhân viên</label>
                    <input type="email" placeholder="lamvuvu43@gmail.com" name="email" id="email_mem" class=" @error('email_mem') is-invalid @enderror form-control" value="{{old('email')}}">
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" style="font-size: 18px">Mật khẩu nhân viên</label>
                    <input type="password" placeholder="************" name="password" id="password" class=" @error('password') is-invalid @enderror form-control" value="">
                    @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address_mem" style="font-size: 18px">Địa chỉ nhân viên</label>
                    <input placeholder="123 Nguyễn Văn Linh - Cần Thơ" name="address_mem" id="address_mem" class="form-control" value="{{old('address_mem')}}" maxlength="500">
                </div>
                <div class="form-group">
                    <label for="note_mem" style="font-size: 18px">Ghi chú</label>
                    <textarea placeholder="Ghi chú" name="note_mem" id="note_mem" class="form-control" value="{{old('note_mem')}}" maxlength="500"></textarea>
                </div>
                <div class="text-center mt-2">
                    <button type="submit" class="btn btn-primary btn_edit">Thêm</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
