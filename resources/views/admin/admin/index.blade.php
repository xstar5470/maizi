@extends('admin.public.admin')

@section('main')
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="#">管理员管理</a></li>
		<li class="active">管理员列表</li>
		<span style="display:inline-block;text-indent:5px;color: green">(共有{{$tot}}条数据)</span>
		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->

	<div class="panel panel-default">
		<div class="panel-heading">
			<button class="btn btn-danger" onclick="deletes(0)"><span class="glyphicon glyphicon-trash"></span> 批量删除</button>
			<a href="javascript:void(0);" data-toggle="modal" data-target="#add" class="btn btn-success create"><span class="glyphicon glyphicon-plus"></span> 添加管理员</a>


			<form action="" class="form-inline pull-right">
				<div class="form-group">
					<input type="text" name="" class="form-control" placeholder="请输入你要搜索的内容" id="">
				</div>
				
				<input type="submit" value="搜索" class="btn btn-success">
			</form>


		</div>
		<table class="table-bordered table table-hover">
			<th width="100">勾选</th>
			<th>ID</th>
			<th>NAME</th>
			<th>加入时间</th>
			<th>状态</th>
			<th>操作</th>
            @if(count($admins)>0)
			@foreach($admins as $value)
				<tr>
					<td><input type="checkbox" name="" id="{{$value->id}}"></td>
					<td>{{$value->id}}</td>
					<td>{{$value->name}}</td>
					<td>{{date('Y-m-d H:i:s',$value->dateline)}}</td>

					@if($value->status)
						<td><span class="btn btn-danger" onclick="status(this,{{$value->id}},1)">禁用</span></td>
					@else

						<td><span class="btn btn-success" onclick="status(this,{{$value->id}},0)">正常</span></td>
					@endif

					<td><a href="javascript:;" onclick="edit({{$value->id}})" data-toggle="modal" data-target="#edit" class="glyphicon glyphicon-pencil"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="deletes({{$value->id}})" class="glyphicon glyphicon-trash"></a></td>
				</tr>
			@endforeach
			@else
				<tr>
					<td colspan="6" style="text-align: center">
						无数据
					</td>
				</tr>
			@endif

		</table>
		<!-- 分页效果 -->
		<div class="panel-footer">
			{{ $admins->links() }}

		</div>
	</div>
</div>
<!-- 添加页面模态框 -->
<div class="modal fade" id="add">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">添加管理员</h4>
			</div>
			<div class="modal-body">
				<form action="" onsubmit="return false;" id="formAdd">
					{{csrf_field()}}
					<div class="form-group">
						<label for="">用户名</label>
						<input type="text" name="name"  class="form-control" placeholder="管理员名称" >
						<div class="name_info">

						</div>
					</div>
					<div class="form-group">
						<label for="">密码</label>
						<input type="password" name="pass" class="form-control" placeholder="请输入新密码" >
						<div class="pass_info">

						</div>
					</div>
					<div class="form-group">
						<label for="">确认密码</label>
						<input type="password" name="repass"  class="form-control" placeholder="请再次输入密码" >
						<div class="repass_info">

						</div>
					</div>
					<div class="form-group">
						<label for="">状态</label>
						<br>
						<input type="radio" name="status" checked value="0" >正常
						<input type="radio" name="status" value="1" >禁用
					</div>
					<div class="form-group pull-right">
						<input type="submit" value="提交" onclick="add()" class="btn btn-success">
						<input type="reset" id="reset" value="重置" class="btn btn-danger">
					</div>

					<div style="clear:both"></div>
				</form>
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- 修改页面模态框 -->
<div class="modal fade" id="edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">修改管理员</h4>
			</div>
			<div class="modal-body" id="body">
				
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	function save(){
		// 表单序列化
		str=$("#formEdit").serialize();
		$.post("/admin/admin/1",{str:str,"_method":'put','_token':'{{csrf_token()}}'},function(data){
			if (data==1) {
				window.location.reload();
			}else if(data){
				// 密码提示信息
				if (data.pass) {
					str="<div class='alert alert-danger'>"+data.pass+"</div>";
				}else{
					str="<div class='alert alert-success'>√</div>";
				}
				$("#passInfo1").html(str);
			}else{
				alert('添加失败');
			}
		});
	}

	function edit(id){
		$.get("/admin/admin/"+id+"/edit",{},function(data){
			if (data) {
				$("#body").html(data);
			};
		});
	}

	function status(obj,id,status){
		if (status) {
			$.post('/admin/admin/ajaxStatu',{id:id,"_token":"{{csrf_token()}}","status":"0"},function(data){

				if (data==1) {
					$(obj).parent().html('<td><span class="btn btn-success" onclick="status(this,'+id+',0)">正常</span></td>')
				}else{
					alert('修改失败');
				}
			})
		}else{
			$.post('/admin/admin/ajaxStatu',{id:id,"_token":"{{csrf_token()}}","status":"1"},function(data){

				if (data==1) {
					$(obj).parent().html('<td><span class="btn btn-danger" onclick="status(this,'+id+',1)">禁用</span></td>')
				}else{

					alert('修改失败');
				}

			})
		}
	}

	function deletes(id){

        swal({
            title: '确定删除？',
            text: '删除后将找不回数据',
            type: 'info',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () {
            var ids = [];
            if(id !=0 ){
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
                url:"/admin/admin/delete",
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
	// 添加的处理操作
	function add(){
		// 提交到下一个页面
        $.ajax({
            'url':'/admin/admin/store',
            data: new FormData($('#formAdd')[0]),
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.code == 0 ) {
					swalreload("添加成功");
                }else if(data.code == 1){
                    // 用户名提示信息
                    var str='';
                    if (data.data.name) {
                        str="<div class='alert alert-danger'>"+data.data.name[0]+"</div>";
                    }else{
                        str="<div class='alert alert-success'>√</div>";
                    }
                    $(".name_info").html(str);
                    // 密码提示信息
                    if (data.data.pass) {
                        str="<div class='alert alert-danger'>"+data.data.pass[0]+"</div>";
                    }else{
                        str="<div class='alert alert-success'>√</div>";
                    }
                    $(".pass_info").html(str);
                    // 确认密码提示信息
                    if (data.data.repass) {
                        str="<div class='alert alert-danger'>"+data.data.repass[0]+"</div>";
                    }else{
                        str="<div class='alert alert-success'>√</div>";
                    }
                    $(".repass_info").html(str);
                }else{
                    alert('添加失败');
                }
            }
        })

	}
	
	function clean() {
        $('.name_info div,.pass_info div,.repass_info div').remove();
        $('#reset').click();
    }
</script>
<script>

	$('.create').click(function(){
		clean();
	})
</script>
@endsection