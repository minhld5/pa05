@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/pa05/year/create/{{$pa05_region_id}}" method="post">
        
{{csrf_field()}}

<div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
    <div class="widget" style="width:99%; align-content: center;">
        <div class="widget-header"><h4>Nhập năm cho danh mục</h4></div>
        
        <div class="widget-content">
            <div class="widget-content">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label" align="right">Năm:</label>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="year" value="" placeholder="Ví dụ {{date('Y')}}" required>
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
            <a href="{{@Config::get('app.url')}}/user/pa05/year/list/{{$pa05_region_id}}">
                <button class="btn btn-primary" type="button" name="btnCancel" style="width:100px;">Hủy bỏ</button>
            </a>

            <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;">Thêm</button>
        </p>
    </div>
</div>

</form>

@endsection