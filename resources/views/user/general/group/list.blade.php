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
                    Danh sách nhóm sản phẩm
                    <span style="padding-left: 10px;"></span>
                    <a href="{{@Config::get('app.url')}}/user/general/group/create" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
                        <i class="icon-plus-sign"></i>
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
                            <th width="30"></th>
                            <th width="100">Trật tự</th>
                            <th width="200">Tên nhóm</th>
                            <th>Mô tả</th>
                            <th width="300">Hiển thị</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupes as $group)
                        <tr>
                            <td></td>
                            <td>{{@@$group->order}}</td>
                            <td><a href="{{@Config::get('app.url')}}/user/general/sub_group/list/{{$group->id}}" style="text-decoration: none;">{{@@$group->name}}</a></td>
                            <td>{{@@$group->description}}</td>
                            <td>{{@@$group->display_label}}</td>
                            <td align="center">
                                <ul class="table-controls">                    
                                    <li>
                                        <a href="{{@Config::get('app.url')}}/user/general/group/edit/{{$group->id}}" class="bs-tooltip" title="Sửa"><i class="icon-pencil"></i></a> 
                                    </li>
                                    <li>
                                        <a href="{{@Config::get('app.url')}}/user/general/group/delete/{{$group->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa dòng category {{$group->name}} và không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
                                    </li>

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