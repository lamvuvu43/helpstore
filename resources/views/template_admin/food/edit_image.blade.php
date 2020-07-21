@extends('template_admin.index')
@section('pageTitle', 'Chỉnh sửa hình ảnh món ăn')
@section('edit_image')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12 ">
        <div class="container">
            <h2 class="mt-4 pr-2">Chỉnh sửa hình ảnh món ăn</h2>
            @if (session('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ session('success') }}
            </div>
            @endif
            <div class="row" id="row_image">
                @if(count($get_image)>0)
                @foreach($get_image as $item)
                <div class="col-12 col-md-4 col-lg-4 mt-3">
                    <div class="edit_image_div">
                        <img src="{{ $item->link_image }}" class="edit_image_img">
                        <div class="edit_image_div_sup">
                            <button class="btn btn-outline-success edit_image_a" data-id="{{ $item->id }}">Sửa hình này</button>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="edit_image_div">
                    <button class="btn btn-outline-success" id="btn_add_image">Thêm ảnh</button>
                </div>
                @endif

            </div>
            <form action="{{ route('update_image_process') }}" method="post" enctype="multipart/form-data" class="form-group">
                @csrf
                <div class="select_image mt-3" style="display:none">
                    <input value="" name="id_image" style="display:none" class="id_image">
                    <label for="file_image">Chọn hình</label>
                    <input type="file" class="form-control" name="file_image" id="file_image" accept="image/*">
                    <div class="text-right mt-2">
                        <button type="submit" class="btn btn-success" id="update_image">Cập nhật</button>
                    </div>
                </div>
            </form>
            <form action="{{ route('add_image_process',$id_f) }}" method="post" enctype="multipart/form-data" class="form-group">
                @csrf
                <div class="select_image mt-3" style="display:none">
                    <label for="add_file_image">Chọn hình</label>
                    <input type="file" class="form-control" name="add_file_image" id="add_file_image" accept="image/*">
                    <div class="text-right mt-2">
                        <button type="submit" class="btn btn-success" id="add_image">Cập nhật</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>
{{-- <script src="https://code.jquery.com/jquery-3.5.0.js"></script> --}}
<script>
    $(".edit_image_div").mouseover(function() {
        $(this).find(".edit_image_div_sup").slideDown(500);
        // alert("mouseover");
    });
    $(".edit_image_div").mouseleave(function() {
        $(this).find(".edit_image_div_sup").slideUp(500);
        // alert("mouseover");
    });
    $(".edit_image_a").click(function() {

        var id_image = $(this).data('id');
        // $(".select_image").slideDown(500);
        $(".id_image").val(id_image);
        $("#file_image").click();


        var $container = $("html,body");
        var $scrollTo = $('.select_image');

        $container.animate({
            scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop()
            , scrollLeft: 0
        }, 300);


        setTimeout($("#file_image").change(function() {
            $("#update_image").click();
        }), 300)
    });
    $('#btn_add_image').click(function() {
        $('#add_file_image').click();
        setTimeout($("#add_file_image").change(function() {
            $("#add_image").click();
        }), 300)
    })

</script>
@endsection
