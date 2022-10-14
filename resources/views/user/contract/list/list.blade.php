@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/contract/list/list" method="post">
{{csrf_field()}}
<div class="row" align="left">
    <table style="border: none; padding: 2px;">
        <tr>
            <td style="width: 10px;"></td>
            <td>
                Năm: 
            </td>
            <td style="width: 5px;">
            </td>
            <td>
                <select class="form-control" name="year" onchange='this.form.submit()' style="width: 250px;">
                    <option value="0">Chọn năm muốn xem</option>
                    @if(!is_null($years))    
                        @foreach ($years as $year)
                            <option value="{{$year->year}}" <?php if(session('user_contract_year')==$year->year){echo 'selected';}?>>
                                {{$year->year}}
                            </option>
                        @endforeach    
                    @endif         
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
                    Danh sách hợp đồng
                    <span style="padding-left: 10px;"></span>
                    @if ($contract_role=='pm')
                        <a href="{{@Config::get('app.url')}}/user/contract/list/create" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
                            <i class="icon-plus-sign" onclick="addnew()"></i>
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
                            <th width="230">Đơn vị</th>
                            <th>Năm</th>
                            <th width="250">Tình trạng</th>
                            <th width="120">Hết hạn</th>
                            <th width="200">PM</th>
                            <th width="150">Giá trị</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contract_lists as $contract_list)
                        <tr>
                            <td><a href="{{@Config::get('app.url')}}/user/contract/list/detail/{{@@$contract_list->id}}/overview" class="bs-tooltip" title="{{@@$contract_list->note}}" style="text-decoration: none;">{{@@$contract_list->region}}</a></td>
                            <td>{{@@$contract_list->year}}</td>
                            <td>{{@@$contract_list->overall_status}}</td>
                            <td>
                                <?php if(date("d/m/Y", $contract_list->due_date)!='01/01/1970'){echo(date("d/m/Y", $contract_list->due_date));}?>
                            </td>
                            <td>{{@@$contract_list->pm_fullname}}</td>
                            <td align="right">{{number_format($contract_list->total_value)}}</td>
                            <td align="center">
                                
                                <ul class="table-controls"> 
                                    @if($contract_list->pm_id==$sessionuser->userid && $contract_list->is_lock==0)                   
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/contract/list/edit/{{@@$contract_list->id}}" class="bs-tooltip" title="Sửa" style="text-decoration: none;"><i class="icon-pencil"></i></a> 
                                        </li>
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/contract/list/delete/{{@@$contract_list->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
                                        </li>
                                    @endif

                                    @if($contract_list->pm_id==$sessionuser->userid && $contract_list->is_lock==0)
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/contract/list/lock/{{@@$contract_list->id}}" class="bs-tooltip" title="Khóa" style="text-decoration: none;">
                                                <i class="icon-lock"></i>
                                            </a>
                                        </li>
                                    @endif

                                    @if($contract_list->pm_id==$sessionuser->userid && $contract_list->is_lock==1)
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/contract/list/unlock/{{@@$contract_list->id}}" title="Mở khóa" class="bs-tooltip" style="text-decoration: none;">
                                                <i class="icon-unlock"></i>
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                                
                            </td>
                        </tr>
                        @endforeach                         
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /Responsive DataTable -->

@endsection