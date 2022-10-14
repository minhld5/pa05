@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->
<form action="{{@Config::get('app.url')}}/user/pa05/category_detail/create/{{$category_id}}" method="post">
        
    {{csrf_field()}}
    <!-- Hidden field -->

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div class="widget-header"><h4>Thêm danh mục</h4></div>
            
            <div class="widget-content">
                <div class="widget-content">
                    <div class="row">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Thứ tự:</label>
                            <div class="col-md-1">
                                <input type="number" class="form-control" name="no" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên danh mục:</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Loại:</label>
                            <div class="col-md-1">
                                <select class="form-control" name="type">
                                    <option value="hardware" selected>Hardware</option>
                                    <option value="software">Software</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Hãng:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="brand" name="brand" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Model:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="model" name="model" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Xuất xứ:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="origin" name="origin" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Thông số kỹ thuật:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="7" id="spec" name="spec"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Đơn vị tính:</label>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="unit" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Tham chiếu 2517:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="refer_2517" name="refer_2517" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Ghi chú:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="7" id="note" name="note"></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">Sản phẩm đã chọn:</label>
                            <div class="col-md-4">
                                <input class="form-control" id="selected_product" name="selected_product" value="" readonly>
                            </div>
                        </div>

                    </div>
                </div>
            </div> 

            <div style="height: 20px;"></div>

            <div class="widget-header"><h4>Lựa chọn sản phẩm cho danh mục</h4></div>

            <div class="widget-content">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Loại thiết bị:</label>
                        <div class="col-md-2">
                            <select class="form-control" name="group" onchange='this.form.submit()'>
                                <option value="" selected>Chọn</option>
                                @if (!is_null($groupes))
                                    @foreach($groupes as $group)
                                        @if ($group->id==$selected_group)
                                            <option value="{{@@$group->id}}" selected>{{@@$group->display_label}}</option>
                                        @else
                                            <option value="{{@@$group->id}}">{{@@$group->display_label}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="sub_group" onchange='this.form.submit()'>
                                <option value="" selected>Chọn</option>
                                @if (!is_null($sub_groupes))
                                    @foreach($sub_groupes as $sub_group)
                                        @if ($sub_group->id==$selected_sub_group)
                                            <option value="{{@@$sub_group->id}}" selected>{{@@$sub_group->display_label}}</option>
                                        @else
                                            <option value="{{@@$sub_group->id}}">{{@@$sub_group->display_label}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Hãng sản xuất:</label>
                        <div class="col-md-2">
                            <select class="form-control" name="brands" onchange='this.form.submit()'>
                                <option value="" selected>Tất cả</option>
                                @if (!is_null($brands))
                                    @foreach($brands as $brand)
                                        @if ($brand->brand==$selected_brand)
                                            <option value="{{@@$brand->brand}}" selected>{{@@$brand->brand}}</option>
                                        @else
                                            <option value="{{@@$brand->brand}}">{{@@$brand->brand}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>


                <!-- Filter -->
                @if (!is_null($filters))
                    @foreach ($filters as $filter)
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{@@$filter->display_label}}:</label>
                                    
                                @if ($filter->type=='radio')
                                    <div class="col-md-10">
                                        @if(!is_null($filter_details))
                                            @foreach($filter_details as $filter_detail)
                                                @if ($filter_detail->general_filter_id==$filter->id)
                                                    <label class="radio-inline">
                                                        <input 
                                                            type="radio" 
                                                            class="uniform" 
                                                            name="radio{{$filter->id}}" 
                                                            value="{{@@$filter_detail->id}}"
                                                            onchange="this.form.submit()"
                                                            <?php
                                                                if (!is_null($posts)){
                                                                    foreach ($posts as $key => $value){
                                                                        if (!is_array($value)){
                                                                            if (str_starts_with($key,'radio')){
                                                                                    if ( (substr($key, 5)==$filter->id) && ($value==$filter_detail->id) ){
                                                                                        echo "checked ";
                                                                                    }
                                                                                }
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        >
                                                        {{@@$filter_detail->name}}
                                                    </label>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    <div class="col-md-10">
                                        @if(!is_null($filter_details))
                                            @foreach($filter_details as $filter_detail)
                                                @if ($filter_detail->general_filter_id==$filter->id)
                                                    <label class="checkbox-inline">
                                                        <input 
                                                            type="checkbox" 
                                                            class="uniform" 
                                                            name="option{{$filter->id}}[]" 
                                                            value="{{@@$filter_detail->id}}" 
                                                            onchange="this.form.submit()"
                                                            <?php 
                                                                if (!is_null($posts)){
                                                                    foreach ($posts as $key => $value){
                                                                        if (is_array($value)){
                                                                            foreach ($value as $v) {
                                                                                if (str_starts_with($key,'option')){
                                                                                    if ( (substr($key, 6)==$filter->id) && ($v==$filter_detail->id) ){
                                                                                        echo "checked ";
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        > 
                                                        {{@@$filter_detail->name}}
                                                    </label>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <!-- </div> -->
                @endif
                <!-- Kết thúc filter -->

                <div style="margin-left: 20px;">
                <!-- Product -->
                <?php $i=0;?>

                    @if(!is_null($products) && count($products)>0)
                        
                        @foreach ($products as $product)
                            <?php $i=$i+1;?>
                            @if ($i==1)
                                <div class="row" style="width: 1000px; display: block;">
                                    <div class="product_detail" style="background-color: rgb(255, 255, 255); display: block;">
                                        <div class="product_header">
                                            <a href="#" style="text-decoration: none;" title="{{$product->name}}">
                                                <font color="white">{{$product->name}}</font>
                                            </a>
                                        </div>
                                        <div style="border: 1px solid #767676;">

                                            <div style="margin: 5px;">             
                                                <div>
                                                    <?php 
                                                        $onclick="assignvalue('" . $product->name . "','" . json_encode($product->spec) . "','" . $product->brand . "','" . $product->model . "','" . $product->origin . "','" . $product->refer_2517 . "')"; 
                                                    ?>
                                                    
                                                    <input 
                                                        type="radio" 
                                                        name="product"
                                                        value="{{$product->id}}"
                                                        onclick="{{$onclick}}"
                                                        <?php
                                                            //Check xem trong $posts có product và value là on không
                                                            //Nếu có thì so key với product . bcdxct_bomhw_detail_id nếu bằng nhau thì thêm checked
                                                            if (!is_null($posts)){
                                                                foreach ($posts as $key => $value){
                                                                    if (!is_array($value)){
                                                                        if (($key == "product") && ($value==$product->id)){
                                                                            echo "checked ";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    >
                                                </div>
                                            </div>
                                            
                                            <div style="margin: 5px;">
                                               <a href="#"><img alt="{{$product->name}}" title="{{$product->spec}}" src="{{@Config::get('app.url')}}/filestorage/products/thumbimages/{{$product->thumb_image}}" style="visibility: visible; height: 56px;"></a>
                                            </div>
                                        </div>
                                    </div>
                            @elseif ($i==9)
                                <?php $i=0;?>
                                </div>
                                <div class="row" style="width: 1000px; display: block;">
                                    <div class="product_detail" style="background-color: rgb(255, 255, 255); display: block;">
                                        <div class="product_header">
                                            <a href="#" style="text-decoration: none;" title="{{$product->name}}">
                                                <font color="white">{{$product->name}}</font>
                                            </a>
                                        </div>
                                        <div style="border: 1px solid #767676;">

                                            <div style="margin: 5px;">             
                                                <div>
                                                    <?php 
                                                        $onclick="assignvalue('" . $product->name . "','" . json_encode($product->spec) . "','" . $product->brand . "','" . $product->model . "','" . $product->origin . "','" . $product->refer_2517 . "')"; 
                                                    ?>
                                                    <input 
                                                        type="radio" 
                                                        name="product"
                                                        value="{{$product->id}}" 
                                                        onclick="{{$onclick}}"
                                                        <?php
                                                            //Check xem trong $posts có product và value là on không
                                                            //Nếu có thì so key với product . bcdxct_bomhw_detail_id nếu bằng nhau thì thêm checked
                                                            if (!is_null($posts)){
                                                                foreach ($posts as $key => $value){
                                                                    if (!is_array($value)){
                                                                        if (($key == "product") && ($value==$product->id)){
                                                                            echo "checked ";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    >
                                                </div>
                                            </div>
                                            
                                            <div style="margin: 5px;">
                                               <a href="#"><img alt="{{$product->name}}" title="{{$product->spec}}" src="{{@Config::get('app.url')}}/filestorage/products/thumbimages/{{$product->thumb_image}}" style="visibility: visible; height: 56px;"></a>
                                            </div>
                                        </div>
                                    </div>
                            @else
                                    <div class="product_detail" style="background-color: rgb(255, 255, 255); display: block;">
                                        <div class="product_header">
                                            <a href="#" style="text-decoration: none;" title="{{$product->name}}">
                                                <font color="white">{{$product->name}}</font>
                                            </a>
                                        </div>
                                        <div style="border: 1px solid #767676;">
                                            <div style="margin: 5px;">             
                                                <div>
                                                    <?php 
                                                        $onclick="assignvalue('" . $product->name . "','" . json_encode($product->spec) . "','" . $product->brand . "','" . $product->model . "','" . $product->origin . "','" . $product->refer_2517 . "')"; 
                                                    ?>
                                                    <input 
                                                        type="radio" 
                                                        name="product" 
                                                        value="{{$product->id}}"
                                                        onclick="{{$onclick}}"
                                                        <?php
                                                            //Check xem trong $posts có product và value là on không
                                                            //Nếu có thì so key với product . bcdxct_bomhw_detail_id nếu bằng nhau thì thêm checked
                                                            if (!is_null($posts)){
                                                                foreach ($posts as $key => $value){
                                                                    if (!is_array($value)){
                                                                        if (($key == "product") && ($value==$product->id)){
                                                                            echo "checked ";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    >
                                                </div>
                                            </div>
                                            
                                            <div style="margin: 5px;">
                                                <a href="#"><img alt="{{$product->name}}" title="{{$product->spec}}" src="{{@Config::get('app.url')}}/filestorage/products/thumbimages/{{$product->thumb_image}}" style="visibility: visible; height: 56px;"></a>
                                            </div>
                                        </div>
                                    </div>
                            @endif
                        @endforeach
                        </div>
                    @endif
                </div>
                <!-- Ket thuc product -->
                </div>

            </div>

        </div>

        <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
            <div class="form-actions" align = "center">
                <p class="btn-toolbar btn-toolbar-demo">
                    <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/list/{{$category_id}}">
                        <button class="btn btn-primary" type="button" name="btnCancel" style="width:100px;">Hủy bỏ</button>
                    </a>

                    <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;">Thêm</button>
                </p>
            </div>
        </div>
    </div>
</form>

<!-- /Responsive DataTable -->

<script>
    function assignvalue(productname, spec, brand, model, origin, refer_2517){
        let isExecuted = confirm("Thay thế thông số, đơn giá bằng sản phẩm đã chọn?");
        if(isExecuted){
            document.getElementById("selected_product").value = productname;
            document.getElementById("spec").value = spec.split('"').join('');
            document.getElementById("brand").value = brand;
            document.getElementById("model").value = model;
            document.getElementById("origin").value = origin;
            document.getElementById("refer_2517").value = refer_2517;
        }
        // var unitprice = Number(total) + Number(document.getElementById('product-price-hidden').value);
        //     //var unitprice =   Number(total) + Number(document.getElementById('product-price-hidden').value.replaceAll(',',''));
        //     var totalmoney = unitprice * Number(document.getElementById('quantity').value);
        //     var unitpriceFormat = unitprice.toLocaleString('en-US');
        //     var totalFormat = totalmoney.toLocaleString('en-US');
        //     document.getElementById('unit-price').value = unitpriceFormat;
        //     document.getElementById('total').value = totalFormat;
    }

</script>
@endsection