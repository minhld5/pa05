@extends('admin.layout')
@section('content')

<div style="height: 10px;"></div>
<div class="tab-pane" id="tab_edit_account">
	<form class="form-horizontal" action="{{@Config::get('app.url')}}/user/contract/list/create" method="post">
		{{csrf_field()}}
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-header"><h4>Thông tin chung</h4></div>
				<div class="widget-content">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-3 control-label">Đơn vị:</label>
								<div class="col-md-3">
									<select class="form-control" name="region" required>
										@foreach($regions as $region)
											<option value="{{$region->id}}">{{$region->name}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Số hợp đồng:</label>
								<div class="col-md-3">
									<input type="text" name="no" class="form-control" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Năm:</label>
								<div class="col-md-2">
									<input type="number" name="year" class="form-control" value="{{date('Y')}}" placeholder="Ví dụ: {{date('Y')}}" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">PM:</label>
								<div class="col-md-4">
									<select class="form-control" name="pm" required>
										@if (!is_null($pms))
											@foreach($pms as $pm)
												<option value="{{$pm->userid}}">{{$pm->fullname}}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Giá trị hợp đồng:</label>
								<div class="col-md-4">
									<input type="text" name="total_value" class="form-control just-number price-format-input" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Nhân sự bàn giao:</label>
								<div class="col-md-6">
									<textarea name="employee" cols="90" rows="4"></textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Ghi chú:</label>
								<div class="col-md-6">
									<textarea name="note" cols="100" rows="6"></textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Ngày hết hạn:</label>
								<div class="col-md-2">
									<input type="text" name="due_date" class="form-control datepicker">
								</div>
							</div>

						</div>
														
					</div> <!-- /.row -->
				</div> <!-- /.widget-content -->
			</div> <!-- /.widget -->
		</div> <!-- /.col-md-12 -->

		<div class="col-md-12">
			<div class="widget">
				<div class="widget-header"><h4>Tiến độ</h4></div>
				<div class="widget-content">
					<div class="row">
						<div class="col-md-12">

							<div class="form-group">
								<label class="col-md-3 control-label">Tình trạng:</label>
								<div class="col-md-4">
									<input type="text" name="overall_status" class="form-control" value="" placeholder="Ví dụ: Đã ký hợp đồng">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Lịch bàn giao:</label>
								<div class="col-md-4">
									<input type="text" name="delivery_schedule" class="form-control" value="" placeholder="Ví dụ: Đã bàn giao xong">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Danh mục bàn giao:</label>
								<div class="col-md-4">
									<input type="text" name="handover_list" class="form-control" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Lắp đặt:</label>
								<div class="col-md-4">
									<input type="text" name="implementation" class="form-control" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Đào tạo:</label>
								<div class="col-md-4">
									<input type="text" name="training" class="form-control" value="">
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
					<a href="{{@Config::get('app.url')}}/user/contract/list/list">
						<button class="btn btn-primary" type="button" style="width:100px;">Hủy</button>
					</a>
					<button class="btn btn-primary" name="btnOK" style="width:100px;" type="submit">Đồng ý</button>
				</p>
			</div>
		</div>
	</form>
</div>

<script>
    $(document).on("keypress", ".just-number", function (e) {
        let charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
         }
    });
    $(document).on('keyup', '.price-format-input', function (e) {
        let val = this.value;
        val = val.replace(/,/g, "");
        if (val.length > 3) {
            let noCommas = Math.ceil(val.length / 3) - 1;
            let remain = val.length - (noCommas * 3);
            let newVal = [];
            for (let i = 0; i < noCommas; i++) {
                newVal.unshift(val.substr(val.length - (i * 3) - 3, 3));
            }   
            newVal.unshift(val.substr(0, remain));
            this.value = newVal;
        }
        else {
            this.value = val;
        }
    });


</script>

@endsection