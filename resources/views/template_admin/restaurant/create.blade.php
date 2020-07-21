@extends('template_admin.index')
@section('pageTitle', 'Thêm cửa hàng')
@section('create-restaurant')

<div class="row" style="font-family: 'Times New Roman', Times, serif;">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="container">
            <h2 class="mt-4 pr-2">Thêm cửa hàng</h2>
            @if (session('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ session('success') }}
            </div>
            @endif
            <form action="{{route('add.process.restaurant')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name_res" style="font-size: 18px">Tên cửa hàng</label>
                    <input type="text" placeholder="Bluestore" name="name_res" id="name_res" class="@error('name_res') is-invalid @enderror form-control" value="{{ old('name_res') }}" maxlength="50">
                    @error('name_res')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address_res" style="font-size: 18px">Địa chỉ cửa hàng</label>
                    <input type="text" placeholder="123 Nguyễn Văn Linh - Cần Thơ" name="address_res" id="address_res" class="@error('address_res') is-invalid @enderror form-control" value="{{ old('name_res') }}" maxlength="255">
                    @error('address_res')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="note_res" style="font-size: 18px">Ghi chú cửa hàng</label>
                    <textarea placeholder="Ghi chú" name="note_res" id="note_res" class="form-control" value="{{old('note_res')}}" maxlength="500"></textarea>
                </div>
                <div class="text-center mt-2">
                    <button type="submit" class="btn btn-primary btn_edit">Thêm</button>
                </div>

            </form>

        </div>

    </div>

</div>
@endsection()
