@extends('admin.layout')
@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>测试问题推荐答案 - {{$row->question->title}} - 编辑</h2>
                    </div>
                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body pt0 pb0">
                                {{ Form::open(array('route' => ['questions.items.update', $row->question->id,$row->id], 'class'=>'form-horizontal group-border stripped', 'method'=>'PUT', 'id'=>'form')) }}
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">问题</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="hidden" name="question_id" class="form-control" value="{{$row->question->id}}">
                                            <input type="text" class="form-control"  disabled="disabled" value="{{$row->question->title}}">
                                            <label class="help-block" for="title"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">推荐产品</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="hidden" name="item_id" class="form-control" value="{{$row->item->id}}">
                                            <input type="text" class="form-control"  disabled="disabled" value="{{$row->item->name}}">
                                            <label class="help-block" for="item_id"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">答案</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="answer" class="form-control" value="{{$row->answer}}">
                                            <label class="help-block" for="answer"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label"></label>
                                        <div class="col-lg-10 col-md-9">
                                            <button class="btn btn-default ml15" type="submit">提 交</button>
                                            <a class="btn btn-default ml15" href="{{route("questions.items.index",[$row->question->id])}}">返回</a>
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
            location.href='{{route("questions.items.index",[$row->question->id])}}';
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
