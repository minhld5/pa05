@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<div class="row">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4>
                    <a href="{{@Config::get('app.url')}}/user/pa05/category/list" class="bs-tooltip" title="Quay lại danh mục dùng chung"  style="text-decoration: none;">
                        <i class="icon-chevron-left"></i>
                    </a>

                    {{@@$category->name}}
                    <span style="padding-left: 10px;"></span>
                    <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/create/{{@@$category->id}}" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
                        <i class="icon-plus-sign""></i>
                    </a>

                </h4>
                <div class="toolbar no-padding">
                    <div class="btn-group">
                        <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                    </div>
                </div>
            </div>
            <div class="widget-content no-padding">
                <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable" data-display-length="10">
                    <thead>
                        <tr>
                            <th width="50">STT</th>
                            <th>Tên danh mục</th>
                            <th width="250">Hãng/Model/Xuất xứ</th>
                            <th width="120">Đơn vị tính</th>
                            <th width="200">Tham chiếu 2517</th>
                            <th width="250">Ghi chú</th>
                            <th width="100">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!is_null($category))
                            @foreach ($category_details as $category_detail)
                            <tr>
                                <td align="center">{{@@$category_detail->no}}</td>
                                <td>{{@@$category_detail->name}}</td>
                                <td>
                                    -Hãng: {{@@$category_detail->brand}}<br>
                                    -Model: {{@@$category_detail->model}}<br>
                                    -Xuất xứ: {{@@$category_detail->origin}}
                                </td>
                                <td>{{@@$category_detail->unit}}</td>
                                <td align="left">{{@@$category_detail->refer_2517}}</td>
                                <td>{{@@$category_detail->note}}</td>
                                <td align="center">
                                    <ul class="table-controls">
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/view/{{@@$category_detail->id}}" class="bs-tooltip" title="Xem" style="text-decoration: none;"><i class="icon-eye-open"></i></a> 
                                        </li> 
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/price_list/{{@@$category_detail->id}}" class="bs-tooltip" title="Thiết lập giá" style="text-decoration: none;"><i class="icon-usd"></i></a> 
                                        </li>                   
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/edit/{{@@$category_detail->id}}" class="bs-tooltip" title="Sửa" style="text-decoration: none;"><i class="icon-pencil"></i></a> 
                                        </li>
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/delete/{{@@$category_detail->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa dòng category {{@@$category_detail->name}} và không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
                                        </li>

                                    </ul>
                                </td>
                            </tr>
                            @endforeach      
                        @endif                   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /Responsive DataTable -->

<a href="{{@Config::get('app.url')}}/user/pa05/category/generate/{{@@$category->id}}" style="text-decoration: none;">
    <b><i>Nhấn vào đây </i></b>
</a>
để tạo dữ liệu từ danh mục khác


@endsection