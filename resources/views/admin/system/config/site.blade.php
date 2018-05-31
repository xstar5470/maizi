@extends('admin.public.admin')

@section('main')
<link rel="stylesheet" href="{{asset('diyUpload/css/upload.css')}}">
<script src="{{asset('diyUpload/js/upload.js')}}"></script>
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="/admin"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li class="active">系统管理</li>
		<li class="active">网站配置</li>

		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">


		</div>
		<div class="panel-body">
			<form  id="formAdd" onsubmit="return false">
				{{csrf_field()}}
				<div class="form-group">
					<label for="">网站名</label>
					<input type="text" name="WEBSITE_TITLE" class="form-control"  placeholder="请输入网站名" value="{{config('website.web_title')}}">
				</div>

				<div class="form-group">
					<label for="">关键词</label>
					<input type="text" name="WEBSITE_KEYWORDS" placeholder="请输入关键词" class="form-control" value="{{config('website.web_keywords')}}">
				</div>
				<div class="form-group">
					<label for="">介绍</label>
					<textarea class="form-control" name="WEBSITE_DESCRIPTION"   placeholder="请输入网站介绍" rows="10">{{config('website.web_description')}}</textarea>
				</div>
				<div class="form-group">
					<label for="">百度统计代码</label>
					<textarea class="form-control" name="WEBSITE_STATISTICS"   placeholder="请输入百度统计代码" rows="10">{{config('website.web_statistics')}}</textarea>
				</div>
				<div class="form-group ">
					<label for="">网站LOGO</label>

					<div class="image-box" >
						@if(config('website.web_logo'))
							<section class="image-section">
								<div class="image-shade"></div>
								<div class="image-delete"></div>
								<img class="image-show" src="{{config('website.web_logo')}}" />
								<input class="file" name="file[]" value="{{config('website.web_logo')}}" type="hidden" />
							</section>
						@endif
						<section class="upload-section" @if(config('website.web_logo')) style="display: none" @endif>
							<div class="upload-btn"></div>
							<input type="file" name="file" id="upload-input" value="" accept="image/jpg,image/jpeg,image/png,image/bmp" multiple="multiple" />
						</section>
					</div>

				</div>

				<div class="form-group pull-right">
					<input type="submit" value="提交" id="submit" class="btn btn-success">
					<input type="reset" value="重置" class="btn btn-danger">
				</div>
			</form>
		</div>
		
	</div>
</div>
<script>
    var maxNum = 1;
    $("#upload-input").ajaxImageUpload({
        url: '/file_upload', //上传的服务器地址
        data: { _token:"{{csrf_token()}}" },
        maxNum: maxNum, //允许上传图片数量
        zoom: true, //允许上传图片点击放大
        allowType: ["gif", "jpeg", "jpg", "bmp",'png'], //允许上传图片的类型
        maxSize :2, //允许上传图片的最大尺寸，单位M
        before: function () {
        },
        success:function(data){
        },
        error:function (e) {
            swal('上传失败','','error');
        }
    });
</script>
<script>
	//保存数据
	$('#submit').click(function(){
		$.ajax({
			url:'/admin/system/config/store',
			type:"POST",
			data:new FormData($('#formAdd')[0]),
			contentType:false,
			processData:false,
			success:function(data){
			    if(data.code == 0){
			        swalreload(data.message,'/admin/system/config');
				}else{
                    swal(data.message,'','error');
				}
			},
			error:function(){
			    swal("链接超时",'','error');
			}

		})
	})

</script>
@endsection