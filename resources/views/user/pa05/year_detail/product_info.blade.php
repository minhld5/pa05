<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title>{{$systemconfig->system_name}}</title>
	<link rel="shortcut icon" href="{{@Config::get('app.url')}}/favicon.ico" type="image/x-icon" />

	<!-- Bootstrap -->
	<link href="{{@Config::get('app.url')}}/melon/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- jQuery UI -->
	<!--<link href="plugins/jquery-ui/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />-->
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/>
	<![endif]-->

	<!-- Theme -->
	<link href="{{@Config::get('app.url')}}/melon/assets/css/main.css" rel="stylesheet" type="text/css" />
	<link href="{{@Config::get('app.url')}}/melon/assets/css/plugins.css" rel="stylesheet" type="text/css" />
	<link href="{{@Config::get('app.url')}}/melon/assets/css/responsive.css" rel="stylesheet" type="text/css" />
	<link href="{{@Config::get('app.url')}}/melon/assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{@Config::get('app.url')}}/melon/assets/css/fontawesome/font-awesome.min.css">
	<!--[if IE 7]>
		<link rel="stylesheet" href="assets/css/fontawesome/font-awesome-ie7.min.css">
	<![endif]-->

	<!--[if IE 8]>
		<link href="assets/css/ie8.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
	<!--=== JavaScript ===-->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/assets/js/libs/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/assets/js/libs/lodash.compat.min.js"></script>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="assets/js/libs/html5shiv.js"></script>
	<![endif]-->

	<!-- Smartphone Touch Events -->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/event.swipe/jquery.event.move.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/event.swipe/jquery.event.swipe.js"></script>

	<!-- General -->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/assets/js/libs/breakpoints.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/respond/respond.min.js"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/select2/select2.min.js"></script> <!-- Styled select boxes -->

	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/typeahead/typeahead.min.js"></script> <!-- AutoComplete -->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/autosize/jquery.autosize.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/inputlimiter/jquery.inputlimiter.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/uniform/jquery.uniform.min.js"></script> 
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/tagsinput/jquery.tagsinput.min.js"></script>
	
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/cookie/jquery.cookie.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>

	<!-- Page specific plugins -->
	<!-- Charts -->
	<!--script type="text/javascript" src="{{@Config::get('app.url')}}/template/plugins/sparkline/jquery.sparkline.min.js"></script-->

	<!--[if lt IE 9]>
		<script type="text/javascript" src="plugins/flot/excanvas.min.js"></script>
	<![endif]-->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/flot/jquery.flot.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/flot/jquery.flot.tooltip.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/flot/jquery.flot.resize.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/flot/jquery.flot.time.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/flot/jquery.flot.growraf.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/blockui/jquery.blockUI.min.js"></script>

	<!-- Pickers -->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/pickadate/picker.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/pickadate/picker.time.js"></script>

	<!-- DataTables -->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/datatables/DT_bootstrap.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/datatables/responsive/datatables.responsive.js"></script> <!-- optional -->

	<!-- Forms -->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/select2/select2.min.js"></script>

	<!-- WYSWYG -->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/bootstrap-wysihtml5/wysihtml5.min.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.min.js"></script>

	<!-- App -->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/assets/js/app.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/assets/js/plugins.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/assets/js/plugins.form-components.js"></script>

	<!-- Flow chart -->
	<script src="https://unpkg.com/gojs@2.2.11/release/go.js"></script>

	<script>
	$(document).ready(function(){
		"use strict";

		App.init(); // Init layout and core plugins
		Plugins.init(); // Init all plugins
		FormComponents.init(); // Init all form-specific plugins
	});
	</script>

	<!-- Demo JS -->
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/assets/js/custom.js"></script>
	<script type="text/javascript" src="{{@Config::get('app.url')}}/melon/assets/js/demo/ui_general.js"></script>
	
</head>

<body>

	<p style="margin:20px;"><b>{{@@$product->name}}</b></p>

	<p style="margin:20px;"><img alt="{{$product->name}}" title="{{$product->name}}" src="{{@Config::get('app.url')}}/filestorage/products/thumbimages/{{$product->thumb_image}}" style="visibility: visible; max-height: 56px;"></p>

	<p style="margin:20px;">{{@@$product->short_description}}</p>

	<p style="margin:20px;">{{@@$product->long_description}}</p>

	<p style="margin:20px;">Hãng sản xuất: {{@@$product->brand}}</p>

	<p style="margin:20px;">Model: {{@@$product->model}}</p>

	

	@foreach ($prices as $price)
        <p style="margin:20px;">- Bảo hành {{@@$price->warranty_year}}: {{number_format($price->price)}}</p>
    @endforeach

	<div class="form-horizontal" style="width:99%; align-content: center; margin: 15px;">
     	<div class="form-actions" align = "center">
            <p class="btn-toolbar btn-toolbar-demo">
                <button class="btn btn-primary" type="button" onclick="window.close()" style="width:100px;">Đóng cửa sổ</button>
            </p>
        </div>
    </div>

</body>

</html>