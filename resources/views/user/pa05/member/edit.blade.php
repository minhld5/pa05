@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->

<div style="height: 20px;">
</div>

<form action="{{@Config::get('app.url')}}/user/pa05/member/edit/{{$member->id}}" method="post">
        
{{csrf_field()}}

<div class="row">
    <div class="form-group">
        <label class="col-md-1 control-label" align="right">User:</label>
        <div class="col-md-2">
            <input type="text" class="form-control"  value="{{$member->fullname}}" readonly>
        </div>
    </div>
</div>

<div style="height: 10px;">
</div>

<div class="row">
    <div class="form-group">
        <label class="col-md-1 control-label" align="right">Chọn role:</label>
        <div class="col-md-2">
            <select class="form-control" name="role">
                <option value="pm" <?php if($member->role=='pm'){echo 'selected';}?> >pm</option>
                <option value="edit" <?php if($member->role=='edit'){echo 'selected';}?> >edit</option>
                <option value="view" <?php if($member->role=='view'){echo 'selected';}?> >view</option>
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