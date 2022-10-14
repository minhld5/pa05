@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>
<form action="{{@Config::get('app.url')}}/user/pa05/category_detail/price_create/{{$category_detail_id}}" method="post">
        
    {{csrf_field()}}
    <!-- Hidden field -->

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div style="height: 10px;"></div>
            <div class="widget-header"><h4>Thêm giá tiền cho danh mục</h4></div>
            
            <div class="widget-content">
                <div class="widget-content">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Thời gian:</label>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="warranty_year" value="" placeholder="ví dụ 5 năm" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Giá tiền (VNĐ):</label>
                            <div class="col-md-3">
                                <input id="price" class="form-control just-number price-format-input" name="price" value="" required>
                            </div>
                        </div>

                    </div>
                </div>
            </div> 

        </div>
        <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
            <div class="form-actions" align = "center">
                <p class="btn-toolbar btn-toolbar-demo">
                    <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/price_list/{{$category_detail_id}}">
                        <button class="btn btn-primary" type="button" style="width:100px;">Hủy</button>
                    </a>
                    <button class="btn btn-primary" style="width:100px;" name="btnSubmit"  type="submit">Thêm</button>
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