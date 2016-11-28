@extends('admin.layout')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>产品管理 - 添加</h2>
                    </div>
                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body pt0 pb0">
                                {{ Form::open(array('route' => ['item.store'], 'class'=>'form-horizontal group-border stripped', 'id'=>'form')) }}
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">标题</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="name" class="form-control" value="">
                                            <label class="help-block" for="name"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">分类</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select name="type_id" class="form-control">
                                                <option value="">请选择所属分类</option>
                                                @foreach ($types as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                            <label class="help-block" for="type_id"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">价格</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="price" class="form-control" value="">
                                            <label class="help-block" for="price"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">颜色</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="color" class="form-control" value="">
                                            <label class="help-block" for="color"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">规格</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="specification" class="form-control" value="">
                                            <label class="help-block" for="specification"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">缩略图</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="thumb-preview" id="thumb-preview">
                                            </div>
                                            <input type="file" name="image" class="filestyle" data-buttonText="Find file" data-buttonName="btn-danger" data-iconName="fa fa-plus" id="thumb-file">
                                            <label class="help-block" for="image"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">内容</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="content" class="form-control article-ckeditor"></textarea>
                                            <label class="help-block" for="content"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label"></label>
                                        <div class="col-lg-10 col-md-9">
                                            <button class="btn btn-default ml15" type="submit">提 交</button>
                                            <a class="btn btn-default ml15" href="{{url('admin/page/index')}}">返回</a>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    {{ Form::close() }}
                            </div>
                        </div>
                        <!-- End .panel -->
                    </div>
                    <!-- col-lg-12 end here -->
                </div>
                <!-- End .row -->
            </div>
            <!-- End .page-content-inner -->
        </div>
        <!-- / page-content-wrapper -->
    </div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {

    $('#form').ajaxForm({
        dataType: 'json',
        success: function() {
            $('#form .form-group .help-block').empty();
            $('#form .form-group').removeClass('has-error');
            location.href='{{route("item.index")}}';
        },
        error: function(xhr){
            var json = jQuery.parseJSON(xhr.responseText);
            var keys = Object.keys(json);
            //console.log(keys);
            $('#form .form-group .help-block').empty();
            $('#form .form-group').removeClass('has-error');
            $('#form .form-group').each(function(){
                var name = $(this).find('input,textarea,select').attr('name');
                if( jQuery.inArray(name, keys) != -1){
                    $(this).addClass('has-error');
                    $(this).find('.help-block').html(json[name]);
                }
            })
        }
    });
    $('#thumb-file').change(function(){
        $("#thumb-preview").html('');
        var reader = new FileReader();
        reader.onload = function (event) {
            $("#thumb-preview").append('<img src="'+event.target.result+'" />');
        }
        reader.readAsDataURL(this.files[0]);
    })
    $('#image-file').change(function(){
        $("#image-preview").html('');
        var reader = new FileReader();
        reader.onload = function (event) {
            $("#image-preview").append('<img src="'+event.target.result+'" />');
        }
        reader.readAsDataURL(this.files[0]);
    })

});
</script>
<script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script>
    $('.article-ckeditor').ckeditor({
        filebrowserBrowseUrl: '{!! url('filemanager/index.html') !!}'
    });
</script>
@endsection
