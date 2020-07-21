@extends('template_admin.index')
@section('pageTile', 'Thêm bàn ăn')
@section('create_table')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    @if (session('success'))
                    <div class="alert alert-success alert_hide">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('fail'))
                    <div class="alert alert-danger alert_hide">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        {{ session('fail') }}
                    </div>
                    @endif
                    <div style="display:inline">
                        <h2 class="mt-4 pr-2">Danh sách bàn ăn</h2>
                    </div>
                    <div>
                        <label for="id_res">Chọn cửa hàng cần xem</label>
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
                    <div class="mt-3">
                        <table class="table text-center" id="list_table">
                            <thead>
                                <tr class="table-active">
                                    <th>STT</th>
                                    <th style="display:none">id</th>
                                    <th>Tên Bàn</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="modal_edit" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Sửa tên bàn</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" id="id_table" name="id_table" style="display:none">
                                    <label for="">Tên bàn</label>
                                    <input type="text" name="name_table" value="" id="name_table" maxlength="30" class="form-control">

                                </div>
                                <div class="modal-footer text-left">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Huỷ</button>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary btn_update_table" data-dismiss="modal">Cập nhật</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal fade" id="modal_delete" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Xoá bàn</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h3>Bạn có chắc chắn muốn xoá bàn</h3>
                                    </div>
                                    <div id="name_table_delete" class="text-center" style="color: red">
                                        <h4></h4>
                                    </div>
                                    <input type="text" name="id_table" value="" id="id_table_delete" class="form-control">

                                </div>
                                <div class="modal-footer text-left">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Huỷ</button>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary btn_delete_table" data-dismiss="modal">Đồng ý</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
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
                url: "{{ route('table_list_id_res','') }}/" + id_res
                , type: "GET"
                , dataType: "json"
                , success: function(data) {
                    // $('#list_table').find('tbody').empty();
                    var table_data = '';
                    $.each(data, function(key, value) {
                        // console.log(value);
                        table_data += '<tr>';
                        table_data += '<td>' + value.stt + '</td>';
                        table_data += '<td style="display:none" class=' + value.id + '>' + value.id + '</td>';
                        table_data += '<td class="name_table">' + value.name_table + '</td>';
                        table_data += '<td><button class="btn btn-primary btn_edit_table mr-2" data-toggle=\"modal\" data-target=\"#modal_edit\">Sửa</button><button class="btn btn-danger btn_delete_table" data-toggle=\"modal\" data-target=\"#modal_delete\">Xoá</button></td></td>';
                        table_data += '</tr>';
                    });
                    $('#list_table').find('tbody').html(table_data);
                    $('#list_table').DataTable({
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
                }
            });


        }



        var token = $("meta[name='csrf-token']").attr("content");

        $('#id_res').change(function() {
            var id_res = $(this).val();
            $.ajax({
                url: "{{ route('table_list_id_res','') }}/" + id_res
                , type: "GET"
                , dataType: "json"
                , success: function(data) {
                    var table_data = '';
                    $.each(data, function(key, value) {
                        // console.log(value);
                        table_data += '<tr>';
                        table_data += '<td>' + value.stt + '</td>';
                        table_data += '<td style="display:none" class=' + value.id + '>' + value.id + '</td>';
                        table_data += '<td class="name_table">' + value.name_table + '</td>';
                        table_data += '<td><button class="btn btn-primary btn_edit_table mr-2" data-toggle=\"modal\" data-target=\"#modal_edit\">Sửa</button><button class="btn btn-danger btn_delete_table" data-toggle=\"modal\" data-target=\"#modal_delete\">Xoá</button></td></td>';
                        table_data += '</tr>';
                    });
                    $('#list_table').find('tbody').html(table_data);
                    $(document).on(function() {
                        $('#list_table').DataTable({
                            destroy: true
                            , "language": {
                                "info": "Từ _START_ đến _END_ của _TOTAL_ dòng"
                                , "lengthMenu": " Hiện thị _MENU_ dòng "
                                , "zeroRecords": "Không có giữ liệu"
                                , "infoEmpty": "Không có giữ liệu"
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
            })
        });

        $(document).on('click', '.btn_edit_table', function() {
            var id_table = $(this).parent().parent().find('td').next().html();
            var name_table = $(this).parent().parent().find('.name_table').html();
            // console.log(id_table);
            $('#id_table').val(id_table);
            $('#name_table').val(name_table);
        });
        $('.btn_update_table').click(function() {
            var id_table = $('#id_table').val();
            var name_table = $('#name_table').val();
            $.ajax({
                url: "{{ route('table_update') }}?id_table=" + id_table + '&name_table=' + name_table
                , type: "POST"
                , dataType: "json"
                , data: {
                    '_token': token
                }
                , success: function(data) {
                    // không hiện thị đc data json
                    $('.' + id_table).parent().find('.name_table').html(name_table)
                }
            })

        });
        $(document).on('click', '.btn_delete_table', function() {
            var id_table = $(this).parent().parent().find('td').next().html();
            var name_table = $(this).parent().parent().find('.name_table').html();
            $('#id_table_delete').val(id_table);
            $('#name_table_delete').find('h4').html(name_table);
        });
        $('.btn_delete_table').click(function() {
            var id_table = $('#id_table_delete').val();
            $.ajax({
                url: "{{ route('table_delete','') }}/" + id_table
                , type: "delete"
                , data: {
                    '_token': token
                }
                , success: function(data) {
                    // không hiện thị đc data json
                    console.log(data);
                    $('.' + id_table).parent().hide(400);
                }
            })

        })

    </script>
    @endsection
