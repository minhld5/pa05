@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/pa05/year_detail/heading_edit/{{$year_detail->id}}" method="post">
        
{{csrf_field()}}

<div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
    <div class="widget" style="width:99%; align-content: center;">
        <div class="widget-header"><h4>Thêm heading</h4></div>
        
        <div class="widget-content">
            <div class="widget-content">
                <div class="row">

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Số thứ tự:</label>
                        <div class="col-md-1">
                            <input type="text" name="no" class="form-control" value="{{$year_detail->no}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Tên:</label>
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" value="{{$year_detail->name}}" required>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
    <div class="form-actions" align = "center">
        <p class="btn-toolbar btn-toolbar-demo">
            <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/list/{{$year_detail->pa05_year_id}}">
                <button class="btn btn-primary" type="button" name="btnCancel" style="width:100px;">Hủy bỏ</button>
            </a>

            <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;">Cập nhật</button>
        </p>
    </div>
</div>

</form>

@endsection