@extends('admin.layout')
@section('content')

<div style="height: 10px;"></div>
<div class="tab-pane" id="tab_edit_account">
	<form class="form-horizontal" action="{{@Config::get('app.url')}}/user/contract/list/note/{{$contract_goods->id}}" method="post">
		{{csrf_field()}}
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-header"><h4>Theo dõi tiến độ hàng hóa</h4></div>
				<div class="widget-content">
					<div class="row">
						<div class="col-md-12">

							<div class="form-group">
								<label class="col-md-3 control-label">Danh mục:</label>
								<div class="col-md-6">
									<input type="text" class="form-control" value="{{$contract_goods->name}}" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Tiến độ:</label>
								<div class="col-md-6">
									<textarea name="status" cols="90" rows="4">{{$contract_goods->status}}</textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Ghi chú:</label>
								<div class="col-md-6">
									<textarea name="note" cols="100" rows="6">{{$contract_goods->note}}</textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Hết hạn:</label>
								<div class="col-md-2">
									<input type="text" name="expiration_date" class="form-control datepicker" value="<?php if(!is_null($contract_goods->expiration_date)){echo(date("d/m/Y", $contract_goods->expiration_date));}?>">
								</div>
							</div>

						</div>
														
					</div> <!-- /.row -->
				</div> <!-- /.widget-content -->
			</div> <!-- /.widget -->
		</div> <!-- /.col-md-12 -->
									

		<div class="row">
			<div class="form-actions" align = "center">
				
				<p class="btn-toolbar btn-toolbar-demo">
					<a href="{{@Config::get('app.url')}}/user/contract/list/detail/{{$contract_list->id}}/goods">
						<button class="btn btn-primary" type="button" style="width:100px;">Hủy</button>
					</a>
					<button class="btn btn-primary" name="btnOK" style="width:100px;" type="submit">Đồng ý</button>
				</p>
			</div>
		</div>
	</form>
</div>


@endsection