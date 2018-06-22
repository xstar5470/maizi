@extends('admin.public.admin')

@section('main')
<link rel="stylesheet" href="{{asset('diyUpload/css/upload.css')}}">
<script src="{{asset('diyUpload/js/upload.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset("ueditor/ueditor.config.js")}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset("ueditor/ueditor.all.min.js")}}"> </script>
<script type="text/javascript" charset="utf-8" src="{{asset("ueditor/lang/zh-cn/zh-cn.js")}}"></script>
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="/admin"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="/admin/good">商品管理</a></li>
		<li class="active">商品添加</li>

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
					<label for="">商品名</label>
					<input type="text" name="title" class="form-control"  placeholder="请输入商品名">
				</div>
				<div class="form-group">
					<label>所属分类</label>
					<select name="cid" class="form-control" id="">
						<option value="">请选择商品分类</option>

						@foreach($data as $value)
								<option value="{{$value->id}}">{{str_repeat('|--',$value->repeat).$value->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="">价格</label>
					<input type="text" name="price" class="form-control"  placeholder="请输入商品价格">
				</div>
				<div class="form-group">
					<label for="">库存</label>
					<input type="text" name="num" class="form-control" placeholder="请输入商品库存">
				</div>
				<div class="form-group" style="height: 170px">
					<label for="">商品封面图</label>
					<div class="image-box " >

						<section class="upload-section" >
							<div class="upload-btn"></div>
							<input type="file" name="file" id="upload-single" value="" accept="image/jpg,image/jpeg,image/png,image/bmp" multiple="multiple" />
						</section>
						<section class="image-box image-single" style="margin-left:15px;display: none">
							<div class="image-shade-single"></div>
							<img class="image-show-single" src="" />
							<input id="img" name="img" value="" type="hidden" />
						</section>
					</div>
				</div>
				<div class="form-group" style="height: 170px">
					<label for="">商品组图</label>
					<div class="image-box" >
						<section class="upload-section" >
							<div class="upload-btn"></div>
							<input type="file" name="file" id="upload-input" value="" accept="image/jpg,image/jpeg,image/png,image/bmp" multiple="multiple" />
						</section>

					</div>
				</div>

				<div class="form-group">
					<label for="">配置</label>
					<script id="config" type="text/plain" name="config" ></script>
				</div>
				<div class="form-group">
					<label for="">商品详情</label>

                    <script id="text" type="text/plain" name="text" ></script>
				</div>

				<div class="form-group">
					<input type="submit" value="提交" id="submit" class="btn btn-success">
					<input type="reset" value="重置" class="btn btn-danger">
				</div>

			</form>
		</div>
		
	</div>
</div>
<script>
    var ue_config = UE.getEditor('config');
    var ue_text = UE.getEditor('text');
    var maxNum = 4;
    $("#upload-input").ajaxImageUpload({
        url: '/file_upload', //上传的服务器地址
        data: { _token:"{{csrf_token()}}" },
        maxNum: maxNum, //允许上传图片数量
        zoom: true, //允许上传图片点击放大
        allowType: ["gif", "jpeg", "jpg", "bmp",'png'], //允许上传图片的类型
        maxSize :1, //允许上传图片的最大尺寸，单位M
        before: function () {
        },
        success:function(data){
        },
        error:function (e) {
            swal('上传失败','','error');
        }
    });

    $("#upload-single").change(function(){
        var formData = new FormData();
        formData.append('file', $('#upload-single')[0].files[0]);
        $.ajax({
            url: '/file_upload',
            type: 'POST',
            data: formData,
			dataType:'json',
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            processData: false,
            contentType: false
        }).done(function(res) {
			$('.image-single').css('display','block');
            $('.image-single .image-show-single').attr("src",res.src);
            $('.image-single #img').val(res.src);
        }).fail(function(res) {
		});
	})

</script>

<script>
	//保存数据
	$('#submit').click(function(){
		$.ajax({
			url:'/admin/goods/store',
			type:"POST",
			data:new FormData($('#formAdd')[0]),
			contentType:false,
			processData:false,
			success:function(data){
			    if(data.code == 0){
			        swalreload(data.message,'/admin/goods');
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