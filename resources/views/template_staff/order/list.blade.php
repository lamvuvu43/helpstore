@extends('template_staff.index')
@section('pageTile', 'Kiểm tra đơn hàng')
@section('staff_list_order')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="container">

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
                <h2 class="mt-4 pr-2">Quản lý đơn hàng</h2>
            </div>
            <div class="form-order">
                <div>

                    <div style="display:none" id="id_res">{{ $check_staff->restaurant->id }}</div>
                    <div class="name_res"> Cửa hàng <h4>{{ $check_staff->restaurant->name_res }} - {{ $check_staff->restaurant->address_res }} - {{ $check_staff->restaurant->note_res }}</h4>

                    </div>
                    <div class="filter">
                        <h3>Lọc</h3>
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-4">
                                <label class="label_check">Chưa xác nhận
                                    <input type="checkbox" checked="checked" name="no_accept" value="no_accept" class="check_filter check_filter_no_accept">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <label class="label_check">Đã xác nhận
                                    <input type="checkbox" name="payed" value="accept" class="check_filter">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <label class="label_check">Đã thanh toán
                                    <input type="checkbox" name="payed" value="payed" class="check_filter ">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="list_order_food mt-3">
                        <div>
                             <h4 id="date"> Đơn của ngày: <?php  echo  date('d-m-Y') ?></h4>
                        </div>

                        <table class=" table  text-center" id="order_table">
                            {{-- <caption>Dánh sách món ăn</caption> --}}
                            <thead>
                                <tr class="table-active">
                                    <th>Mã đơn hàng</th>
                                    <th>Nhân viên</th>
                                    <th>Vị trí</th>
                                    <th>Tổng số tiền</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                    <div id="table_food_selected">
                        <table class="table ">
                            <thead>
                                <tr class="table-success">
                                    <th>STT</th>
                                    <th style="display:none">id_f</th>
                                    <th>Tên món</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <form action="{{ route('choose_food') }}" method="post">
                                @csrf
                                <tbody>

                                </tbody>
                                <div><button type="submit" class="btn btn-success mb-3  submit_order">Xác nhận đơn
                                        hàng</button></div>
                                <thead>
                                    <tr class=" text-left">
                                        <input name="id_res" id="id_res_for_bill" value="" style="display:none">
                                        <td colspan="2" style="background-color: aqua; font-size:20px">Tổng số lượng: </td>
                                        <td style="background-color: aqua; font-size:20px"><input type="text" id="total_amount" name="total_amount" value="" readonly></td>
                                        <td colspan="2" style="background-color: #28A745;font-size:20px">Tổng cộng: </td>
                                        <td style="background-color: rgb(207, 189, 182);font-size:20px"><input type="text" id="total_price" name="total_price" value="" readonly> </td>
                                    </tr>
                                </thead>
                            </form>
                        </table>
                    </div>

                    <div class="modal fade m-0" id="detail_modal" role="dialog">
                        <div class="modal-dialog  modal-xl">
                            <div class="modal-content" style="overflow:auto">
                                <div class="modal-body" id="content_bill">
                                    <div class="bg-warning text-center" style="overflow:auto">
                                        <h4 class="mt-2 mb-2">Hoá đơn</h4>
                                    </div>
                                    <table id="detail_order" class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên Món ăn</th>
                                                <th>Số lượng</th>
                                                <th>Đơn giá</th>
                                                <th>Ghi chú</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="bg-default modal-footer">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-lg-6 text-left">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-6 text-right" id="btn_function">
                                                <button type="button" class="btn btn-success" id="print_bill">In hoá
                                                    đơn</button>
                                            </div>
                                        </div>
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
        var id_res = $('#id_res').html();
        window.onload = function() {
            var filter = 'no_accept';
            // load_table(filter, id_res);
            $.ajax({
                url: "{{ route('staff.filter_list',['','']) }}/" + filter + '/' + id_res 
                , type: "GET"
                , dataType: "json"
                , success: function(data) {
                    // $('#list_order').html(data);
                    // console.log(data);
                    var bill_data = '';
                    $.each(data, function(key, value) {
                        bill_data += '<tr class="' + value.id_bill + '">';
                        bill_data += '<td>'
                        bill_data += "<button class='btn btn-outline-primary btn_detail'>" + value.id_bill + "</button>";
                        bill_data += '</td>';
                        bill_data += '<td>' + value.username + '</td>';

                        bill_data += '<td>' + value.table + '</td>';
                        bill_data += '<td>' + value.total_price + '</td>';
                        bill_data += '<td>' + value.date + '</td>';
                        bill_data += '<td>';
                        if (value.status == 'no_accept') {
                            bill_data += 'Chưa xác nhận';
                            bill_data += '</td>';
                            bill_data += '<td class="btn_function">No Permision</td > ';
                        } else {
                            if (value.status == 'accept') {
                                bill_data += 'Đã xác nhận';
                                bill_data += '</td>';
                                bill_data += '<td class="btn_function"><button class="btn btn-success pay " data-dismiss=" modal">Thanh toán < /button> </td > ';
                            } else {
                                if (value.status == 'payed') {
                                    bill_data += 'Đã thanh toán';
                                    bill_data += '</td>';
                                    bill_data += '<td class="btn_function"><button class="btn btn-danger " data-dismiss=" modal">Order lại</button> </td>';
                                } else {
                                    bill_data += 'Chưa thanh toán';
                                    bill_data += '</td>';
                                    bill_data += '<td class="btn_function"><button class="btn btn-primary" data-dismiss="modal">Thanh toán</button> </td>';
                                }
                            }
                        }

                        bill_data += '</tr>';
                    });
                    $('#order_table').find('tbody').html(bill_data);
                    $('#order_table').DataTable({
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
                , error: function(e) {
                    console.log(e.responseJSON.message);
                }
            });
        }
        $('#id_res').change(function() {
            id_res = $(this).val();
            check_id_res(id_res);

        });
        // ------------------checkbox one-----------------------------------
        $('input[type="checkbox"]').on('change', function() {
            $('input[type="checkbox"]').not(this).prop('checked', false);
        });

        // ----------------------------------function load table---------------------------
        function load_table(filter, id_res) {
            $.ajax({
                url: "{{ route('staff.filter_list',['','']) }}/" + filter + '/' + id_res
                , type: "GET"
                , dataType: "json"
                , success: function(data) {
                    // $('#list_order').html(data);
                    // console.log(data);
                    var bill_data = '';
                    $.each(data, function(key, value) {
                        bill_data += '<tr class="' + value.id_bill + '">';
                        bill_data += '<td>'
                        bill_data += "<button class='btn btn-outline-primary btn_detail'>" + value.id_bill + "</button>";
                        bill_data += '</td>';
                        bill_data += '<td>' + value.username + '</td>';
                        bill_data += '<td>' + value.table + '</td>';
                        bill_data += '<td>' + value.total_price + '</td>';
                        bill_data += '<td>' + value.date + '</td>';
                        bill_data += '<td>';
                        if (value.status == 'no_accept') {
                            bill_data += 'Chưa xác nhận';
                            bill_data += '</td>';
                            bill_data += '<td class="btn_function"><button class="btn btn-outline-primary accept" data-dismiss="modal">Xác nhận </button> </td> ';
                        } else {
                            if (value.status == 'accept') {
                                bill_data += 'Đã xác nhận';
                                bill_data += '</td>';
                                bill_data += '<td class="btn_function"><button class="btn btn-success pay " data-dismiss=" modal">Thanh toán </button> </td> ';
                            } else {
                                if (value.status == 'payed') {
                                    bill_data += 'Đã thanh toán';
                                    bill_data += '</td>';
                                    bill_data += '<td class="btn_function"><button class="btn btn-danger " data-dismiss=" modal">Order lại</button> </td>';
                                } else {
                                    bill_data += 'Chưa thanh toán';
                                    bill_data += '</td>';
                                    bill_data += '<td class="btn_function"><button class="btn btn-primary" data-dismiss="modal">Thanh toán</button> </td>';
                                }
                            }
                        }
                        bill_data += '</tr>';
                    });
                    $('#order_table').find('tbody').html(bill_data);
                    // console.log(bill_data);
                    $(document).on(function() {
                        $('#order_table').DataTable({
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
                , error: function(e) {
                    console.log(e.responseJSON.message);
                }
            });
        }
        // -----------------------------check filter id_res change---------------------------

        function check_id_res(id_res) {
            $('.check_filter').each(function() {
                if ($(this).val() == 'all') {
                    $('#date').hide();
                } else {
                    $('#date').show();
                }
                if ($(this).prop('checked') == true) {
                    var filter = $(this).val();
                    // console.log(filter);
                    load_table(filter, id_res)

                }
            })
        }
        // -----------------------------event check----------------------------

        $('.check_filter').change(function() {
            if ($(this).is(':checked') == true) {
                var filter = $(this).val();

                // console.log(filter);
                get_value_checkbox(null);

                load_table(filter, id_res);
            }
        });
        $(document).on('click', '.pay', function() {
            var id_b = $(this).parent().parent().find('button').html();
            // $('#detail_modal').modal('hide');
            $(this).html("Order lại").delay(500);
            $(this).removeClass('btn-success');
            $(this).addClass('btn-danger');

            $.ajax({
                url: "{{ route('list_update_status',['','']) }}/payed/" + id_b //  thanh toán
                , type: "GET"
                , success: function(data) {
                    get_value_checkbox(id_b);

                    console.log(data);
                }
                , error: function(e) {
                    console.log(e.responseJSON.message);
                }
            });
        });
        // ----------------------------------get val checkbox checked----------------
        function get_value_checkbox(id_b) {
            $.each($('.check_filter'), function() {
                if ($(this).is(':checked') == true) {
                    if ($(this).val() != 'all') {
                        $('.' + id_b).hide(500);
                        $('#date').show();

                    } else {
                        $('#date').hide();
                    }
                }
            })
        }
        // -----------------------------------------------------
        $(document).on('click', '.accept', function() {
            var id_b = $(this).parent().parent().find('button').html();
            // $('#detail_modal').modal('hide');
            $(this).removeClass('accept');
            $(this).addClass('pay');
            $(this).html("Thanh toán").delay(500);
            $.ajax({
                url: "{{ route('list_update_status',['','']) }}/accept/" + id_b // xác nhân đơn
                , type: "GET"
                , success: function(data) {
                    get_value_checkbox(id_b);

                    console.log(data);

                }
                , error: function(e) {
                    console.log(e.responseJSON.message);
                }
            });
        })

    </script>
    <script>
        $(document).on('click', '.btn_detail', function() {
            id_bill = $(this).html();
            btn_function = $(this).parent().parent().find('.btn_function').html();
            // $('#btn_function').html(btn_function);
            // console.log(id_bill)
            $('#detail_modal').modal('show');

            $.ajax({
                url: "{{ route('detail_bill','') }}/" + id_bill
                , type: "GET"
                , dataType: "json"
                , success: function(data) {
                    var DetailBill_Data = '';
                    $.each(data, function(key, value) {
                        DetailBill_Data += "<tr>";
                        DetailBill_Data += "<td>" + value.stt + "</td>";
                        DetailBill_Data += "<td>" + value.name + "</td>";
                        DetailBill_Data += "<td>" + value.amount + "</td>";
                        DetailBill_Data += "<td>" + value.price + "</td>";
                        DetailBill_Data += "<td>" + value.note + "</td>";
                        DetailBill_Data += "<td>" + value.total + "</td>";
                        DetailBill_Data += "</tr>";
                    });
                    $('#detail_order').find('tbody').html(DetailBill_Data);

                }
                , error: function(e) {
                    console.log(e.responseJSON.message);
                }
            });
        });

    </script>
    {{-- ---------------------print bill--------------------------------- --}}
    <script>
        $('#print_bill').click(function() {
            printDiv();

        })

        function printDiv() {

            // var divToPrint = document.getElementById('content_bill');
            // var newWin = window.open('', 'Print-Window');
            // newWin.document.open();
            // newWin.document.write('<html><body onload = "window.print()" > ' + divToPrint.innerHTML + ' </body> </html > ');
            // newWin.document.close();
            // setTimeout(function() {
            //     newWin.close();
            // }, 1000);

            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById('content_bill').innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
            location.reload();
        }

        // -- -- -- -- -- -- -- -- -- -- --cập nhật đơn hàng-- -- -- -- -- -- -- -- -- -- - --

    </script>
    @endsection
