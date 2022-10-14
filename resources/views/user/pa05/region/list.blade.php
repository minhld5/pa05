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
                    <i class="icon-reorder"></i> 
                    Danh mục các đơn vị
                    @if ($pa05role=='pm' || $pa05role=='edit')
                        <span style="padding-left: 10px;"></span>
                        <a href="{{@Config::get('app.url')}}/user/pa05/region/create" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
                            <i class="icon-plus-sign" onclick="addnew()"></i>
                        </a>
                    @endif
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
                            <th width="30"></th>
                            <th>Tỉnh, thành phố</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pa05regions as $pa05region)
                        <tr>
                            <td></td>
                            <td><a href="{{@Config::get('app.url')}}/user/pa05/year/list/{{$pa05region->id}}" style="text-decoration: none;">{{@@$pa05region->name}}</a></td>
                            <td align="center">
                                <ul class="table-controls"> 
                                    @if ($pa05role=='pm' || $pa05role=='edit')                   
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/region/edit/{{$pa05region->id}}" class="bs-tooltip" title="Sửa" style="text-decoration: none;"><i class="icon-pencil" onclick='edit("{{$pa05region->id}}")'></i></a> 
                                        </li>
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/region/delete/{{$pa05region->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa dữ liệu và không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
                                        </li>
                                    @endif
                                </ul>
                            </td>
                        </tr>
                        @endforeach                         
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /Responsive DataTable -->

@endsection