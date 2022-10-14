@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/pa05/year_detail/question_form" method="post">
        
{{csrf_field()}}
<input type="hidden" name="yearid" value="{{$year->id}}">
<input type="hidden" name="name" value="{{$pa05category_detail->name}}">
<input type="hidden" name="model" value="{{$pa05category_detail->model}}">
<input type="hidden" name="brand" value="{{$pa05category_detail->brand}}">
<input type="hidden" name="origin" value="{{$pa05category_detail->origin}}">
<input type="hidden" name="unit" value="{{$pa05category_detail->unit}}">
<input type="hidden" name="unitprice" value="{{$price}}">
<input type="hidden" name="productid" value="{{$pa05category_detail->general_product_id}}">
<input type="hidden" name="categorydetail_id" value="{{$pa05category_detail->id}}">
<input type="hidden" name="type" value="{{$pa05category_detail->type}}">
<input type="hidden" name="note" value="{{$pa05category_detail->note}}">
<input type="hidden" name="refer_2517" value="{{$pa05category_detail->refer_2517}}">
<input type="hidden" name="spec" value="{{$pa05category_detail->spec}}">

<div class="alert fade in alert-danger" style="display: yes;">
    <i class="icon-remove close" data-dismiss="alert"></i>
    {{$pa05category_detail->name}} đã được chọn trong các danh mục năm 
    @foreach ($exists as $exist)
        {{$exist}} <span style="width:10px;"></span>
    @endforeach
    <br>
    Bạn có muốn tiếp tục chọn sản phẩm này cho danh mục {{$year->year}} không
</div>

<div class="form-horizontal" align-content: center; margin: 15px;">
    <div class="form-actions" align = "center">
        <p class="btn-toolbar btn-toolbar-demo">
            <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/list/{{$year->id}}">
                <button class="btn btn-primary" type="button" name="btnCancel" style="width:100px;">Không chọn</button>
            </a>

            <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;">Vẫn chọn</button>
        </p>
    </div>
</div>
<!-- /Responsive DataTable -->

</form>

@endsection