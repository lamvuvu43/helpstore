@extends('template_admin.index')
@section('pageTitle', 'Thêm món ăn')
@section('create-food')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12 ">
        <div class="container">
            <h2 class="mt-4 pr-2">Thêm món ăn cho cửa hàng</h2>
            @if (session('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('create.food.store') }}" method="post" class="form-group" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="id_res" style="font-size: 18px">Thêm <span style="color:red">món ăn cho</span> cho <span style="color:red">cửa hàng</span></label>
                    <select name="id_res" class="form-control select_res">
                        {{-- {{ dd($get_res) }} --}}
                        @if(count($get_res) > 0)
                        @foreach($get_res as $item)
                        <option value="{{ $item->id }}" <?php echo($item->id == old('id_res'))? 'selected': '' ?>>{{ $item->name_res }} - {{ $item->address_res }} - {{$item->note_res }}</option>
                        @endforeach
                        @else
                        <option value="">Bạn chưa có cửa hàng!!!. Vui lòng thêm cửa hàng trước khi thực hiện</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="name_f" style="font-size: 18px">Tên món ăn</label>
                    <input type="text" placeholder="Bún đậu 1 người" name="name_f" id="name_f" class=" @error('name_f') is-invalid @enderror form-control" value="{{ old('name_f') }}" maxlength="50">
                    @error('name_f')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price_f" style="font-size: 18px">Giá tiền (VND)</label>
                    <input type="text" placeholder="40,000" name="price_f" id="price_f" class="@error('price_f') is-invalid @enderror form-control money" value="{{old('price_f') }}" maxlength="255">
                    @error('price_f')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image_f" style="font-size: 18px">Hình ảnh sản phẩm (<span style="color:red">Chọn tối đa 3 hình</span>)</label>
                    <input type="file" placeholder="40,000" name="image_f[]" max="3" id="image_f" accept="image/*" multiple="multiple" class="@error('image_f') is-invalid @enderror form-control money" value="{{old('image_f') }}">

                    @error('image_f')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="note_f" style="font-size: 18px">Ghi chú</label>
                    <input placeholder="" name="note_f" id="note_f" class="form-control" value="{{old('note_f')}}" maxlength="500">
                </div>
                <div class="text-center mt-2">
                    <button type="submit" class="btn btn-primary btn_edit">Thêm</button>
                </div>

            </form>

        </div>
    </div>
</div>
{{-- ------------Thêm dấu , vào money------------- --}}
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

<script type="text/javascript" src="{{ asset('js/simple.money.format.js') }}"></script>
<script type="text/javascript">
    $('.money').simpleMoneyFormat();

</script>
{{-- -----------------set max file upload------------------------------------- --}}

@endsection
