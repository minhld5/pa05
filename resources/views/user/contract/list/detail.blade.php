@extends('user.layout')
@section('content')

<div style="height: 20px;"></div>
<b>Chi tiết hợp đồng</b>
<div style="height: 20px;"></div>
	
	<form action="{{@Config::get('app.url')}}/user/contract/list/detail/{{$contract_list->id}}" method="post">	
		{{csrf_field()}}			
		<!--=== Page Content ===-->
		<!--=== Inline Tabs ===-->
		<div class="row">
			<div class="col-md-12">
				<!-- Tabs-->
				<div class="tabbable tabbable-custom tabbable-full-width">
					<ul class="nav nav-tabs">
						<li <?php if($tab=='overview'){echo 'class="active"';} ?>><a href="#tab_overview" data-toggle="tab">Tổng quan</a></li>
						<li <?php if($tab=='progress'){echo 'class="active"';} ?>><a href="#tab_progress" data-toggle="tab">Tiến độ</a></li>
						<li <?php if($tab=='goods'){echo 'class="active"';} ?>><a href="#tab_goods" data-toggle="tab">Hàng hóa</a></li>
					</ul>
					<div class="tab-content row">
						<!--=== Overview ===-->
						<!-- /Overview -->
						<div class="tab-pane <?php if($tab=='overview'){echo 'active';} ?>" id="tab_overview">
							
								<div class="col-md-12">
									<div class="widget">
										<div class="widget-header">
											<h4>Thông tin chung về hợp đồng</h4>
										</div>
										<!--Nếu là pm thì cho phép thêm phase và điều chỉnh %
										Còn không chỉ liệt kê danh sách các phase đã khai theo thời gian-->
										<div class="widget-content">
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">Đơn vị:</label>
													<div class="col-md-3">
														<select class="form-control" name="region" required>
															@foreach($regions as $region)
																<option value="{{$region->id}}" <?php if($region->id==$contract_list->sys_region_id){echo('selected');}?> >{{$region->name}}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">Số hợp đồng:</label>
													<div class="col-md-3">
														<input type="text" name="no" class="form-control" value="{{$contract_list->no}}">
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">Năm:</label>
													<div class="col-md-2">
														<input type="number" name="year" class="form-control" value="{{$contract_list->year}}" placeholder="Ví dụ: {{date('Y')}}" required>
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">PM:</label>
													<div class="col-md-4">
														<select class="form-control" name="pm" <?php if($contract_role!='pm'){echo ('disabled');} ?>>
															@if (!is_null($pms))
																@foreach($pms as $pm)
																	<option value="{{$pm->userid}}" <?php if($pm->userid==$contract_list->pm_id){echo('selected');}?> >{{$pm->fullname}}</option>
																@endforeach
															@endif
														</select>
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label"  align="right">Giá trị hợp đồng:</label>
													<div class="col-md-4">
														<input type="text" name="total_value" class="form-control just-number price-format-input" value="{{number_format($contract_list->total_value)}}">
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">Nhân sự bàn giao:</label>
													<div class="col-md-6">
														<textarea name="employee" cols="90" rows="4">{{$contract_list->employee}}</textarea>
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label"  align="right">Ghi chú:</label>
													<div class="col-md-6">
														<textarea name="note" cols="100" rows="6">{{$contract_list->note}}</textarea>
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">Ngày hết hạn:</label>
													<div class="col-md-2">
														<input type="text" name="due_date" class="form-control datepicker" value="<?php if(date("d/m/Y", $contract_list->due_date)!='01/01/1970'){echo(date("d/m/Y", $contract_list->due_date));}?>">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="form-actions" align = "center">
													
													<p class="btn-toolbar btn-toolbar-demo">
														<a href="{{@Config::get('app.url')}}/user/contract/list/detail/{{$contract_list->id}}/overview">
															<button class="btn btn-primary" type="button" style="width:100px;">Reset</button>
														</a>
														<a href="{{@Config::get('app.url')}}/user/contract/list/list">
															<button class="btn btn-primary" type="button" style="width:100px;">Thoát</button>
														</a>
														@if( ($contract_list->is_lock==0) && ($contract_role=='pm'|| $contract_role=='edit'))
															<button class="btn btn-primary" name="btnOverviewOK" style="width:100px;" type="submit">Lưu thay đổi</button>
														@else
															<button class="btn btn-primary" name="btnOverviewOK" style="width:100px;" type="submit" disabled>Lưu thay đổi</button>
														@endif
													</p>
												</div>
											</div>
										</div> <!-- /.widget-content -->
									</div> <!-- /.widget -->
								</div> <!-- /.col-md-12 -->

						</div>

						<div class="tab-pane <?php if($tab=='progress'){echo 'active';} ?>" id="tab_progress">
							<div class="col-md-12">
									<div class="widget">
										<div class="widget-header">
											<h4>
												Theo dõi tiến độ các công việc của hợp đồng
											</h4>
										</div>
										<div class="widget-content">

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">Tổng thể:</label>
													<div class="col-md-5">
														<input type="text" name="overall_status" class="form-control" value="{{$contract_list->overall_status}}">
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">Lịch bàn giao:</label>
													<div class="col-md-5">
														<input type="text" name="delivery_schedule" class="form-control" value="{{$contract_list->delivery_schedule}}">
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">Danh mục bàn giao:</label>
													<div class="col-md-5">
														<input type="text" name="handover_list" class="form-control" value="{{$contract_list->handover_list}}">
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">Triển khai, lắp đặt:</label>
													<div class="col-md-5">
														<input type="text" name="implementation" class="form-control" value="{{$contract_list->implementation}}">
													</div>
												</div>
											</div>

											<div style="height: 10px;"></div>
											<div class="row">
												<div class="form-group">
													<label class="col-md-2 control-label" align="right">Đào tạo:</label>
													<div class="col-md-5">
														<input type="text" name="training" class="form-control" value="{{$contract_list->training}}">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="form-actions" align = "center">
													
													<p class="btn-toolbar btn-toolbar-demo">
														<a href="{{@Config::get('app.url')}}/user/contract/list/detail/{{$contract_list->id}}/progress">
															<button class="btn btn-primary" type="button" style="width:100px;">Reset</button>
														</a>
														<a href="{{@Config::get('app.url')}}/user/contract/list/list">
															<button class="btn btn-primary" type="button" style="width:100px;">Thoát</button>
														</a>
														@if( ($contract_list->is_lock==0) && ($contract_role=='pm'|| $contract_role=='edit'))
															<button class="btn btn-primary" name="btnProgressOK" style="width:100px;" type="submit">Lưu thay đổi</button>
														@else
															<button class="btn btn-primary" name="btnProgressOK" style="width:100px;" type="submit" disabled>Lưu thay đổi</button>
														@endif
													</p>
												</div>
											</div>

										</div>
									</div> <!-- /.widget -->
							</div> <!-- /.col-md-12 -->
						</div>

						<div class="tab-pane <?php if($tab=='goods'){echo 'active';} ?>" id="tab_goods">
							<div class="col-md-12">
									<div class="widget">
										<div class="widget-header">
											<h4>
												<table>
													<tr>
														<td>
														@if( ($contract_list->is_lock==0) && ($contract_list->pm_id==$sessionuser->userid))
															<a href="{{@Config::get('app.url')}}/user/contract/list/reset_year/{{@@$contract_list->id}}" class="bs-tooltip" onclick="return confirm('Thao tác này không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;">
																Nhấn vào đây để chọn lại danh mục
															</a>
														@endif
														</td>
														<td style="width: 20px;"></td>
														<td>
															<label class="checkbox">
																<input type="checkbox" class="uniform" name="display" onchange="this.form.submit()" <?php if($display=='on'){echo 'checked';}?> > Hện thông số kỹ thuật của sản phẩm
															</label>
														</td>
													</tr>
												</table>
											</h4>
										</div>

										<div class="widget-content">
											<table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable" data-display-length="50">
													<thead>
														<tr>
															<th style="display: none;">Order</th>
															<th width="60" style="text-align: center;">STT</th>
															<th>Danh mục</th>
															<th width="60" style="text-align: center;">SL</th>
															<th width="250">Tình trạng</th>
															<th width="250">Ghi chú</th>
															<th width="120">Hết hạn</th>
															<th width="120" style="text-align: center;">Thao tác</th>
														</tr>
													</thead>
													<tbody>
														@if (!is_null($contract_goodses))
															@foreach($contract_goodses as $contract_goods)
																@if ($contract_goods->type=='heading')
																	<tr>
																		<th style="display: none;">{{$contract_goods->order_no}}</th>
																		<td align="center"><b>{{$contract_goods->no}}</b></td>
																		<td><b>{{$contract_goods->name}}</b></td>
			                            								<td></td>
																		<td></td>
			                            								<td></td>
			                            								<td></td>
			                            								<td></td>
			                            							</tr>
																@else
																	<tr>
																		<th style="display: none;">{{$contract_goods->order_no}}</th>
																		<td align="center">{{$contract_goods->no}}</td>
																		<td>
																			{{$contract_goods->name}}
																			@if ($display=='on')
																				<br>
																				<?php 
																					$array = preg_split("/\r\n|\n|\r/", $contract_goods->spec);

																					foreach($array as $item){
																						echo($item . '<br>');
																					}
																				?>
																			@endif
																		</td>
			                            								<td align="center">{{$contract_goods->quantity}}</td>
																		<td>{{$contract_goods->status}}</td>
			                            								<td>{{$contract_goods->note}}</td>
			                            								<td>
			                            									@if(!is_null($contract_goods->expiration_date))
			                            										{{date('d-m-Y',$contract_goods->expiration_date)}}
			                            									@endif
			                            								</td>
			                            								<td align="center">
			                            									<ul class="table-controls"> 
											                                    @if(($contract_list->is_lock==0) &&($contract_role=='pm'||$contract_role=='edit'))                
											                                        <li>
											                                            <a href="{{@Config::get('app.url')}}/user/contract/list/note/{{@@$contract_goods->id}}" class="bs-tooltip" style="text-decoration: none;"><i class="icon-pencil"></i></a> 
											                                        </li>
											                                    @endif

											                                </ul>
			                            								</td>
			                            							</tr>
		                            							@endif
	                            							@endforeach
                            							@endif
													</tbody>
											</table>
										</div> <!-- /.widget-content -->
									</div> <!-- /.widget -->
							</div> <!-- /.col-md-12 -->
						</div>

						<!-- /Edit Account -->
					</div> <!-- /.tab-content -->
				</div>
				<!--END TABS-->
			</div>
		</div> <!-- /.row -->
		<!-- /Page Content -->
	</form>

@endsection