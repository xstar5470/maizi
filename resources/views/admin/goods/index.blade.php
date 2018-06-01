@extends('admin.public.admin')

@section('main')
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="#">分类管理</a></li>
		<li class="active">分类列表</li>
		<span style="display:inline-block;text-indent:5px;color: green">(共有{{$tot}}条数据)</span>
		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<button class="btn btn-danger" onclick="del(0)"><span class="glyphicon glyphicon-trash"></span> 批量删除</button>
			<a href="/admin/type/create" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> 添加分类</a>
			<form action="" class="form-inline pull-right">
				<div class="form-group">
					<input type="text" name="" class="form-control" placeholder="请输入你要搜索的内容" id="">
				</div>
				
				<input type="submit" value="搜索" class="btn btn-success">
			</form>


		</div>
		<table class="table-bordered table table-hover">
			<th>选项</th>
			<th>ID</th>
			<th>分类名</th>
			<th>标题</th>
			<th>关键词</th>
			<th>介绍</th>
			<th>添加子类</th>
			<th>楼层</th>
			<th>操作</th>

			@foreach($types as $value)
			<tr>
				<td><input type="checkbox" name="" id="{{$value->id}}"></td>
				<td>{{$value->id}}</td>
				<td>{{str_repeat("|===",$value->repeat)}}{{$value->name}}</td>
				<td>{{$value->title == '' ? '暂无':$value->title }}</td>
				<td>{{$value->keywords == '' ? '暂无':$value->keywords }}</td>
				<td>{{$value->description == '' ? '暂无':$value->description }}</td>

				@if($value->repeat == 2)
				<td >添加子类</td>
				@else
				<td><a href="/admin/type/create?pid={{$value->id}}&path={{$value->path}}{{$value->id}},">添加子类</a></td>
				@endif
				@if($value->is_lou)
					<td><span class="btn btn-success">是</span></td>
				@else
					<td><span class="btn btn-danger">否</span></td>
				@endif
				<td><a href="" class="glyphicon glyphicon-pencil"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="del({{$value->id}})" class="glyphicon glyphicon-trash"></a></td>
			</tr>
			@endforeach
			

		</table>
		<!-- 分页效果 -->
		<div class="panel-footer">
			<nav style="text-align:center;">
			{{--{{$types->links()}}--}}
			</nav>

		</div>
	</div>
</div>
<script>
	function del(id){
        swal({
            title: '确定删除？',
            text: '删除后将找不回数据',
            type: 'info',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: false
        }, function () {
            var ids = [];
            if(id != 0 ){
                ids.push(id);
            }else{

                $('input[type="checkbox"]:checked').each(function(){
                    ids.push($(this).attr('id'));
                })
                if(ids.length <= 0){
                    swal('您还没勾选', '', 'warning');
                    return false;
                }
            }

            $.ajax({
                url:"/admin/type/delete",
                type:"POST",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data:{
                    'ids':ids,
                },
                success:function(data){
                    if(data.code == 0){
                        swalreload('删除成功');
                    }
                },
                error:function(){
                    swal('请求超时，稍后再试', '', 'error');
                }
            })
        });

    }
</script>
@endsection