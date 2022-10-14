@extends('admin.layout')
@section('content')

<div style="height: 10px;"></div>
<div class="tab-pane" id="tab_edit_account">
	<form class="form-horizontal" action="{{@Config::get('app.url')}}/admin/account/create" method="post">
		{{csrf_field()}}
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-header"><h4>Thông tin đăng nhập</h4></div>
				<div class="widget-content">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Username:</label>
								<div class="col-md-8">
									<input type="text" name="username" class="form-control" value="" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Mật khẩu:</label>
								<div class="col-md-8">
									<input type="password" name="password" class="form-control" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Loại:</label>
								<div class="col-md-8">
									<select class="form-control" name="isldap">
										<option value="0" selected="selected">Local</option>
										<option value="1">Ldap</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Role:</label>
								<div class="col-md-8">
									<select class="form-control" name="role">
										@foreach($roles as $role)
											<option value="{{$role->id}}">{{$role->description}}</option>
										@endforeach
									</select>
								</div>
							</div>	

							<div class="form-group">
								<label class="col-md-4 control-label">Đơn vị:</label>
								<div class="col-md-8">
									<select class="form-control" name="unit" onchange="this.form.submit()">
										<option value="">Chọn</option>
										@foreach($units as $unit)
											<option value="{{$unit->id}}"  <?php if($selectedunit==$unit->id){echo 'selected';}?>>{{$unit->name}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Bộ phận:</label>
								<div class="col-md-8">
									<select class="form-control" name="department">
										@if (!is_null($departments))
											<option value="">Chọn</option>
											@foreach($departments as $department)
												<option value="{{$department->id}}" >{{$department->name}}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>							

						</div>
														
					</div> <!-- /.row -->
				</div> <!-- /.widget-content -->
			</div> <!-- /.widget -->
		</div> <!-- /.col-md-12 -->

		<div class="col-md-12">
			<div class="widget">
				<div class="widget-header"><h4>Thông tin cá nhân</h4></div>
				<div class="widget-content">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Email:</label>
								<div class="col-md-8"><input type="text" name="email" class="form-control" value=""></div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Tên đầy đủ:</label>
								<div class="col-md-8"><input type="text" name="fullname" class="form-control" value=""></div>
							</div>

							
							
						</div>
														
					</div> <!-- /.row -->
				</div> <!-- /.widget-content -->
			</div> <!-- /.widget -->
		</div> <!-- /.col-md-12 -->										

		<div class="row">
			<div class="form-actions" align = "center">
				
				<p class="btn-toolbar btn-toolbar-demo">
					<a href="{{@Config::get('app.url')}}/admin/account/list">
						<button class="btn btn-primary" type="button" style="width:100px;">Hủy</button>
					</a>
					<button class="btn btn-primary" name="btnOK" style="width:100px;" type="submit">Đồng ý</button>
				</p>
			</div>
		</div>
	</form>
</div>

@endsection