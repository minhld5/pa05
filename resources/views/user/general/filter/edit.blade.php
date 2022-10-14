@extends('admin.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>
<form action="{{@Config::get('app.url')}}/user/general/filter/edit/{{$filter->id}}" method="post">
        
    {{csrf_field()}}
    <!-- Hidden field -->

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div style="height: 10px;"></div>
            <div class="widget-header"><h4>Thông tin bộ lọc</h4></div>
            
            <div class="widget-content">
                <div class="row">

                    <div class="form-group">
                        <label class="col-md-2 control-label">Nhóm sản phẩm:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="{{$filter->general_sub_group}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Tên bộ lọc:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="name" value="{{$filter->name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Hiển thị:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="display_label" value="{{$filter->display_label}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Loại:</label>
                        <div class="col-md-2">
                            <select class="form-control" name="type">
                                <option value="checkbox" <?php if($filter->type == "checkbox") {echo 'selected';} ?> >Checkbox</option>
                                <option value="radio" <?php if($filter->type == "radio") {echo 'selected';} ?> >Radio</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget-header">
                <h4>Danh sách điều kiện</h4>
                <span style="padding-left: 10px;"></span>
                <a href="#" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
                    <?php $onclick= "enterfilterdetail(". $filter->id . ")"; ?>
                    <i class="icon-plus-sign" onclick="{{$onclick}}"></i>
                </a>
            </div>

            <div class="widget-content no-padding">
                <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable" data-display-length="10">
                    <thead>
                        <tr>
                            <th>Tên điều kiện</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!is_null($filter_details))
                            @foreach ($filter_details as $filter_detail)
                            <tr>
                                <td>{{@@$filter_detail->name}}</td>
                                <td align="center">
                                    <ul class="table-controls">
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/general/filter_detail/select_product/{{$filter_detail->id}}" class="bs-tooltip" title="Chọn sản phẩm" style="text-decoration: none;"><i class="icon-edit"></i></a> 
                                        </li>                  
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/general/filter_detail/delete/{{$filter_detail->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa dữ liệu {{$filter_detail->name}} và không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
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
        <div class="widget" style="width:99%; align-content: center;">
            <div class="form-actions" align = "center">
                <p class="btn-toolbar btn-toolbar-demo">
                    <a href="{{@Config::get('app.url')}}/user/general/filter/list">
                        <button class="btn btn-primary" type="button" style="width:100px;">Hủy</button>
                    </a>
                    <button class="btn btn-primary" style="width:100px;" name="btnSubmit"  type="submit">Tiếp tục</button>
                </p>
            </div>
        </div>
    </div>
</form>

<!-- /Responsive DataTable -->

<script>
    function enterfilterdetail(filterid){
        var filterdetail = prompt("Nhập điều kiện");

        if(filterdetail){
            var url = "{{@Config::get('app.url')}}/user/general/filter_detail/create/"  + filterid + "/" + filterdetail;
            window.location = url;
            return false;
        }

    }
</script>
@endsection