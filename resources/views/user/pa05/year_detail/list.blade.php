@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<div class="row">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4>
                    <a href="{{@Config::get('app.url')}}/user/pa05/year/list/{{@@$year->pa05_region_id}}" class="bs-tooltip" title="Quay lại"  style="text-decoration: none;">
                        <i class="icon-chevron-left"></i>
                    </a>

                    {{@@$year->year}}

                    <span id="totalmoney" style="margin-left: 20px; margin-right: 10px;">Tổng tiền: 0 VND</span>

                    @if (($pa05role=='pm' || $pa05role=='edit') && ($year->enable=='1'))
                        <span style="padding-left: 10px;"></span>
                        <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/create/{{@@$year->id}}" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
                            <i class="icon-plus-sign""></i>
                        </a>
                    @endif

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
                            <td style="display: none;"></td>
                            <th width="30"></th>
                            <th width="60">STT</th>
                            <th>Tên danh mục</th>
                            <th width="200">Hãng/Model/Xuất xứ</th>
                            <th width="90">Đơn vị</th>
                            <th width="120">Đơn giá</th>
                            <th width="80">S.lượng</th>
                            <th width="120">TT trước VAT</th>
                            <th width="70">VAT</th>
                            <th width="120">Thành tiền</th>
                            <th width="130">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalmoney=0;?>
                        @if (!is_null($year_details))
                            @foreach ($year_details as $year_detail)
                            <tr>
                                <td style="display: none;">{{@@$year_detail->order_no}}</td>
                                <th></th>
                                <?php $totalmoney = $totalmoney +  $year_detail->total;?>
                                @if($year_detail->type=='heading')
                                    <td style="font-weight: bold;" align="center">{{@@$year_detail->no}}</td>
                                    <td style="font-weight: bold;">{{@@$year_detail->name}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @else
                                    <td align="center">{{@@$year_detail->no}}</td>
                                    <td>
                                        {{@@$year_detail->name}}
                                        @if (!is_null($year_detail->product_id))
                                            <br><br>
                                            <a href="{{@Config::get('app.url')}}/user/productinfo/{{@@$year_detail->product_id}}" 
                                              target="popup" 
                                              onclick="popupCenter({productid: '{{$year_detail->product_id}}', title: 'xtf', w: 900, h: 500});">
                                                {{$year_detail->product_name}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>Hãng: {{@@$year_detail->brand}} <br>Model: {{@@$year_detail->model}} <br>Xuất xứ: {{@@$year_detail->origin}}</td>
                                    <td>{{@@$year_detail->unit}}</td>
                                    <td align="right">{{number_format($year_detail->unit_price)}}</td>
                                    <td align="right">{{@@$year_detail->quantity}}</td>
                                    <td align="right">{{number_format($year_detail->sub_total)}}</td>
                                    <td align="right">{{number_format($year_detail->vat)}}%</td>
                                    <td align="right">{{number_format($year_detail->total)}}</td>
                                @endif

                                
                                <td align="center">
                                    <ul class="table-controls">
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/view/{{@@$year_detail->id}}" class="bs-tooltip" title="Xem" style="text-decoration: none;"><i class="icon-eye-open"></i></a> 
                                        </li>
                                        @if (($pa05role=='pm' || $pa05role=='edit') && ($year->enable=='1'))     
                                            <li>
                                                @if($year_detail->type=='heading')
                                                    <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/heading_edit/{{@@$year_detail->id}}/
                                                    " class="bs-tooltip" title="Sửa" style="text-decoration: none;"><i class="icon-pencil"></i></a>
                                                @else
                                                    <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/edit/{{@@$year_detail->id}}" class="bs-tooltip" title="Sửa" style="text-decoration: none;"><i class="icon-pencil"></i></a> 
                                                @endif
                                            </li>
                                            <li>
                                                <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/delete/{{@@$year_detail->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa [{{@@$year_detail->name}}] khỏi danh mục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
                                            </li>
                                            <li>
                                                <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/heading_create/{{@@$year_detail->id}}" class="bs-tooltip" title="Thêm Heading" style="text-decoration: none;"><i class="icon-plus"></i></a> 
                                            </li>
                                            
                                            <li>
                                                @if ($year_detail->order_no<=1)
                                                    <a href="#"><i class=" icon-chevron-up" style="text-decoration: none;"></i></a> 
                                                @else
                                                    <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/order_up/{{@@$year_detail->id}}" class="bs-tooltip" style="text-decoration: none;"><i class=" icon-chevron-up"></i></a> 
                                                @endif
                                            </li>
                                            
                                            <li>
                                                @if ($year_detail->order_no>=$max_order_no)
                                                    <a href="#"><i class=" icon-chevron-down" style="text-decoration: none;"></i></a> 
                                                @else
                                                    <a href="{{@Config::get('app.url')}}/user/pa05/year_detail/order_down/{{@@$year_detail->id}}" class="bs-tooltip" style="text-decoration: none;"><i class=" icon-chevron-down"></i></a> 
                                                @endif  
                                            </li>
                                        @endif
                                    </ul>
                                </td>
                                

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

<div class="btn-group dropup">
    <button class="btn"><i class="icol-doc-excel-csv"></i> Thao tác</button>
    <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li><a href="{{@Config::get('app.url')}}/user/pa05/year_detail/save_to_excel/{{@@$year_detail->pa05_year_id}}" style="text-decoration: none;""><i class="icon-save"></i> Xuất ra file Excel</a></li>
    </ul>
</div>

<div style="height: 30px;"></div>

<script type="text/javascript">
    window.onload = function(){
        document.getElementById("totalmoney").innerHTML="Tổng tiền: {{number_format($totalmoney)}} VNĐ";  
    }

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
        var url = "{{@Config::get('app.url')}}/user/pa05/year_detail/product_info/"  + productid + '/';
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