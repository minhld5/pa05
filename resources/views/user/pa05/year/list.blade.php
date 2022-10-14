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
                    <a href="{{@Config::get('app.url')}}/user/pa05/region/list" class="bs-tooltip" title="Toàn bộ các tỉnh"  style="text-decoration: none;">
                        <i class="icon-chevron-left"></i>
                    </a>
                    Danh mục hàng năm của {{$pa05region->name}}
                    @if ($pa05role=='pm' || $pa05role=='edit')
                        <span style="padding-left: 10px;"></span>
                        <a href="{{@Config::get('app.url')}}/user/pa05/year/create/{{$pa05region->id}}" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
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
                            <th width="200">Năm</th>
                            <th>Trạng thái</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pa05years as $pa05year)
                        <tr>
                            <td></td>
                            
                            <td>
                                <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/list/{{$pa05year->id}}" style="text-decoration: none;">{{@@$pa05year->year}}</a>
                            </td>
                            <td>
                                @if ($pa05year->enable==1)
                                    Có thể sửa
                                @else
                                    Đã khóa
                                @endif
                            </td>
                            <td align="center">
                                <ul class="table-controls">

                                    @if (($pa05year->enable==0) && ($pa05role=='pm'))         
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/year/unlock/{{$pa05year->id}}" class="bs-tooltip" title="Mở khóa" style="text-decoration: none;"><i class="icon-unlock"></i></a> 
                                        </li>
                                    @endif

                                    @if (($pa05year->enable==1) && ($pa05role=='pm'))         
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/year/lock/{{$pa05year->id}}" class="bs-tooltip" title="Khóa" style="text-decoration: none;"><i class="icon-lock" ></i></a> 
                                        </li>
                                    @endif


                                    @if (($pa05year->enable==1) && ($pa05role=='pm'||$pa05role=='edit'))         
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/year/edit/{{$pa05year->id}}" class="bs-tooltip" title="Sửa" style="text-decoration: none;"><i class="icon-pencil"></i></a> 
                                        </li>
                                   
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/year/delete/{{$pa05year->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa dữ liệu và không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
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