@extends('admin.public.admin')

@section('main')
<link rel="stylesheet" href="{{asset('diyUpload/css/upload.css')}}">
<script src="{{asset('diyUpload/js/upload.js')}}"></script>
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
					<label for="">价格</label>
					<input type="text" name="price" class="form-control"  placeholder="请输入商品价格">
				</div>
				<div class="form-group">
					<label for="">库存</label>
					<input type="text" name="num" class="form-control" placeholder="请输入商品库存">
				</div>
				<div class="form-group">
					<label for="">商品大图</label>
					<input type="text" name="sort" class="form-control" placeholder="请输入排序">
				</div>

				<div class="form-group">
					<label for="">是否楼层</label>
					<br>
					<input type="radio" name="is_lou" value="0" checked id="">否
					<input type="radio" name="is_lou" value="1"  id="">是
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
	//保存数据
	$('#submit').click(function(){
		$.ajax({
			url:'/admin/type/store',
			type:"POST",
			data:new FormData($('#formAdd')[0]),
			contentType:false,
			processData:false,
			success:function(data){
			    if(data.code == 0){

			        swalreload(data.message,'/admin/type');
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