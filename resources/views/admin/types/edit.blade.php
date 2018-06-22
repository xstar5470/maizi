@extends('admin.public.admin')

@section('main')
	<!-- 内容 -->
	<div class="col-md-10">

		<ol class="breadcrumb">
			<li><a href="/admin"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
			<li><a href="/admin/type">分类管理</a></li>
			<li class="active">分类修改</li>

			<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
		</ol>

		<!-- 面版 -->
		<div class="panel panel-default">
			<div class="panel-heading">

			</div>
			<div class="panel-body">
				<form  id="formAdd" onsubmit="return false">
					<div class="form-group">
						<label for="">分类名</label>
						{{csrf_field()}}
						<input type="text" name="name" class="form-control"  placeholder="请输入分类名" value="{{$type->name}}">
						<input type="hidden" name="path" value="{{$type->path}}"  >
						<input type="hidden" name="id" value="{{$type->id}}"  >
					</div>
					<div class="form-group">
						<label>上层分类</label>
						<select name="pid" class="form-control" id="">
							<option value="0" data-path="0," >请选择上级分类</option>

							@foreach($topLevel as $value)
								@if($value->repeat!=2)
									<option @if($value->id==$type->pid) selected @endif value="{{$value->id}}" data-path="{{$value->path.$value->id.','}}">{{str_repeat('|--',$value->repeat).$value->name}}</option>
								@endif
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="">标题</label>
						<input type="text" name="title" placeholder="请输入分类标题" class="form-control" value="{{$type->title}}">
					</div>
					<div class="form-group">
						<label for="">关键词</label>
						<input type="text" name="keywords" class="form-control"  placeholder="请输入关键词" value="{{$type->keywords}}">
					</div>
					<div class="form-group">
						<label for="">分类介绍</label>
						<input type="text" name="description" class="form-control" placeholder="请输入关键词介绍" value="{{$type->description}}">
					</div>
					<div class="form-group">
						<label for="">排序</label>
						<input type="text" name="sort" class="form-control" placeholder="请输入排序" value="{{$type->sort}}">
					</div>

					<div class="form-group">
						<label for="">是否楼层</label>
						<br>
						<input type="radio" name="is_lou" value="0" @if($type->is_lou==0) checked @endif >否
						<input type="radio" name="is_lou" value="1"  @if($type->is_lou==1) checked @endif >是
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
            $('input[name=path]').val($('option:selected').data('path'));

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