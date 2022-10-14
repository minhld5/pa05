@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>
<form action="{{@Config::get('app.url')}}/user/general/product/edit/{{@@$product->id}}" method="post" enctype="multipart/form-data">
        
    {{csrf_field()}}
    <!-- Hidden field -->

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div style="height: 10px;"></div>
            <div class="widget-header"><h4>Cập nhật thông tin sản phẩm</h4></div>
            
            <div class="widget-content">
                <div class="widget-content">
                    <div class="row">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Sub Category:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="{{@@$product->subcategoryname}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên sản phẩm:</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="name" value="{{@@$product->name}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-4">
                                <img alt="{{$product->name}}" title="{{$product->name}}" src="{{@Config::get('app.url')}}/filestorage/products/thumbimages/{{$product->thumbimage}}" style="visibility: visible; max-height: 56px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Mô tả ngắn gọn:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="short_description" rows="3">{{@@$product->shortdescription}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Mô tả đầy đủ:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="long_description" rows="5">{{@@$product->longdescription}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Hãng:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="brand" value="{{@@$product->brand}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Model:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="model" value="{{@@$product->model}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Xuất xứ:</label>
                            <div class="col-md-2">
                                <input id="total" class="form-control" name="origin" value="{{@@$product->origin}}">
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label class="col-md-2 control-label">Thông số kỹ thuật:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="spec" value="" rows="5">{{@@$product->spec}}</textarea>
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <label class="col-md-2 control-label">Ảnh thumbnail:</label>
                            <div class="col-md-4">
                                <input class="form-control" type="file" name="thumb_image" id="thumbimage" accept="image/*">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Tham chiếu 2517:</label>
                            <div class="col-md-6">
                                <input class="form-control" name="refer2517" value="{{@@$product->refer2517}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Ghi chú:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="note" rows="5">{{@@$product->note}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="height: 10px;"></div>
            <div class="widget-header"><h4>Giá sản phẩm</h4> <span style="width: 40px;">&nbsp;</span> <a style="text-decoration: none;" href="{{@Config::get('app.url')}}/user/general/product/price_create/{{@@$product->id}}" class="bs-tooltip" title="Thêm"><i class="icon-plus"></i></a></div> 

            <div class="widget-content no-padding">
                <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable" data-display-length="10">
                    <thead>
                        <tr>
                            <th>Thời gian bảo hành</th>
                            <th width="250">Giá tiền</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prices as $price)
                        <tr>
                            <td>{{@@$price->warranty_year}}</td>
                            <td align="right">{{number_format($price->price)}}</td>
                            <td align="center">
                                <ul class="table-controls"> 
                                    <li>
                                        </i></a> 
                                    </li>                   
                                    <li>
                                        <a href="{{@Config::get('app.url')}}/user/general/product/price_edit/{{@@$price->id}}" class="bs-tooltip" title="Sửa"><i class="icon-pencil"></i></a> 
                                    </li>
                                    <li>
                                        <a href="{{@Config::get('app.url')}}/user/general/product/price_delete/{{@@$price->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa dữ liệu và không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
                                    </li>

                                </ul>
                            </td>
                        </tr>  
                        @endforeach                   
                    </tbody>
                </table>
            </div>

        </div>
        <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
            <div class="form-actions" align = "center">
                <p class="btn-toolbar btn-toolbar-demo">
                    <a href="{{@Config::get('app.url')}}/user/general/product/list">
                        <button class="btn btn-primary" type="button" style="width:100px;">Hủy</button>
                    </a>
                    <button class="btn btn-primary" style="width:100px;" name="btnSubmit"  type="submit">Đồng ý</button>
                </p>
            </div>
        </div>
    </div>
</form>

<!-- /Responsive DataTable -->

<script>
    $(document).ready(function(){
        "use strict";

        App.init(); // Init layout and core plugins
        Plugins.init(); // Init all plugins
        FormComponents.init(); // Init all form-specific plugins
    });

    $(document).on("keypress", ".just-number", function (e) {
        let charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
         }
    });
    $(document).on('keyup', '.price-format-input', function (e) {
        let val = this.value;
        val = val.replace(/,/g, "");
        if (val.length > 3) {
            let noCommas = Math.ceil(val.length / 3) - 1;
            let remain = val.length - (noCommas * 3);
            let newVal = [];
            for (let i = 0; i < noCommas; i++) {
                newVal.unshift(val.substr(val.length - (i * 3) - 3, 3));
            }   
            newVal.unshift(val.substr(0, remain));
            this.value = newVal;
        }
        else {
            this.value = val;
        }
    });

</script>
@endsection