@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div class="widget-header"><h4>Thông tin sản phẩm</h4></div>
            
            <div class="widget-content">
                <div class="widget-content">
                    <div class="row">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Nhóm:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" value="{{@@$product->subcategoryname}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên sản phẩm:</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" value="{{@@$product->name}}" readonly>
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
                            <div class="col-md-5">
                                <textarea class="form-control" rows="3" disabled>{{@@$product->shortdescription}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Mô tả đầy đủ:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="6" disabled>{{@@$product->longdescription}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Hãng:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" value="{{@@$product->brand}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Model:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="{{@@$product->model}}" readonly>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label class="col-md-2 control-label">Thông số kỹ thuật:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="7" disabled>{{@@$product->spec}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Xuất xứ:</label>
                            <div class="col-md-2">
                                <input id="total" class="form-control" name="origin" value="{{@@$product->origin}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Tham chiếu 2517:</label>
                            <div class="col-md-2">
                                <input class="form-control" name="origin" value="{{@@$product->refer2517}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Ghi chú:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="7" disabled>{{@@$product->note}}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div> 

            <div class="widget-header"><h4>Giá sản phẩm</h4></div>
            <div class="widget-content">
                <div class="widget-content">
                    @foreach ($prices as $price)
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{@@$price->warranty_year}}:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" value="{{number_format($price->price)}}" readonly>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
            <div class="form-actions" align = "center">
                <p class="btn-toolbar btn-toolbar-demo">
                    <a href="{{@Config::get('app.url')}}/user/general/product/list">
                        <button class="btn btn-primary" type="button" style="width:100px;">OK</button>
                    </a>
                </p>
            </div>
        </div>
    </div>

<!-- /Responsive DataTable -->
@endsection