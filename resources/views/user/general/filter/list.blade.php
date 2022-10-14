@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/general/filter/list" method="post">
{{csrf_field()}}
<div class="row" align="left">
    <table style="border: none; padding: 2px;">
        <tr>
            <td style="width: 10px;"></td>
            <td>
                Chọn nhóm: 
            </td>
            <td style="width: 5px;">
            </td>
            <td>
                <select class="form-control" name="group" onchange='this.form.submit()'>
                    <option value="0" selected>Chọn nhóm</option>
                    @foreach ($groupes as $group)
                        <option value="{{$group->id}}" <?php if(session('user_general_filter_group')==$group->id){echo 'selected';}?>>{{$group->name}}</option>
                    @endforeach             
                </select>
            </td>
            <td style="width: 20px;"></td>
            <td>
                Chọn nhóm con: 
            </td>
            <td style="width: 5px;">
            </td>
            <td>
                <select class="form-control" name="sub_group" onchange='this.form.submit()'>
                    <option value="0" selected>Chọn nhóm</option>
                    @if (!is_null($sub_groupes))
                        @foreach ($sub_groupes as $sub_group)
                            <option value="{{$sub_group->id}}" <?php if(session('user_general_filter_sub_group')==$sub_group->id){echo 'selected';}?>>{{$sub_group->name}}</option>
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

<?php
    if ($selected_group==''){$selected_group=0;}
    if ($selected_sub_group==''){$selected_sub_group=0;}
?>

<div class="row">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4>
                    <i class="icon-reorder"></i> 
                    Danh sách bộ lọc
                    <span style="padding-left: 10px;"></span>
                    <a href="{{@Config::get('app.url')}}/user/general/filter/create/{{$selected_sub_group}}" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
                        <i class="icon-plus-sign"></i>
                    </a>
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
                            <th width="30"></th>
                            <th width="250">Tên bộ lọc</th>
                            <th >Hiển thị</th>
                            <th width="250">Loại</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!is_null($filters))
                            @foreach ($filters as $filter)
                            <tr>
                                <td></td>
                                <td>{{@@$filter->name}}</td>
                                <td>{{@@$filter->display_label}}</td>
                                <td>{{@@$filter->type}}</td>
                                <td align="center">
                                    <ul class="table-controls">                    
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/general/filter/edit/{{$filter->id}}" class="bs-tooltip" title="Sửa"><i class="icon-pencil"></i></a> 
                                        </li>
                                        <li>
                                            <a href="{{@Config::get('app.url')}}/user/general/filter/delete/{{$filter->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa bộ lọc {{$filter->name}} và không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
                                        </li>

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
@endsection