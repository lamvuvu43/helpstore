@extends('template_admin.index')
@section('pageTitle', 'Danh sách cửa hàng')
@section('list-restaurant')

<div class="row" style="font-family: 'Times New Roman', Times, serif;">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="container">
            <h1 class="mt-4 pr-2">Danh sách món ăn</h1>
            @if (session('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ session('success') }}
            </div>
            @endif
            @if (session('update_success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ session('update_success') }}
            </div>
            @endif
            <div class="select-store mb-2 mt-2">
                <label class="form-group">Chọn cửa hàng cần xem</label>
                <select name="id_res" class="form-control select_res" id="id_res" select_res>
                    @foreach($get_res as $i => $item)
                    <option value="{{ $item->id }}" class="form-control">{{ $item->name_res }} - {{ $item->note_res }}</option>
                    @endforeach
                </select>
            </div>
            <table id="example" class="table table-striped table-inverse table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="display:none">ID</th>
                        <th>Tên món ăn</th>
                        <th>Đơn giá</th>
                        <th>hình ảnh</th>
                        <th>Ghi chú</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>
    </div>
    <div class="modal" id="delete-food">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Xoá cửa hàng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body delete-food text-center">
                    <h2>Bạn có thực sử muốn xoá <br> món ăn <span style="color: red;"></span> </h2>
                    <p style="display: none" id="id_food"></p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
                    <button type="button" class="btn btn-success btn-delete-food" data-dismiss="modal">Đồng ý</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal" id="edit-food">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Chỉnh sửa thông tin món ăn</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form class="form-group" action="{{ route('list.food.update') }}" method="post">
                    @csrf
                    <div class="modal-body delete-restaurant text-center">
                        <input name="id_f" value="" style="display:none;" id="id_f">
                        <div class="form-group text-left">
                            <label for="name_f">Tên món ăn</label>
                            <input class="form-control" value="" name="name_f" id="name_f">
                        </div>
                        <div class="form-group text-left">
                            <label for="price_f">Đơn giá</label>
                            <input class="form-control money" value="" name="price_f" id="price_f">
                        </div>
                        <div class="form-group text-left">
                            <label>Hình ảnh</label>
                            <a class="btn btn-outline-success form-control" href="" id="edit_image">Click để chỉnh sửa hình ảnh</a>
                        </div>
                        <div class="form-group text-left">
                            <label for="note_f">Ghi chú</label>
                            <input class="form-control" value="" name="note_f" id="note_f">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-success btn-edit-food">Cập nhật</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
{{-- <script src="{{asset('js/script_table.js')}}"></script> --}}
<script>
    window.onload = function() {
        var id_res = $('#id_res').val();
        // console.log(id_res);
        // $.get('{{ route('list.food.show','') }}/' + id_res, function(data) {
        //     $('#example').find('tbody').html(data);
        // });

        $.ajax({
            url: "{{ route('list.food.show','') }}/" + id_res
            , type: "GET"
            , dataType: "json"
            , success: function(data) {
                console.log(data);
                $food_data = '';
                $.each(data, function(key, value) {
                    $food_data += "<tr>";
                    $food_data += "<td style='display:none' id='" + value.id + "'>" + value.id + "</td>";
                    $food_data += "<td>" + value.name_f + "</td>";
                    $food_data += "<td class='money'>" + value.price_f + "</td>";
                    $food_data += "<td>";
                    $.each(value.link_image, function(key1, value1) {
                        $food_data += "<img src='" + value1.link_image + "' class='image_f'>";
                    });
                    $food_data += "</td>";
                    $food_data += "<td>" + value.note_f + "</td>"
                    $food_data += "<td>";
                    $food_data += "<a class='btn btn-primary btn-edit btn_function' data-toggle='modal' data-target='#edit-food'><i class=\"fas fa-edit\"></i></a>"
                    $food_data += "<a class='btn btn-danger btn-delete btn_function' data-toggle='modal' data-target='#delete-food'><i class=\"far fa-trash-alt\"></i></a>"
                    $food_data += "</td>";
                    $food_data += "</tr>";
                });
                $('#example').find('tbody').html($food_data);

                $('#example').DataTable({
                    "language": {
                        "info": "Từ _START_ đến _END_ của _TOTAL_ dòng"
                        , "lengthMenu": " Hiện thị _MENU_ dòng "
                        , "zeroRecords": "Xin lỗi tôi không tìm thấy"
                        , "infoEmpty": ""
                        , "infoFiltered": "(tìm thấy trong _MAX_ dòng dữ liệu)"
                        , "search": "Tìm kiếm"
                        , "paginate": {
                            "previous": "Trước"
                            , "next": "Tiếp theo"
                        }
                    }
                });
            }
            , error: function(e) {
                console.log(e.responseJSON.message);
            }
        })
    }
    $('#id_res').change(function() {
        var id_res = $(this).val();
        $.ajax({
            url: "{{ route('list.food.show','') }}/" + id_res
            , type: "GET"
            , dataType: "json"
            , success: function(data) {
                console.log(data);
                $food_data = '';
                $.each(data, function(key, value) {
                    $food_data += "<tr>";
                    $food_data += "<td style='display:none' id='" + value.id + "'>" + value.id + "</td>";
                    $food_data += "<td>" + value.name_f + "</td>";
                    $food_data += "<td class='money'>" + value.price_f + "</td>";
                    $food_data += "<td>";
                    $.each(value.link_image, function(key1, value1) {
                        $food_data += "<img src='" + value1.link_image + "' class='image_f'>";
                    });
                    $food_data += "</td>";
                    $food_data += "<td>" + value.note_f + "</td>"
                    $food_data += "<td>";
                    $food_data += "<a class='btn btn-primary btn-edit btn_function' data-toggle='modal' data-target='#edit-food'><i class=\"fas fa-edit\"></i></a>"
                    $food_data += "<a class='btn btn-danger btn-delete btn_function' data-toggle='modal' data-target='#delete-food'><i class=\"far fa-trash-alt\"></i></a>"
                    $food_data += "</td>";
                    $food_data += "</tr>";
                });
                $('#example').find('tbody').html($food_data);
                $(document).on(function() {
                    $('#example').DataTable({
                        "language": {
                            "info": "Từ _START_ đến _END_ của _TOTAL_ dòng"
                            , "lengthMenu": " Hiện thị _MENU_ dòng "
                            , "zeroRecords": "Xin lỗi tôi không tìm thấy"
                            , "infoEmpty": ""
                            , "infoFiltered": "(tìm thấy trong _MAX_ dòng dữ liệu)"
                            , "search": "Tìm kiếm"
                            , "paginate": {
                                "previous": "Trước"
                                , "next": "Tiếp theo"
                            }
                        }
                    });

                });

            }
            , error: function(e) {
                console.log(e.responseJSON.message);
            }
        })

    })




    $(".btn-delete").click(function() {
        var $value = $(this).parent().parent().find("td").next().html(); // nếu cột kế bên thì chấm next() sau find
        var $id = $(this).parent().parent().find("td").html();
        $('#id-restaurant').html($id);
    });
    $(document).on('click', '.btn-delete', function() {
        var id_f = $(this).parent().parent().find("td").html();
        var name_f = $(this).parent().parent().find("td").next().html();
        $('.delete-food').find('span').html(name_f);
        $('#id_food').html(id_f)
    });
    // -------------------delete restaurant-----------------------
    $(document).on('click', '.btn-delete-food', function() {
        var id = $("#id_food").html();
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: "../admin-store/food-delete/" + id
            , type: 'DELETE'
            , data: {
                "id": id
                , "_token": token
            , }
            , success: function(data) {
                console.log(data);
                $("#" + id).parent().hide(500);
            }
            , error: function() {
                alert('Đã có lỗi xảy ra vui lòng kiểm tra lại');
            }
        , });

    })
    // --------------------------edit food---------------------------------

    $(document).on('click', '.btn-edit', function() {
        var id_f = $(this).parent().parent().find("td").html();
        var name_f = $(this).parent().parent().find("td").next().html();
        var price_f = $(this).parent().parent().find("td").next().next().html();
        var note_f = $(this).parent().parent().find("td").next().next().next().next().html();
        $("#id_f").val(id_f);
        $("#name_f").val(name_f);
        $("#price_f").val(price_f);
        $("#note_f").val(note_f);
        $("#edit_image").attr("href", "../admin-store/food-edit_image/" + id_f);
    })

</script>
{{-- ------------Thêm dấu , vào money------------- --}}
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

<script type="text/javascript" src="{{ asset('js/simple.money.format.js') }}"></script>
<script type="text/javascript">
    $('.money').simpleMoneyFormat();

</script>
{{-- ------------------------------------------------------ --}}
@endsection()
