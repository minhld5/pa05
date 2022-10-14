@extends('admin.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>
<form action="{{@Config::get('app.url')}}/user/general/filter/create/{{$sub_group->id}}" method="post">
        
    {{csrf_field()}}
    <!-- Hidden field -->

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div style="height: 10px;"></div>
            <div class="widget-header"><h4>Thêm bộ lọc</h4></div>
            
            <div class="widget-content">
                <div class="row">

                    <div class="form-group">
                        <label class="col-md-2 control-label">Nhóm</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" value="{{@@$sub_group->name}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Tên bộ lọc:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="name" value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Hiển thị:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="display_label" value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Loại:</label>
                        <div class="col-md-2">
                            <select class="form-control" name="type">
                                <option value="checkbox">Checkbox</option>
                                <option value="radio">Radio</option>
                            </select>
                        </div>
                    </div>
                </div>
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
@endsection