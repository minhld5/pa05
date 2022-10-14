@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/pa05/region/create" method="post">
        
{{csrf_field()}}

<div class="row">
    <div class="form-group">
        <label class="col-md-3 control-label" align="right">Chọn tỉnh/thành phố:</label>
        <div class="col-md-2">
            <select class="form-control" name="region">
                
                @foreach($regions as $region)
                    <option value="{{$region->id}}">{{$region->name}}</option>
                @endforeach
                
            </select>
        </div>
    </div>
</div>

<div class="form-horizontal" align-content: center; margin: 15px;">
    <div class="form-actions" align = "center">
        <p class="btn-toolbar btn-toolbar-demo">
            <a href="{{@Config::get('app.url')}}/user/pa05/region/list">
                <button class="btn btn-primary" type="button" name="btnCancel" style="width:100px;">Hủy bỏ</button>
            </a>

            <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;">Đồng ý</button>
        </p>
    </div>
</div>
<!-- /Responsive DataTable -->

</form>

@endsection