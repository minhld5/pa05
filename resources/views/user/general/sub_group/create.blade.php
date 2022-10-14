@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>
<form action="{{@Config::get('app.url')}}/user/general/sub_group/create/{{@@$group->id}}" method="post">
        
    {{csrf_field()}}
    <!-- Hidden field -->

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div style="height: 10px;"></div>
            <div class="widget-header"><h4>Thêm nhóm con cho {{@@$group->name}}</h4></div>
            
            <div class="widget-content">
                <div class="widget-content">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Trật tự:</label>
                            <div class="col-md-1">
                                <input type="number" class="form-control" name="order" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên nhóm con:</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="name" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Mô tả:</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="description" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Hiển thị:</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="display_label" value="">
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div> 

        </div>
        <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
            <div class="form-actions" align = "center">
                <p class="btn-toolbar btn-toolbar-demo">
                    <a href="{{@Config::get('app.url')}}/user/general/sub_group/list/{{$group->id}}">
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