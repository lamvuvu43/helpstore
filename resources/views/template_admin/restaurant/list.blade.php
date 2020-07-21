@extends('template_admin.index')
@section('pageTitle', 'Danh sách cửa hàng')
@section('list-restaurant')

<div class="row" style="font-family: 'Times New Roman', Times, serif;">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="container">
            <h1 class="mt-4 pr-2">Danh sách cửa hàng</h1>
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
            <table id="example" class="table table-striped table-inverse table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="display:none">ID</th>
                        <th>Tên cửa hàng</th>
                        <th>Địa chỉ</th>
                        <th>Ghi chú</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_restaurant as $item)
                    <tr>
                        <td style="display:none" id="{{$item->id}}">{{$item->id}}</td>
                        <td>{{$item->name_res}} </td>
                        <td>{{$item->address_res}}</td>
                        <td>{{$item->note_res}}</td>
                        <td>
                            <button class="btn btn-danger btn-delete btn_function" data-toggle="modal" data-target="#delete-restaurant"><i class="fas fa-trash-alt"></i></button>
                            <button class="btn btn-success btn-edit  btn_function" data-toggle="modal" data-target="#edit-restaurant"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>
    </div>
    <div class="modal" id="delete-restaurant">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Xoá cửa hàng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body delete-restaurant text-center">
                    <h2>Bạn có thực sử muốn xoá <br> cửa hàng <span style="color: red;"></span> </h2>
                    <p style="display: none" id="id-restaurant"></p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
                    <button type="button" class="btn btn-success btn-delete-restaurant" data-dismiss="modal">Đồng ý</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal" id="edit-restaurant">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Chỉnh sửa thông tin cửa hàng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form class="form-group" action="{{route('update.restaurant')}}" method="post">
                    @csrf
                    <div class="modal-body delete-restaurant text-center">
                        <input name="id_res" value="" style="display:none;" id="id_res">
                        <div class="form-group text-left">
                            <label for="name_res">Tên cửa hàng</label>
                            <input class="form-control" value="" name="name_res" id="name_res">
                        </div>
                        <div class="form-group text-left">
                            <label for="address_res">Địa chỉ cửa hàng</label>
                            <input class="form-control" value="" name="address_res" id="address_res">
                        </div>
                        
                        <div class="form-group text-left">
                            <label for="note_res">Ghi chú</label>
                            <input class="form-control" value="" name="note_res" id="note_res">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-success btn-edit-restaurant">Cập nhật</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
{{-- <script src="{{asset('js/script_table.js')}}"></script> --}}
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "info": "Từ _START_ đến _END_ của _TOTAL_ dòng"
                , "lengthMenu": " Hiện thị _MENU_ dòng "
                , "zeroRecords": "Xin lỗi tôi không tìm thấy"
                , "infoEmpty": "Không có dữ liệu"
                , "infoFiltered": "(tìm thấy trong _MAX_ dòng dữ liệu)"
                , "search": "Tìm kiếm"
                , "paginate": {
                    "previous": "Trước"
                    , "next": "Tiếp theo"
                }
            }
        });

    });
    $(".btn-delete").click(function() {
        var value = $(this).parent().parent().find("td").next().html(); // nếu cột kế bên thì chấm next() sau find
        var id = $(this).parent().parent().find("td").html();
        $('.delete-restaurant').find('span').html(value)
        $('#id-restaurant').html($id);
    });
    // -------------------delete restaurant-----------------------
    $(".btn-delete-restaurant").click(function() {
        var id = $("#id-restaurant").html();
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: "../admin-store/delete-restaurant/" + id
            , type: 'DELETE'
            , data: {
                "id": id
                , "_token": token
            , }
            , success: function() {
                console.log("Delete successful");
                $("#" + id).parent().hide(400);
            }
            ,error:function(){
                alert('Đã có lỗi xảy ra vui lòng kiểm tra lại');
            }
        , });
        
    });

    // --------------------------edit store---------------------------------
    $(".btn-edit").click(function() {
        var $id_res = $(this).parent().parent().find("td").html();
        var $name_res = $(this).parent().parent().find("td").next().html();
        var $address_res = $(this).parent().parent().find("td").next().next().html();
        var $note_res = $(this).parent().parent().find("td").next().next().next().html();
        $("#id_res").val($id_res);
        $("#name_res").val($name_res);
        $("#address_res").val($address_res);
        $("#note_res").val($note_res);
    });

</script>
@endsection()
