<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title>{{@@$systemconfig->system_name}}</title>
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
	<!-- script type="text/javascript" src="{{@Config::get('app.url')}}/template/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script-->

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

	<style>
        .product_header {
            /*background-color: rgb(118, 118, 118); */
            display: block; 
            width: 113px; 
            height: 18px;
            padding: 0 2px 3px 2px; font-size: 12px;
            float: left;
            border: 1px solid #767676;
            /*margin: 5px 0 0 2px;*/
            font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            background-color: #767676;text-align: center;
        }

        .product_detail{
        	background-color: rgb(255, 255, 255); 
        	display: block; 
        	position: relative; 
        	width: 117px; 
        	height: 110px;
        	padding: 2px;
        	float: left; 
        	border: 0px solid #767676; 
        }

    </style>
	
</head>

<body>

	<!-- Header -->
	<header class="header navbar navbar-fixed-top" role="banner">
		<!-- Top Navigation Bar -->
		<div class="container">

			<!-- Only visible on smartphones, menu toggle -->
			<ul class="nav navbar-nav">
				<li class="nav-toggle"><a href="javascript:void(0);" title=""><i class="icon-reorder"></i></a></li>
			</ul>

			<!-- Logo -->
			<a class="navbar-brand" href="{{@Config::get('app.url')}}/user/home">
				<img src="{{@Config::get('app.url')}}/logo.png" alt="logo" style="width:30px;"/>
				<strong>{{@@$systemconfig->system_name}} | Người dùng</strong>
			</a>
			<!-- /logo -->	

			<!-- Top Right Menu -->
			<ul class="nav navbar-nav navbar-right">

				<!-- User Login Dropdown -->
				<li class="dropdown user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!--<img alt="" src="assets/img/avatar1_small.jpg" />-->
						<i class="icon-male"></i>
						<span class="username">{{$sessionuser->username}}</span>
						<i class="icon-caret-down small"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#"><i class="icon-user"></i> Hồ sơ</a></li>
						<?php
							if($sessionuser->is_ldap=='0'){
						?>
							<li><a href="{{@Config::get('app.url')}}/user/change_password"><i class="icon-key"></i> Đổi mật khẩu</a></li>
						<?php
							}
						?>			
									
						<li class="divider"></li>
						<li><a href="{{@Config::get('app.url'). '/user/logout'}}"><i class="icon-signout"></i> Log Out</a></li>
					</ul>
				</li>
				<!-- /user login dropdown -->
			</ul>
			<!-- /Top Right Menu -->
		</div>
		<!-- /top navigation bar -->

		
	</header> <!-- /.header -->

	<div id="container" class="fixed-header sidebar-closed">
		<div id="sidebar" class="sidebar-fixed">
			<div id="sidebar-content">									

			</div>
			<div id="divider" class="resizeable"></div>
		</div>
		<!-- /Sidebar -->

		<div id="content">
			<div class="container">

				<!-- Breadcrumbs line -->
				<div class="crumbs">
					<ul id="breadcrumbs" class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="{{@Config::get('app.url')}}/user/home">Home</a>
						</li>
					</ul>

					<ul class="crumb-buttons">
						@if (isset($contract_role))
							<li class="dropdown">
								<a href="#" title="" data-toggle="dropdown">
									<i class="icon-usd"></i><span>Hợp đồng</strong></span></i>
								</a>
								<ul class="dropdown-menu pull-right">
									@if ($contract_role=='pm')
										<li><a href="{{@Config::get('app.url')}}/user/contract/member/list" title=""></i>Quản lý thành viên</a></li>
										<li class="divider"></li>
										<li><a href="{{@Config::get('app.url')}}/user/contract/expiration/list" title=""></i>Nhắc gia hạn</a></li>
									@endif	
									<li><a href="{{@Config::get('app.url')}}/user/contract/list/list" title=""></i>Danh sách hợp đồng</a></li>
								</ul>
							</li>
						@endif

						@if ($pa05role=='pm' || $pa05role=='edit')
							<li class="dropdown">
								<a href="#" title="" data-toggle="dropdown">
									<i class="icon-list-alt"></i><span>Hàng hóa</strong></span><i class="icon-angle-down left-padding"></i>
								</a>
								<ul class="dropdown-menu pull-right">
									<li><a href="{{@Config::get('app.url')}}/user/general/group/list" title=""></i>Chủng loại</a></li>
									<li><a href="{{@Config::get('app.url')}}/user/general/filter/list" title=""></i>Bộ lọc</a></li>
									<li class="divider"></li>
									<li><a href="{{@Config::get('app.url')}}/user/general/product/list" title=""></i>Sản phẩm</a></li>
								</ul>
							</li>
						@endif

						@if ($pa05role!='')
							<li class="dropdown"><a href="#" title="" data-toggle="dropdown"><i class="icon-list-alt"></i><span>PA05</strong></span><i class="icon-angle-down left-padding"></i></a>
								<ul class="dropdown-menu pull-right">
									@if ($pa05role=='pm')
										<li><a href="{{@Config::get('app.url')}}/user/pa05/member/list" title=""></i>Quản lý thành viên</a></li>
									@endif

									@if ($pa05role=='pm' || $pa05role=='edit')
										<li>
											<a href="{{@Config::get('app.url')}}/user/pa05/category/list" title=""></i>Danh mục dùng chung</a>
										</li>
										<li class="divider"></li>
									@endif

									<li><a href="{{@Config::get('app.url')}}/user/pa05/region/list" title=""></i>Danh mục PA05 các tỉnh</a></li>
								</ul>
							</li>
						@endif

					</ul>
				</div>
				<!-- /Breadcrumbs line -->
				
				@section('content')
				@show

			</div>
			<!-- /.container -->

		</div>
	</div>

</body>
</html>