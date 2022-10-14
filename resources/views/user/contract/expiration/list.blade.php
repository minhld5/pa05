@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/contract/expiration/list" method="post">
{{csrf_field()}}
<div class="row" align="left">
    <table style="border: none; padding: 2px;">
        <tr>
            <td style="width: 10px;"></td>
            <td>
                Cần gia hạn: 
            </td>
            <td style="width: 5px;">
            </td>
            <td>
                <select class="form-control" name="duration" onchange='this.form.submit()' style="width: 250px;">
                    <option value=0>Chọn</option>
                    <option value=10 <?php if($duration==10){echo 'selected';} ?> >Trong 10 ngày</option>
                    <option value=30 <?php if($duration==30){echo 'selected';} ?> >Trong 30 ngày</option>
                    <option value=180 <?php if($duration==180){echo 'selected';} ?> >Trong vòng 6 tháng</option>
                </select>
            </td>
        </tr>
    </table>
</div>

<div style="height: 10px;">
</div>


<noscript><input type="submit" value="Submit"></noscript>

</form>

<div class="row">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4>
                    <i class="icon-reorder"></i> 
                    Danh sách hàng hóa sắp hết hạn
                </h4>
                <div class="toolbar no-padding">
                    <div class="btn-group">
                        <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                    </div>
                </div>
            </div>
            <div class="widget-content no-padding">
                <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable" data-display-length="10">
                    <thead>
                        <tr>
                            <th>Tên hàng hóa</th>
                            <th width="230">Đơn vị</th>
                            <th width="100">Năm</th>
                            <th width="250">Ghi chú</th>
                            <th width="120">Hết hạn</th>
                        </tr>
                    </thead>
                    <tbody>      
                        @if(!is_null($contract_goodses))
                            @foreach($contract_goodses as $contract_goods)
                                <tr>
                                    <td>{{@@$contract_goods->name}}</td>
                                    <td>{{@@$contract_goods->region}}</td>
                                    <td>{{@@$contract_goods->year}}</td>
                                    <td>{{@@$contract_goods->note}}</td>
                                    <td>{{date('d-m-Y',$contract_goods->expiration_date)}}</td>
                                </tr>
                            @endforeach
                        @endif                 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /Responsive DataTable -->

@endsection