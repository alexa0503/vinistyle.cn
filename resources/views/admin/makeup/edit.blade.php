@extends('admin.layout')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>妆容管理 - {{$row->title}} - 编辑</h2>
                    </div>
                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body pt0 pb0">
                                {{ Form::open(array('route' => ['makeup.update',$row->id], 'class'=>'form-horizontal group-border stripped', 'method'=>'PUT', 'id'=>'form')) }}
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">标题</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="title" class="form-control" value="{{$row->title}}">
                                            <label class="help-block" for="title"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">副标题</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="sub_title" class="form-control">{{$row->sub_title}}</textarea>
                                            <label class="help-block" for="sub_title"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">适用场景</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="application" class="form-control" value="{{$row->application}}">
                                            <label class="help-block" for="application"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">缩略图</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="thumb-preview" id="thumb-preview">
                                                <a href="{{asset($row->pre_img_path)}}" target="_blank"><img src="{{asset($row->pre_img_path)}}" /></a>
                                            </div>
                                            <input type="file" name="image" class="filestyle" data-buttonText="Find file" data-buttonName="btn-danger" data-iconName="fa fa-plus" id="thumb-file">
                                            <label class="help-block" for="image"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">描述</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="desc" class="form-control article-ckeditor">{{$row->desc}}</textarea>
                                            <label class="help-block" for="desc"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">图片</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="thumb-preview" id="image-preview">
                                                @foreach ($row->images as $image)
                                                <a href="{{asset($image->path)}}" target="_blank"><img src="{{asset($image->path)}}" /></a>
                                                @endforeach
                                            </div>
                                            <input type="file" name="thumb[]" class="filestyle thumb" data-buttonText="Find file" data-buttonName="btn-danger" data-iconName="fa fa-plus" multiple="" id="image-file">
                                            <label class="help-block" for="thumb[]"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">达人推荐</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select name="feature_ids[]" class="form-control" multiple="multiple">
                                                @foreach ($features as $feature)
                                                <option value="{{$feature->id}}"@if (in_array($feature->id, $feature_ids))' selected="selected"'@endif>{{$feature->name}}</option>
                                                @endforeach
                                            </select>
                                            <label class="help-block" for="feature_ids"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label"></label>
                                        <div class="col-lg-10 col-md-9">
                                            <button class="btn btn-default ml15" type="submit">提 交</button>
                                            <a class="btn btn-default ml15" href="{{url('admin/makeup/index')}}">返回</a>
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
            location.href='{{route("makeup.index")}}';
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
