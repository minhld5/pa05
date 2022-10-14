@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>


<div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
    <div class="widget" style="width:99%; align-content: center;">
        <div class="widget-header"><h4>Thông tin chi tiết danh mục</h4></div>
        
        <div class="widget-content">
            <div class="widget-content">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Tên:</label>
                        <div class="col-md-6">
                            <textarea rows="3" class="form-control" disabled>{{$year_detail->name}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Hãng/model/xuất xứ:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="Hãng: {{$year_detail->brand}}/Model: {{$year_detail->model}}/Xuất xứ: {{$year_detail->origin}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Trật tự hiển thị:</label>
                        <div class="col-md-1">
                            <input type="number" name="order_no" class="form-control" value="{{$year_detail->order_no}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Số thứ tự:</label>
                        <div class="col-md-1">
                            <input type="number" name="no" class="form-control" value="{{$year_detail->no}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Đơn vị tính:</label>
                        <div class="col-md-1">
                            <input type="text" class="form-control" value="{{$year_detail->unit}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Số lượng:</label>
                        <div class="col-md-2">
                            <input type="number" name="quantity" id="quantity" class="form-control" value="{{number_format($year_detail->quantity)}}" onchange="calculate()" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Đơn giá:</label>
                        <div class="col-md-2">
                            <input type="text" name="unit_price" id="unit_price" class="form-control just-number price-format-input" value="{{number_format($year_detail->unit_price)}}" onchange="calculate()" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Thành tiền trước VAT:</label>
                        <div class="col-md-2">
                            <input type="text" name="sub_total" id="sub_total" class="form-control just-number price-format-input" value="{{number_format($year_detail->sub_total)}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">VAT (%):</label>
                        <div class="col-md-1">
                            <?php 
                                $vat=0;
                                if(is_null($year_detail->vat)){
                                    if($year_detail->type=='hardware'){
                                        $vat=10;
                                    }else{
                                        $vat=0;
                                    }
                                }else{
                                    $vat = $year_detail->vat;
                                }
                            ?>
                            <input type="number" name="vat" step="0.5" id="vat" class="form-control just-number price-format-input" value="{{$vat}}" onchange="calculate()" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" align="right">Thành tiền:</label>
                        <div class="col-md-2">

                            <input type="text" name="total" id="total" class="form-control just-number price-format-input" value="{{number_format($year_detail->total)}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Thông số kỹ thuật:</label>
                        <div class="col-md-6">
                            <textarea class="form-control" rows="7" name="spec" disabled>{{$year_detail->spec}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Tham chiếu 2517:</label>
                        <div class="col-md-6">
                            <textarea class="form-control" rows="3" name="refer_2517" disabled>{{$year_detail->refer_2517}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Ghi chú:</label>
                        <div class="col-md-6">
                            <textarea class="form-control" rows="7" name="note" disabled>{{$year_detail->note}}</textarea>
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
            <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/list/{{$year_detail->pa05_year_id}}">
                <button class="btn btn-primary" type="button" name="OK" style="width:100px;">OK</button>
            </a>

        </p>
    </div>
</div>



<script>
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

    function calculate(){


        var subtotal = Number(document.getElementById('quantity').value) * Number(document.getElementById('unit_price').value.replaceAll(',',''));
        var subtotalFormat = subtotal.toLocaleString('en-US');
        document.getElementById('sub_total').value = subtotalFormat;

        var total = subtotal + (subtotal* Number(document.getElementById('vat').value)/100 );
        var totalFormat = total.toLocaleString('en-US');
         document.getElementById('total').value = totalFormat;
    }

</script>

@endsection