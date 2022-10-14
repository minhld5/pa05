@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 10px;">
</div>

<form action="{{@Config::get('app.url')}}/user/pa05/member/create" method="post">
        
{{csrf_field()}}

<div class="row">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4>
                    <i class="icon-reorder"></i> 
                    Chọn user từ danh sách
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
                            <th>Họ tên</th>
                            <th width="350">Phòng ban</th>
                            <th width="350">Đơn vị</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                        <tr>
                            <td align="center"><input type="radio" name="selecteduser" value="{{$account->userid}}"></td>
                            <td>{{@@$account->fullname}}</td>
                            <td>{{@@$account->department}}</td>
                            <td>{{@@$account->unit}}</td>
                        </tr>
                        @endforeach                         
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <label class="col-md-1 control-label" align="right">Chọn role:</label>
        <div class="col-md-2">
            <select class="form-control" name="role">
                <option value="pm">pm</option>
                <option value="edit">edit</option>
                <option value="view">view</option>
            </select>
        </div>
    </div>
</div>

<div class="form-horizontal" align-content: center; margin: 15px;">
    <div class="form-actions" align = "center">
        <p class="btn-toolbar btn-toolbar-demo">
            <a href="{{@Config::get('app.url')}}/user/pa05/member/list">
                <button class="btn btn-primary" type="button" name="btnCancel" style="width:100px;">Hủy bỏ</button>
            </a>

            <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;">Cập nhật</button>
        </p>
    </div>
</div>
<!-- /Responsive DataTable -->

</form>

@endsection