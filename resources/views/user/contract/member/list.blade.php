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
                    Danh sách thành viên liên quan đến hợp đồng
                    <span style="padding-left: 10px;"></span>
                    <a href="{{@Config::get('app.url')}}/user/contract/member/create" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
                        <i class="icon-plus-sign" onclick="addnew()"></i>
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
                            <th>Họ tên</th>
                            <th width="350">Phòng ban</th>
                            <th width="350">Đơn vị</th>
                            <th width="200">Vai trò</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                        <tr>
                            <td></td>
                            <td>{{@@$member->fullname}}</td>
                            <td>{{@@$member->department}}</td>
                            <td>{{@@$member->unit}}</td>
                            <td>{{@@$member->role}}</td>
                            <td align="center">
                                <ul class="table-controls">                    
                                    <li>
                                        <a href="{{@Config::get('app.url')}}/user/contract/member/edit/{{@@$member->id}}" class="bs-tooltip" title="Sửa" style="text-decoration: none;"><i class="icon-pencil"></i></a> 
                                    </li>
                                    <li>
                                        <a href="{{@Config::get('app.url')}}/user/contract/member/remove/{{@@$member->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
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