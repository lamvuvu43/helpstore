@extends('template_admin.index')
@section('pageTitle', 'Danh sách nhân viên')
@section('list-staff')

<div class="row" style="font-family: 'Times New Roman', Times, serif;">
    <div class="col-12 col-md-12 col-lg-12">

        <div class="container">
            <h1 class="mt-4 pr-2">Danh sách nhân viên</h1>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
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
                            @if(count($get_res)>0)
                            @foreach($get_res as $i => $item)
                            <option value="{{ $item->id }}" class="form-control">{{ $item->name_res }} - {{ $item->note_res }}</option>
                            @endforeach
                            @else
                            <option value="">Bạn chưa có cửa hàng!!!! Vui lòng thêm cửa hàng trước</option>
                            @endif
                        </select>
                    </div>
                    <div>
                        <table id="example" class="table table-striped table-inverse table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="display:none">ID</th>
                                    <th>Tên nhân viên</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Địa chỉ</th>
                                    <th>Ghi chú</th>
                                    <th>Trạng thái</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal" id="delete-staff">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Xoá nhân viên</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body delete-staff text-center">
                    <h2>Bạn có thực sử muốn xoá <br> nhân viên <span style="color: red;"></span> </h2>
                    <p style="display: none" id="id_mem"></p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
                    <button type="button" class="btn btn-success btn-delete-staff" data-dismiss="modal">Đồng ý</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal" id="edit-staff">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Chỉnh sửa nhân viên</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                {{-- Modal body  --}}
                <form class="form-group" action="{{ route('list.stafd.update') }}" method="post">
                    @csrf
                    <div class="modal-body delete-staff text-center">
                        <input name="id" value="" style="display:none;" id="id">
                        <div class="form-group text-left">
                            <label for="name_mem">Tên nhân viên</label>
                            <input class="form-control" value="" name="name_mem" id="name_mem">
                            @error('name_mem')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="phone_mem">Số điện thoại nhân viên</label>
                            <input class="form-control" value="" name="phone" id="phone_mem">
                            @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="email_mem">Email nhân viên</label>
                            <input class="form-control" value="" name="email" id="email_mem">
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="address_mem">Địa chỉ nhân viên</label>
                            <input class="form-control" value="" name="address_mem" id="address_mem">
                        </div>
                        <div class="form-group text-left">
                            <label for="password">Cập nhật mật khẩu</label>
                            <input class="form-control" value="" name="password" id="password">
                        </div>
                        <div class="form-group text-left">
                            <label for="note_mem">Ghi chú</label>
                            <input class="form-control" value="" name="note_mem" id="note_mem">
                        </div>
                        <div class="form-group text-left">
                            <label for="note_mem">Status</label>
                            <select name="status" class="form-control">
                                <option value="">Không khoá</option>
                                <option value="1">Khoá tài khoản</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-success btn-edit-staff">Cập nhật</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>
<script>
    window.onload = function() {
        var id_res = $('#id_res').val();
        $.ajax({
            url: "{{ route('list.staff.show','') }}/" + id_res
            , type: "GET"
            , dataType: "json"
            , success: function(data) {
                var staff_data = '';
                $.each(data, function(key, value) {
                    staff_data += "<tr>";
                    staff_data += "<td style='display:none'>" + value.id_user + "</td>"
                    staff_data += "<td>" + value.username + "</td>"
                    staff_data += "<td>" + value.phone + "</td>"
                    staff_data += "<td>" + value.email + "</td>"
                    staff_data += " <td>" + value.address + "</td>"
                    staff_data += "<td>" + value.note_mem + "</td>";
                    if (value.status == 1) {
                        staff_data += "<td>Bị khoá</td>";
                    } else {
                        staff_data += "<td></td>";
                    }
                    staff_data += " <td> <a class = 'btn btn-primary btn-edit btn_function' data-toggle='modal' data-target='#edit-staff'> <i class='fas fa-edit'></i>  <a class = 'btn btn-danger btn-delete btn_function' data-toggle = 'modal' data-target = '#delete-staff' > <i class='far fa-trash-alt'></i></td></tr>";
                });
                $("#example").find('tbody').html(staff_data);

                $('#example').DataTable({
                    destroy: true
                    , "language": {
                        "info": "Từ _START_ đến _END_ của _TOTAL_ dòng"
                        , "lengthMenu": " Hiện thị _MENU_ dòng "
                        , "zeroRecords": "Không có giữ liệu"
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
        });
    }
    $("#id_res").change(function() {
        var id_res = $(this).val();
        $.ajax({
            url: "{{ route('list.staff.show','') }}/" + id_res
            , type: "GET"
            , dataType: "json"
            , success: function(data) {
                var staff_data = '';
                $.each(data, function(key, value) {
                    staff_data += "<tr>";
                    staff_data += "<td style='display:none'>" + value.id_user + "</td>"
                    staff_data += "<td>" + value.username + "</td>"
                    staff_data += "<td>" + value.phone + "</td>"
                    staff_data += "<td>" + value.email + "</td>"
                    staff_data += " <td>" + value.address + "</td>"
                    staff_data += "<td>" + value.note_mem + "</td>";
                    if (value.status == 1) {
                        staff_data += "<td>Bị khoá</td>";
                    } else {
                        staff_data += "<td></td>";
                    }
                    staff_data += " <td> <a class = 'btn btn-primary btn-edit btn_function' data-toggle='modal' data-target='#edit-staff'> <i class='fas fa-edit'></i>  <a class = 'btn btn-danger btn-delete btn_function' data-toggle = 'modal' data-target = '#delete-staff' > <i class='far fa-trash-alt'></i></td></tr>";
                });
                $("#example").find('tbody').html(staff_data);
                $(document).on(function() {
                    $('#example').DataTable({
                        destroy: true
                        , "language": {
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
        });
    });
    // ----------------script edit staff-------------------------------
    $(document).on('click', '.btn-edit', function() {
        var id_mem = $(this).parent().parent().find('td').html();
        var name_mem = $(this).parent().parent().find('td').next().html();
        var phone_mem = $(this).parent().parent().find('td').next().next().html();
        var email_mem = $(this).parent().parent().find('td').next().next().next().html();
        var address_mem = $(this).parent().parent().find('td').next().next().next().next().html();
        var note_mem = $(this).parent().parent().find('td').next().next().next().next().next().html();
        // console.log(id_mem + name_mem + phone_mem + email_mem + address_mem);
        setTimeout(function() {
            $('#id').val(id_mem)
            $("#name_mem").val(name_mem);
            $("#phone_mem").val(phone_mem);
            $("#email_mem").val(email_mem);
            $("#address_mem").val(address_mem);
            $("#note_mem").val(note_mem);
        }, 500)
    });

    $(document).on('click', '.btn-delete', function() {
        var id_mem = $(this).parent().parent().find('td').html();
        var name_mem = $(this).parent().parent().find('td').next().html();
        $(this).parent().parent().find('td').addClass('remove_tr');
        // console.log(id_mem + name_mem + phone_mem + email_mem + address_mem);
        $('.delete-staff').find('span').html(name_mem);
        $('#id_mem').html(id_mem);
    });
    $('.btn-delete-staff').click(function() {
        var id = $("#id_mem").html();
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: "../admin-store/staff-delete/" + id
            , type: 'DELETE'
            , data: {
                "id": id
                , "_token": token
            , }
            , success: function() {
                console.log("Delete successful");
                $('.remove_tr').parent().hide(500);
            }
            , error: function() {
                alert('Đã có lỗi xảy ra vui lòng kiểm tra lại');
            }
        , });

    });

</script>
@endsection
