@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div class="widget-header"><h4>Thông tin danh mục</h4></div>
            
            <div class="widget-content">
                <div class="widget-content">
                    <div class="row">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên danh mục:</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" value="{{@@$category_detail->name}}" readonly>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">Hãng:</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" value="{{@@$category_detail->brand}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Model:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" value="{{@@$category_detail->model}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Xuất xứ:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" value="{{@@$category_detail->origin}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Thông số kỹ thuật:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="7" disabled>{{@@$category_detail->spec}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Đơn vị tính:</label>
                            <div class="col-md-1">
                                <input type="text" class="form-control" value="{{@@$category_detail->unit}}" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tham chiếu 2517: </label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" value="{{@@$category_detail->refer_2517}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Ghi chú:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="7" disabled>{{@@$category_detail->note}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Sản phẩm đã chọn:</label>
                            <div class="col-md-6">
                                <input id="total" class="form-control" name="origin" value="{{@@$category_detail->product_name}}" readonly>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="widget-content no-padding">
                <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable" data-display-length="10">
                    <thead>
                        <tr>
                            <th>Thời gian bảo hành</th>
                            <th width="250">Giá tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prices as $price)
                        <tr>
                            <td>{{@@$price->warranty_year}}</td>
                            <td align="right">{{number_format($price->price)}}</td>
                        </tr>  
                        @endforeach                   
                    </tbody>
                </table>
            </div>

        </div>
        <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
            <div class="form-actions" align = "center">
                <p class="btn-toolbar btn-toolbar-demo">
                    <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/list/{{@@$category_detail->category_id}}">
                        <button class="btn btn-primary" type="button" style="width:100px;">OK</button>
                    </a>
                </p>
            </div>
        </div>
    </div>

<!-- /Responsive DataTable -->
@endsection