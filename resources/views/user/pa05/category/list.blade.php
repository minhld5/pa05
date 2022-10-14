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
                    <i class="icon-reorder"></i> 
                    Danh sách danh mục dùng chung PA05
                    <span style="padding-left: 10px;"></span>
                    <a href="#" class="bs-tooltip" title="Thêm" style="text-decoration: none;">
                        <i class="icon-plus-sign" onclick="addnew()"></i>
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
                            <th>Tên danh mục</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td></td>
                            <td><a href="{{@Config::get('app.url')}}/user/pa05/category_detail/list/{{$category->id}}" style="text-decoration: none;">{{@@$category->name}}</a></td>
                            <td align="center">
                                <ul class="table-controls">                    
                                    <li>
                                        <a href="#" class="bs-tooltip" title="Sửa" style="text-decoration: none;"><i class="icon-pencil" onclick='edit("{{$category->id}}")'></i></a> 
                                    </li>
                                    <li>
                                        <a href="{{@Config::get('app.url')}}/user/pa05/category/delete/{{$category->id}}" class="bs-tooltip" title="Xóa" onclick="return confirm('Thao tác này sẽ xóa {{$category->name}} và không thể khôi phục. Bạn có chắc không?');" style="text-decoration: none;"><i class="icon-trash"></i></a>
                                    </li>

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

<script>
    function addnew(){
        var content = prompt("Nhập tên danh mục dùng chung");
        //alert (filterdetail);

        if(content){
            //var url = window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/public/user/pa05/category/0/' + content + '/addnew';
            var url = "{{@Config::get('app.url')}}/user/pa05/category/create/" + content; 
            window.location = url;
            return false;
        }
    }

    function edit(id){
        var content = prompt("Nhập tên mới");
        //alert (filterdetail);

        if(content){
            //var url = window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/public/user/pa05/category/' + id + '/' + content + '/edit';
            var url = "{{@Config::get('app.url')}}/user/pa05/category/edit/" + id + "/" + content;
            window.location = url;
            return false;
        }
    }

</script>
@endsection