@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/pa05/year_detail/create_step2/{{$year->id}}" method="post">
        
{{csrf_field()}}
<input type="hidden" name="pa05category" value="{{$pa05category}}">

<div class="row">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4>
                    <i class="icon-reorder"></i> 
                    Chọn danh mục từ danh sách
                </h4>
                <div class="toolbar no-padding">
                    <div class="btn-group">
                        <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                    </div>
                </div>
            </div>
            <div class="widget-content">
                <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable" data-display-length="10">
                    <thead>
                        <tr>
                            <th width="50"></th>
                            <th>Tên</th>
                            <th width="150">Hãng</th>
                            <th width="200">Model</th>
                            <th width="150">Xuất xứ</th>
                            <th width="250">Sản phẩm đã chọn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pa05category_details as $pa05category_detail)
                        <tr>
                            <td align="center"><input type="radio" name="selecteditem" value="{{$pa05category_detail->id}}" <?php if($pa05category_detail->id==$selecteditem){echo 'checked';}?> onchange='this.form.submit()' required></td>
                            <td>{{@@$pa05category_detail->name}}</td>
                            <td>{{@@$pa05category_detail->brand}}</td>
                            <td>{{@@$pa05category_detail->model}}</td>
                            <td>{{@@$pa05category_detail->origin}}</td>
                            <td>
                                @if (!is_null($pa05category_detail->product_id))
                                    <a href="{{@Config::get('app.url')}}/user/productinfo/{{@@$pa05category_detail->product_id}}" 
                                      target="popup" 
                                      onclick="popupCenter({productid: '{{$pa05category_detail->product_id}}', title: 'xtf', w: 900, h: 500});">
                                        {{$pa05category_detail->product_name}}
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach                         
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4>
                    <i class="icon-reorder"></i> 
                    @if (is_null($prices) || count($prices)==0)
                        Danh mục chưa có giá. Vui lòng thiết lập giá cho danh mục trước khi sử dụng
                    @else
                        Chọn giá từ danh mục
                    @endif
                </h4>
                <div class="toolbar no-padding">
                    <div class="btn-group">
                        <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                    </div>
                </div>
            </div>
        </div>
         @if (!is_null($prices) && count($prices)>0)
        <div class="widget-content">
                <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable" data-display-length="10">
                    <thead>
                        <tr>
                            <th width="50"></th>
                            <th>Bảo hành</th>
                            <th width="150">Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prices as $price)
                        <tr>
                            <td align="center"><input type="radio" name="price" value="{{$price->price}}" required></td>
                            <td>{{@@$price->warranty_year}}</td>
                            <td>{{number_format($price->price)}}</td>
                            </td>
                        </tr>
                        @endforeach                         
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="form-horizontal" align-content: center; margin: 15px;">
    <div class="form-actions" align = "center">
        <p class="btn-toolbar btn-toolbar-demo">
            <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/list/{{$year->id}}">
                <button class="btn btn-primary" type="button" name="btnCancel" style="width:100px;">Hủy bỏ</button>
            </a>
            @if (is_null($prices) || count($prices)==0)
                <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;" disabled>Chọn</button>
            @else
                <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;">Chọn</button>
            @endif
        </p>
    </div>
</div>
<!-- /Responsive DataTable -->

</form>

<script>
    const popupCenter = ({productid, title, w, h}) => {
        // Fixes dual-screen position                             Most browsers      Firefox
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left = (width - w) / 2 / systemZoom + dualScreenLeft
        const top = (height - h) / 2 / systemZoom + dualScreenTop
        
        //var url = window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/public/user/productinfo/' + productid + '/';
        var url = "{{@Config::get('app.url')}}/user/pa05/year_detail/product_info/" + productid + "/";
        const newWindow = window.open(url, title, 
          `
          scrollbars=yes,
          width=${w / systemZoom}, 
          height=${h / systemZoom}, 
          top=${top}, 
          left=${left}
          `
        )
        if (window.focus) newWindow.focus();
    }
</script>

@endsection