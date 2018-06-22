@extends('admin.public.admin')

@section('main')
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="#">商品管理</a></li>
		<li class="active">商品列表</li>
		<span style="display:inline-block;text-indent:5px;color: green">(共有{{$tot}}条数据)</span>
		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<button class="btn btn-danger" onclick="del(0)"><span class="glyphicon glyphicon-trash"></span> 批量删除</button>
			<a href="/admin/goods/create" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> 添加商品</a>

			<form action="" class="form-inline pull-right">
				<div class="form-group">
					<input type="text" name="" class="form-control" placeholder="请输入你要搜索的内容" id="">
				</div>
				
				<input type="submit" value="搜索" class="btn btn-success">
			</form>


		</div>
		<table class="table-bordered table table-hover">
			<th>勾选</th>
			<th>ID</th>
			<th>标题</th>
			<th>封面</th>
			<th>价格</th>
			<th>数量</th>
			<th>操作</th>

			@foreach($data as $value)
				<tr>
					<td><input type="checkbox"  id="{{$value->id}}"></td>
					<td>{{$value->id}}</td>
					<td>{{$value->title}}</td>
					<td>
						<img width="100px" height="100px" src="{{$value->img}}" alt="">
					</td>
					<td>{{$value->price}}</td>
					<td>{{$value->num}}</td>
					<td><a href="/admin/goods/{{$value->id}}/edit" class="glyphicon glyphicon-pencil"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="del({{$value->id}})" class="glyphicon glyphicon-trash"></a></td>
			@endforeach

			

		</table>
		<!-- 分页效果 -->
		<div class="panel-footer">
			<nav style="text-align:center;">
				{{$data->links()}}

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
                url:"/admin/goods/delete",
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