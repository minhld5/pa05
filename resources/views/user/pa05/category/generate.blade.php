@extends('user.layout')
@section('content')

<!--=== Responsive DataTable ===-->
<form action="{{@Config::get('app.url')}}/user/pa05/category/generate/{{$id}}" method="post">
        
    {{csrf_field()}}
    <!-- Hidden field -->

    <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
        <div class="widget" style="width:99%; align-content: center;">
            <div class="widget-header"><h4>Tạo dữ liệu từ danh mục khác</h4></div>

            <div class="widget-content">

                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Chọn danh mục đang có:</label>
                        <div class="col-md-2">
                            <select class="form-control" name="category" onchange='this.form.submit()'>
                                @if (!is_null($categories))
                                    @foreach($categories as $category)
                                        <option value="{{@@$category->id}}" selected>{{@@$category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
            <div class="form-actions" align = "center">
                <p class="btn-toolbar btn-toolbar-demo">
                    <a href="{{@Config::get('app.url')}}/user/pa05/category_detail/list/{{$id}}">
                        <button class="btn btn-primary" type="button" name="btnCancel" style="width:100px;">Hủy bỏ</button>
                    </a>

                    <button class="btn btn-primary" type="submit" name="btnOK" style="width:100px;">Đồng ý</button>
                </p>
            </div>
        </div>
    </div>
</form>

<!-- /Responsive DataTable -->


@endsection