@extends('template_admin.index')
@section('pageTile', 'Thêm bàn ăn')
@section('create_table')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    @if (session('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('fail'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        {{ session('fail') }}
                    </div>
                    @endif
                    <div style="display:inline">
                        <h2 class="mt-4 pr-2">Thêm bàn ăn</h2>
                    </div>
                    <div>
                        <form action="{{ route('table_store') }}  " method="POST">
                            @csrf
                            <div>
                                <select name="id_res" id="id_res" class="form-control select_res">
                                    @if(count($get_res)>0)
                                    @foreach($get_res as $item)
                                    <option value="{{ $item->id }}">{{ $item->name_res }} - {{ $item->address_res }} - {{ $item->note_res }}</option>
                                    @endforeach
                                    @else
                                    <option value="">Bạn chưa có cửa hàng!!!. Vui lòng thêm cửa hàng trước</option>
                                    @endif
                                </select>

                            </div>
                            <div>
                                <label for="amount_table">Số lượng bàn</label>
                                <input type="number" name="amount_table" min="1" max="300" maxlength="3" class=" form-control">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn_submit mt-3">Xác nhận</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @endsection
