@extends('template_staff.index')
@section('pageTitle', 'Tạo đơn hàng')
@section('staff_create_order')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="container">
            @if (session('success'))
            <div class="alert alert-success mt-3">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ session('success') }}
            </div>
            @endif
            @if (session('fail'))
            <div class="alert alert-danger mt-3">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ session('fail') }}
            </div>
            @endif
            <div style="display:inline">
                <h2 class="mt-4 pr-2">Tạo đơn hàng</h2>
                <div class="text-right"><button class="btn btn-primary notification" id="show_selected"><span><i class="fas fa-shopping-cart"></i><!--<span class="badge">3</span> --></span></button></div>




            </div>


            <div class="form-order">
                <div>
                    <div style="display:none" id="id_res">{{ $check_staff->restaurant->id }}</div>
                    <div class="name_res"> Cửa hàng <h4>{{ $check_staff->restaurant->name_res }} - {{ $check_staff->restaurant->address_res }} - {{ $check_staff->restaurant->note_res }}</h4>


                    </div>

                </div>

            </div>
            <div class="row">
                <div class="container">
                    <div class="row mt-3  mr-3 pb-3 pr-3" id="select_table">

                    </div>
                </div>
            </div>
            <div class="search" style="display: none;">
                <label>Nhập để tìm kiếm</label>
                <input placeholder="Search food" class="form-control" name="skill_input" id="skill_input">
                <input type="text" id='food_id' class="form-control" readonly style="display:none">
            </div>
            <div class="select_food mt-3" style="display: none;">
                <table class=" table  text-center">
                    <caption>Dánh sách món ăn</caption>
                    {{-- <tr class=" text-left">
                            <td colspan="4" style="border: 3px solid #28A745">Tổng cộng</td>
                            <td id="price" style="border: 3px solid #007BFF">7000</td>
                        </tr> --}}
                    <thead>
                        <tr class="table-active">
                            <th>STT</th>
                            <th>Tên món</th>
                            <th>Hình ảnh</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Ghi chú</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="list_food">
                        {{-- <tr><td>1</td><td>Bún đậu</td><td class="money">45000</td><td><input type="number" min="1" max="100" value="1" class="form-control"></td><td ><button class="btn btn-primary" style="border-radius:50%"><i class="fas fa-plus"></i></button></td></tr> --}}
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
                            <th>Ghi chú</th>

                            <th>Thành tiền</th>

                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <form action="{{ route('staff.choose_food') }}" method="post" id="form_submit_order">

                        @csrf
                        <tbody>

                        </tbody>
                        <div><button type="submit" class="btn btn-success mb-3  submit_order">Xác nhận đơn hàng</button></div>


                        <thead>
                            <tr class=" text-left">
                                <input type="text" name="id_table" id="id_table_for_bill" value="" style="display:none">
                                <input name="id_res" id="id_res_for_bill" value="" style="display:none">
                                <td colspan="2" style="background-color: aqua; font-size:20px">Tổng số lượng: </td>
                                <td style="background-color: aqua; font-size:20px"><input type="text" id="total_amount" name="total_amount" value="" readonly></td>
                                <td colspan="3" style="background-color: #28A745;font-size:20px">Tổng cộng: </td>

                                <td style="background-color: rgb(207, 189, 182);font-size:20px"><input type="text" id="total_price" name="total_price" value="" readonly> </td>
                            </tr>
                        </thead>
                    </form>
                </table>

            </div>
            <div id="note_modal" class="modal fade" role="dialog">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label for="note_food">Ghi chú</label>
                            <textarea name="note_food" id="note_food" cols="1" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default note_complete" data-dismiss="modal">Xong</button>
                        </div>
                    </div>

                </div>
            </div>
            <div id="note_modal_cart" class="modal fade" role="dialog">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label for="note_food">Ghi chú</label>
                            <textarea name="note_food" id="note_food_cart" cols="1" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default note_complete_cart" data-dismiss="modal">Xong</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>



    </div>
</div>

{{-- ------------------------------------------------------ --}}
<script type="text/javascript">
    var id_table = '';
    window.onload = function() {
        var id_res = $("#id_res").html();
        get_food(id_res);
        get_table(id_res);
        $.ajax({
            url: "{{ route('get_name_res','') }}/" + id_res
            , type: "GET"
            , success: function(data) {
                $('#name_res').html(data);
            }
            , error: function(e) {
                console.log(e.responseJSON.message);
            }
        });
    }


    $(document).on('click', '.choose_table', function() {

        $('.choose_table').removeClass('table_selected');
        $(this).addClass('table_selected');
        id_table = $(this).parent().find('.id_table').html();
        $('#id_table_for_bill').val(id_table);
    });

    function get_food(id_res) {
        $.get("{{ route('create_order_get_list_food','') }}/" + id_res, function(data) {

            $("#list_food").html(data);
            // console.log(data);
        })
    }



    function get_table(id_res) {
        $.get("{{ route('create_order_list_table','') }}/" + id_res, function(data) {
            $('#select_table').html(data);
        });
    }

    // ----------------------auto complete--------------
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    function get_id_res() {
        var id_res = $("#id_res").html();
        return id_res;
    }


    $("#skill_input").autocomplete({
        source: function(request, response) {
            // Fetch data
            $.ajax({
                url: "../admin-store/order_autocomplete/" + get_id_res()
                , type: 'post'
                , dataType: "json"
                , data: {
                    "_token": CSRF_TOKEN
                    , "search": request.term
                    , "id": get_id_res()
                }
                , success: function(data) {
                    response(data);
                    // console.log(data);

                }
            });
        }
        , minLength: 2
        , select: function(event, ui) {
            // Set selection
            // console.log(ui.item.test)
            $('#skill_input').val(ui.item.label); // display the selected text
            $('#food_id').val(ui.item.value); // save selected id to input
            get_id_f_autocomplete();
            return false;
        }
    });

    function get_id_f_autocomplete() {
        var id_f = $('#food_id').val();
        $.ajax({
            url: "{{ route('send_required','') }}/" + get_id_res() + "?id_f=" + id_f + "&amount_f=1"
            , type: 'post'
            , data: {
                '_token': token
            }
            , success: function(data) {
                console.log('add to cart success', data);
            }
            , error: function() {
                alert('Có lỗi!!! Vui lòng liên hệ với quản trị viên ');
            }
        });
    }

    $("#show_selected").click(function() {
        $("#table_food_selected").slideToggle(500);

        $('#id_res_for_bill').val(get_id_res());
        $.ajax({
            url: "{{ route('list_food_choose','') }}/" + get_id_res()

            , type: "GET"
            , success: function(data) {
                $("#table_food_selected").find("tbody").html(data);
                $('#total_price').val(sum_price());
                $("#total_amount").val(total_amount());
            }
            , error: function() {
                alert('Có lỗi vui lòng liên hệ với quản trị viên');
            }
        });
        




    })

</script>
{{-- ----------------nút add-------------- --}}
<script>
    var token = $("meta[name='csrf-token']").attr("content");
    var i = 1;
    $(document).on("click", ".add_food", function() {
        var id_f = $(this).parent().parent().find('td').html();
        // var name_f = $(this).parent().parent().find('.name_f').html();
        var note_f = $(this).parent().parent().find('.note_food').val();
        var amount_f = $(this).parent().parent().find('.amount').val();
        if (id_table == '') {
            alert('Bạn chưa chọn bàn. Vui lòng chọn bàn trước ')
        } else {
            $.ajax({
                url: "{{ route('send_required','') }}/" + get_id_res() + "?id_f=" + id_f + "&amount_f=" + amount_f + "&note_f=" + note_f
                , type: 'post'
                , data: {
                    '_token': token
                }
                , success: function(data) {
                    console.log('add to cart success', data);
                }
                , error: function() {
                    alert('Có lỗi!!! Vui lòng liên hệ với quản trị viên ');
                }
            });
        }

    });

    function earch_tr() {
        $(".row_f").each(function() {
            var price_f = $(this).find('.price_f').html();
            var amount_f = $(this).find('.amount_select').val();
            price_f = price_f.replace(',', '');
            // console.log(price_f + amount_f);
            // console.log(Number(price_f) * Number(amount_f));
            var result = Number(price_f) * Number(amount_f)
            $(this).find('.pay').html(money_format(result));
        });
    }

    function money_format(money) {
        return money.toLocaleString(window.document.documentElement.lang);
    }

    function conver_string_number(string) {
        for (i = 0; i < 3; i++) {
            string = string.replace(',', '');
        }
        // string =string.replace(',', '');
        //    console.log(" đây "+string);
        return string;
    }

    function sum_price() {
        var total_price = 0;
        $('.pay').each(function() {
            var pay_f = $(this).html();
            pay_f = conver_string_number(pay_f);
            // console.log(pay_f);
            total_price += Number(pay_f);

        });
        // console.log(total_price);
        return money_format(total_price);
    }

    function total_amount() {
        var total_amount = 0
        $('.amount_select').each(function() {
            var amount_f = $(this).val();
            total_amount += Number(amount_f)
        })
        return total_amount;
    }

    $(document).on('change', '.amount_select', function() {
        var amount_f = $(this).val();
        var price_f = $(this).parent().parent().find('.price_f').html();
        var id_temp = $(this).parent().parent().find('.id_temp').val();
        var result = Number(conver_string_number(price_f)) * Number(amount_f);
        // console.log(amount_f, price_f, result)
        $(this).parent().parent().find('.pay').html(money_format(result));
        $('#total_price').val(sum_price());
        $("#total_amount").val(total_amount());

        // -------------------update table temp---------------------
        $.ajax({
            url: "{{route('temp_update','')  }}/" + id_temp + "?amount=" + amount_f
            , type: "POST"
            , data: {
                '_token': token
            }
            , success: function(data) {
                console.log(data);
            }
            , error: function(e) {
                console.log(e.responseJSON.message);
            }
        })
    });

    $(document).on('change', '.note_f', function() {
        var note_f = $(this).val();
        var id_temp = $(this).parent().parent().find('.id_temp').val();
        // -------------------update table temp---------------------
        $.ajax({
            url: "{{route('temp_update_note_f','') }}/" + id_temp + "?note_f=" + note_f
            , type: "POST"
            , data: {
                '_token': token
            }
            , success: function(data) {
                console.log(data, "update note succes");
            }
            , error: function(e) {
                console.log(e.responseJSON.message);
            }
        })
    });

    function change_note(note_f, id_temp) {
        $.ajax({
            url: "{{route('temp_update_note_f','') }}/" + id_temp + "?note_f=" + note_f
            , type: "POST"
            , data: {
                '_token': token
            }
            , success: function(data) {
                console.log(data, "update note succes");
            }
            , error: function(e) {
                console.log(e.responseJSON.message);
            }
        })

    }

    $(document).on('click', '.btn_remove_f', function() {
        var id_temp = $(this).parent().parent().find('.id_temp').val();
        $.ajax({
            url: "{{ route('destroy_temp','') }}/" + id_temp
            , type: "DELETE"
            , data: {
                "_token": token
            , }
            , success: function(data) {
                // console.log(data);

            }
            , error: function() {
                alert('Có lỗi!!! Vui lòng liên hệ với quản trị viên')
            }
        });
        $(this).parent().parent().fadeOut(500
            , function() {
                $(this).remove();
                check_table();
            });



    });


    function check_table() {
        var tbody = '';
        tbody = $('#table_food_selected').find('tbody').html();
        var tr = '<tr style="font-size:20px; text-align:center"><td colspan="6">Chưa có gì trong gỏi hàng</td></tr>';
        if (tbody == '') {
            $('#table_food_selected').find('tbody').html(tr);
            // console.log('check_table');
        } else {
            console.log('check_Table_fail' + tbody);
        }
    }

</script>
<script>
    var id_food = '';
    $(document).on('click', '.note_food', function() {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            var content_note = $(this).val();
            id_food = $(this).parent().parent().find('td').html();
            $('#note_food').val(content_note);
            $('#note_modal').modal('show');
            console.log(id_food);
        }
    });
    $('.note_complete').click(function() {
        console.log(id_food);
        var content_note = $('#note_food').val();
        $('.' + id_food).parent().find('.note_food').val(content_note);
    });
    var id_food_modal
    $(document).on('click', '.note_f', function() {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            var content_note = $(this).val();
            id_food_modal = $(this).parent().parent().find('td').html();
            $('#note_food_cart').val(content_note);
            $('#note_modal_cart').modal('show');
            console.log(id_food_modal);
        }
    });
    $('.note_complete_cart').click(function() {
        console.log(id_food_modal + '_modal');
        var content_note = $('#note_food_cart').val();
        $('.' + id_food_modal + '_modal').parent().find('.note_f').val(content_note);
        change_note(content_note, id_food_modal);
    });
$(document).on('click','.choose_table',function(){
    console.log('working');
    $('#select_table').hide();
    $('.search').show();
    $('.select_food').show();
})

</script>



@endsection