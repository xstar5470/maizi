@extends('admin.public.admin')

@section('main')
	<link rel="stylesheet" href="{{asset('diyUpload/css/upload.css')}}">
    <script src="{{asset('diyUpload/js/upload.js')}}"></script>
<div class="col-md-10 box-upload">
	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="#">轮播图管理</a></li>
		<li class="active">轮播图列表</li>
		<span style="display:inline-block;text-indent:5px;color: green">(共有{{$tot}}条数据)</span>
		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->

	<div class="panel panel-default">
		<div class="panel-heading">
			<button class="btn btn-danger" onclick="deletes(0)"><span class="glyphicon glyphicon-trash"></span> 批量删除</button>
			<a href="javascript:void(0);"  class="btn btn-success creation"><span class="glyphicon glyphicon-plus"></span> 添加轮播图</a>


			<form action="" class="form-inline pull-right">
				<div class="form-group">
					<input type="text" name="" class="form-control" placeholder="请输入你要搜索的内容">
				</div>

				<input type="submit" value="搜索" class="btn btn-success">
			</form>


		</div>
		<table class="table-bordered table table-hover">
			<th width="100">勾选</th>
			<th>ID</th>
			<th>标题</th>
			<th>链接</th>
			<th>排序</th>
			<th>图片</th>
			<th>操作</th>
            @if(count($data)>0)
			@foreach($data as $value)
				<tr>
					<td><input type="checkbox" name="" id="{{$value->id}}"></td>
					<td>{{$value->id}}</td>
					<td>{{$value->title}}</td>
					<td>{{$value->link}}</td>
					<td>{{$value->sort}}</td>
					<td>{{$value->img}}</td>

					<td ><a href="javascript:;"  data-admin="{{$value}}"  class="glyphicon glyphicon-pencil editaction"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="deletes({{$value->id}})" class="glyphicon glyphicon-trash"></a></td>
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
			{{--{{ $data->links() }}--}}

		</div>
	</div>
</div>
<!-- 页面模态框 -->
<div class="modal fade" id="add">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<form  onsubmit="return false;" id="formAdd">
					{{csrf_field()}}
					<input type="hidden" name="id" id="id">
					<div class="form-group">
						<label for="">标题</label>
						<input type="text" name="title" id="title" class="form-control" placeholder="轮播图标题" >
					</div>
					<div class="form-group">
						<label for="">链接</label>
						<input type="text" name="link" id="link" class="form-control" placeholder="请输入轮播图链接" >
					</div>
					<div class="form-group">
						<label for="">排序</label>
						<input type="text" name="sort" id="sort" class="form-control" placeholder="数值越大越靠前" >
					</div>
					<div class="form-group ">
						<label for="">图片选择</label>

                        <div class="image-box" >
                            <section class="upload-section" >
                                <div class="upload-btn"></div>
                                <input type="file" name="file" id="upload-input" value="" accept="image/jpg,image/jpeg,image/png,image/bmp" multiple="multiple" />
                            </section>
                        </div>

					</div>
					<div class="form-group pull-right">
						<input type="submit" value="提交"  onclick="save()" class="btn btn-success">
						<input type="reset" id="reset" value="重置" class="btn btn-danger">
					</div>

					<div style="clear:both"></div>
				</form>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <script>

        $("#upload-input").ajaxImageUpload({
            url: '/file_upload', //上传的服务器地址
            data: { dir:'lunbo',_token:"{{csrf_token()}}" },
            maxNum: 2, //允许上传图片数量
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

    $('.creation').click(function(){
        clean();
        $('.modal-title').html("添加轮播图");
        $('#add').modal('show');
    });

	$('.editaction').click(function(){
        clean();
	    admin_obj = $(this).data('admin');
	    $('.modal-title').html("修改轮播图");
        $('#id').val(admin_obj.id);
        $('#name').val(admin_obj.name);
        $('#pass').val(admin_obj.pass);
        $('#repass').val(admin_obj.pass);
        if(admin_obj.status == 1){
            $('input[name="status"]:eq(1)').prop("checked",true);
		}
        $('#add').modal('show');
	});


    $("body").delegate(".status",'click',function(){
	    var id = $(this).data('id');
	    var status = $(this).data('status');
        if(status == '1'){
            status = 0;
        }else{
            status = 1;
        }
        var th = this;

        $.ajax({
            url:'/admin/admin/status',
            type:"POST",
            data:{'id':id,'status':status},
            headers:{
                'X-CSRF-TOKEN':'{{csrf_token()}}'
            },
            dataType:'json',
            success:function(data){
                if(data.code == 0){
                    if(status){
                        str = '<span class="btn btn-danger status" data-id="'+id+'" data-status="1">禁用</span>';
                    }else{
                        str = '<span class="btn btn-success status" data-id="'+id+'" data-status="0" >正常</span>';
                    }
                    $(th).parent().parent().find('.editaction').data('admin').status = status;
                    $(th).parent().html(str);
                }
            },
            error:function(){
                swal('修改失败','','error');
            }
        })
    })

	function deletes(id){
        swal({
            title: '确定删除？',
            text: '删除后将找不回数据',
            type: 'info',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: false
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
                        swalreload('删除成功','');
                    }
                },
                error:function(){
                    swal('请求超时，稍后再试', '', 'error');
                }
            })
        });

	}
	// 添加及修改的处理操作
	function save(){
        $.ajax({
            'url':'/admin/admin/store',
            data: new FormData($('#formAdd')[0]),
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(data) {

                if (data.code == 0 ) {
					swalreload(data.message,'');
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
                }
            },
			error:function(){
                swal('请求超时，稍后再试', '', 'error');

			}
        })

	}

	function clean() {
	    $('#id').val('');
        $('#reset').click();
    }
</script>
<script>

	$('.create').click(function(){
		clean();
	})
</script>
@endsection