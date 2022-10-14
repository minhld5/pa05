@extends('admin.layout')
@section('content')
<br>
	<form class="form-horizontal" action="{{@Config::get('app.url')}}/admin/change_password" method="post">
		{{csrf_field()}}

			<div class="widget">
				<div class="widget-header"><h4>Đổi mật khẩu</h4></div>
				@if ($err_msg !='')
					<div class="alert fade in alert-danger" style="display: yes;">
						<i class="icon-remove close" data-dismiss="alert"></i>
						{{$err_msg}}
					</div>
				@endif
				<div class="widget-content">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-5 control-label">Mật khẩu hiện tại:</label>
								<div class="col-md-2">
									<input type="password" name="oldpassword" class="form-control" value="" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-5 control-label">Mật khẩu mới:</label>
								<div class="col-md-2">
									<input type="password" name="newpassword" class="form-control" value="" required>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-md-5 control-label">Nhập lại mật khẩu:</label>
								<div class="col-md-2">
									<input type="password" name="confirmpassword" class="form-control" value="" required>
								</div>
							</div>						
						</div>								
					</div> <!-- /.row -->


					<div class="form-actions" align = "center">
						<p class="btn-toolbar btn-toolbar-demo">
							<button class="btn btn-primary" style="width:100px;" type="submit">Đổi</button>
							<a href="{{@Config::get('app.url')}}/admin/home">
								<button class="btn btn-primary" type="button" style="width:100px;">Không đổi</button>
							</a>
						</p>
					</div>
				</div> <!-- /.widget-content -->
			</div> <!-- /.widget -->						

		<div class="row">
			
		</div>
	</form>

@endsection