@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/pa05/year_detail/create/{{$year->id}}" method="post">
        
{{csrf_field()}}

<div class="row">
    <div class="form-group">
        <label class="col-md-3 control-label" align="right">Chọn danh mục dùng chung:</label>
        <div class="col-md-2">
            <select class="form-control" name="pa05category">
                @foreach ($pa05categories as $pa05category)
                    <option value="{{$pa05category->id}}">{{$pa05category->name}}</option>
                @endforeach              
            </select>
        </div>
    </div>
</div>

<div class="form-horizontal" align-content: center; margin: 15px;">
    <div class="form-actions" align = "center">
        <p class="btn-toolbar btn-toolbar-demo">
            <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/list/{{$year->id}}">
                <button class="btn btn-primary" type="button" name="btnCancel" style="width:100px;">Hủy bỏ</button>
            </a>

            <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;">Tiếp tục</button>
        </p>
    </div>
</div>
<!-- /Responsive DataTable -->

</form>

@endsection