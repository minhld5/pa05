@extends('admin.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>
<form action="{{@Config::get('app.url')}}/admin/system_config" method="post">
        
    {{csrf_field()}}
    <!-- Hidden field -->

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div style="height: 10px;"></div>
            <div class="widget-header"><h4>Cấu hình thông số hệ thống</h4></div>
            
            <div class="widget-content">
                <div class="widget-content">
                    <div class="row">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên hệ thống:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="system_name" value="{{@@$systemconfig->system_name}}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label">Thư mục lưu trữ vật lý:</label>
                            <div class="col-md-6">
                                @if (is_null($systemconfig->physical_storage_location) || $systemconfig->physical_storage_location=='')
                                    <input type="text" class="form-control" name="physical_storage_location" value="pa05/public/filestorage">
                                @else
                                    <input type="text" class="form-control" name="physical_storage_location" value="{{$systemconfig->physical_storage_location}}">
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Mật khẩu mặc định:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="default_password" value="{{@@$systemconfig->default_password}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">LDAP host:</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="ldap_host" value="{{@@$systemconfig->ldap_host}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">LDAP port:</label>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="ldap_port" value="{{@@$systemconfig->ldap_port}}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label">LDAP base DN:</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="ldap_dn" value="{{@@$systemconfig->ldap_dn}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

        </div>
        <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
            <div class="form-actions" align = "center">
                <p class="btn-toolbar btn-toolbar-demo">
                    <a href="{{@Config::get('app.url')}}/admin/home">
                        <button class="btn btn-primary" type="button" style="width:100px;">Hủy</button>
                    </a>
                    <button class="btn btn-primary" style="width:100px;" name="btnSubmit"  type="submit">Đồng ý</button>
                </p>
            </div>
        </div>
    </div>
</form>

<!-- /Responsive DataTable -->
@endsection