@extends('admin.layout')
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
                    Danh sách người dùng
                    <span style="padding-left: 10px;"></span>
                    <a href="{{@Config::get('app.url')}}/admin/account/create" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
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
                            <th style="width: 30px;"></th>
                            <th>Username</th>
                            <th>Tên đầy đủ</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Bộ phận</th>
                            <th>Đơn vị</th>
                            <th style="text-align:center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                        <tr>
                            <td></td>
                            <td>{{$account->username}}</td>
                            <td>{{$account->fullname}}</td>
                            <td>{{$account->email}}</td>
                            <td>{{$account->roledescription}}</td>
                            <td>{{$account->departmentdescription}}</td>
                            <td>{{$account->unitdescription}}</td>
                            </td>
                            <td align="center">
                                <ul class="table-controls">
                                    <li>
                                        @if ($account->isenable==0)
                                            <a href="{{@Config::get('app.url')}}/admin/account/enable/{{$account->userid}}" class="bs-tooltip" title="Enable" onclick="return confirm('Thao tác này không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-unlock"></i></a>
                                        @else
                                            <a href="{{@Config::get('app.url')}}/admin/account/disable/{{$account->userid}}" class="bs-tooltip" title="Disable" onclick="return confirm('Thao tác này không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-lock"></i></a>
                                        @endif  
                                    </li>
                                    <li>
                                        <a href="{{@Config::get('app.url')}}/admin/account/reset_password/{{$account->userid}}" class="bs-tooltip" title="Reset password" onclick="return confirm('Thao tác này không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-cog"></i></a>
                                    </li>

                                    <li>
                                        <a href="{{@Config::get('app.url')}}/admin/account/edit/{{$account->userid}}" class="bs-tooltip" title="Sửa"><i class="icon-pencil"></i></a> 
                                    </li>

                                    <li>
                                        <a href="{{@Config::get('app.url')}}/admin/account/delete/{{$account->userid}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa account {{$account->username}} không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
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