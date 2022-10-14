@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/contract/list/reset_year/{{$contract_list->id}}" method="post">
        
{{csrf_field()}}

<div class="row">
    <div class="form-group">
        <label class="col-md-3 control-label" align="right">Chọn danh mục PA05:</label>
        <div class="col-md-2">
            <select class="form-control" name="pa05_year">
                <option value="">Chọn từ danh sách</option>
                @if (!is_null($pa05_years))
                    @foreach ($pa05_years as $pa05_year)
                        <option value="{{$pa05_year->id}}">{{$pa05_year->year}}</option>
                    @endforeach             
                @endif 
            </select>
        </div>
    </div>
</div>

<div class="form-horizontal" align-content: center; margin: 15px;">
    <div class="form-actions" align = "center">
        <p class="btn-toolbar btn-toolbar-demo">
            <a href="{{@Config::get('app.url')}}/user/contract/list/detail/{{$contract_list->id}}/goods">
                <button class="btn btn-primary" type="button" name="btnCancel" style="width:100px;">Quay lại</button>
            </a>

            <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;">Tiếp tục</button>
        </p>
    </div>
</div>
<!-- /Responsive DataTable -->

</form>

@endsection