@extends('admin.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>
<form action="{{@Config::get('app.url')}}/user/general/filter_detail/select_product/{{$id}}" method="post">
        
    {{csrf_field()}}

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div style="height: 10px;"></div>
            <div class="widget-header"><h4>Thông tin điều kiện</h4></div>
            
            <div class="widget-content">
                <div class="row">

                    <div class="form-group">
                        <label class="col-md-2 control-label">Nhóm sản phẩm:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" value="{{$filter->general_sub_group_name}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Tên bộ lọc:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="name" value="{{$filter->name}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Điều kiện:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="displaylabel" value="{{$filter_detail->name}}" readonly>
                        </div>
                    </div>

                </div>
            </div>

            <div style="height: 10px;"></div>
            <div class="widget-header"><h4>Lựa chọn sản phẩm cho điều kiện lọc</h4></div>

            <div class="widget-content">

            	<div class="row">
					<div class="col-md-12">
						<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i> Danh sách sản phẩm</h4>
							</div>
							<div class="widget-content clearfix">
								<!-- Selected -->
								<div class="left-box">
									<input type="text" id="box1Filter" class="form-control box-filter" placeholder="Filter entries..."><button type="button" id="box1Clear" class="filter">x</button>
									<select id="box1View" multiple="multiple" class="multiple" name="selected_product[]">
										@foreach ($selected_products as $selected_product)
											<option value="{{@@$selected_product->id}}">{{@@$selected_product->name}}</option>
										@endforeach
									</select>
									<span id="box1Counter" class="count-label"></span>
									<select id="box1Storage"></select>
								</div>
								<!--left-box -->

								<!-- Control buttons -->
								<div class="dual-control">
									<button id="to2" type="button" class="btn">&nbsp;&gt;&nbsp;</button>
									<button id="allTo2" type="button" class="btn">&nbsp;&gt;&gt;&nbsp;</button><br>
									<button id="to1" type="button" class="btn">&nbsp;&lt;&nbsp;</button>
									<button id="allTo1" type="button" class="btn">&nbsp;&lt;&lt;&nbsp;</button>
								</div>
								<!--control buttons -->

								<!-- Avaiable -->
								<div class="right-box">
									<input type="text" id="box2Filter" class="form-control box-filter" placeholder="Filter entries..."><button type="button" id="box2Clear" class="filter">x</button>
									<select id="box2View" multiple="multiple" class="multiple" name="available_product[]">
										@foreach ($available_products as $available_product)
											<option value="{{@@$available_product->id}}">{{@@$available_product->name}}</option>
										@endforeach
									</select>
									<span id="box2Counter" class="count-label"></span>
									<select id="box2Storage"></select>
								</div>
								<!--right box -->
							</div>
						</div>
					</div>
				</div>

            </div>

            <div class="widget" style="width:99%; align-content: center;">
	            <div class="form-actions" align = "center">
	                <p class="btn-toolbar btn-toolbar-demo">
	                    <a href="{{@Config::get('app.url')}}/user/general/filter/edit/{{$filter->id}}">
	                        <button class="btn btn-primary" type="button" style="width:100px;">Hủy</button>
	                    </a>
	                    <button class="btn btn-primary" style="width:100px;" name="btnSubmit"  type="submit" onclick="checkalldata()">Tiếp tục</button>
	                </p>
	            </div>
	        </div>
        </div>
    </div>
</form>


<script>
    function checkalldata(){

    	var x = document.getElementById("box1View");
	    //var txt = "All options: ";
	    var i;
	    for (i = 0; i < x.length; i++) {
	        //txt = txt + "\n" + x.options[i].value;
	        x[i].selected = true;
	    }
	    
    }
</script>

@endsection