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
                            <label class="col-md-2 control-label">Thông số kỹ thuật:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="7" disabled>{{@@$category_detail->spec}}</textarea>
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

            <div style="height: 10px;"></div>
            <div class="widget-header">
                <h4>Giá danh mục</h4> 
                <span style="width: 40px;">&nbsp;</span> 
                <a style="text-decoration: none;" href="{{@Config::get('app.url')}}/user/pa05/category_detail/price_create/{{@@$category_detail->id}}" class="bs-tooltip" title="Thêm"><i class="icon-plus"></i></a>
                <span style="width: 40px;">&nbsp;</span> 
                <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/price_reset/{{@@$category_detail->id}}" class="bs-tooltip" title="Reset từ sản phẩm" onclick="return confirm('Thao tác này sẽ xóa dữ liệu và không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-refresh"></i></a>
            </div> 

            <div class="widget-content no-padding">
                <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable" data-display-length="10">
                    <thead>
                        <tr>
                            <th>Thời gian bảo hành</th>
                            <th width="250">Giá tiền</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prices as $price)
                        <tr>
                            <td>{{@@$price->warranty_year}}</td>
                            <td align="right">{{number_format($price->price)}}</td>
                            <td align="center">
                                <ul class="table-controls"> 
                                    <li>
                                        </i></a> 
                                    </li>                   
                                    <li>
                                        <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/price_edit/{{@@$price->id}}" class="bs-tooltip" title="Sửa"><i class="icon-pencil"></i></a> 
                                    </li>
                                    <li>
                                        <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/price_delete/{{@@$price->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa dữ liệu và không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
                                    </li>

                                </ul>
                            </td>
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