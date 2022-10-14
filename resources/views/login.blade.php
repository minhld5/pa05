<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>{{$systemconfig->system_name}}</title>
    <link rel="shortcut icon" href="{{@Config::get('app.url')}}/favicon.ico" type="image/x-icon" />

    <!--=== CSS ===-->

    <!-- Bootstrap -->
    <link href="{{@Config::get('app.url')}}/melon/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme -->
    <link href="{{@Config::get('app.url')}}/melon/assets/css/main.css" rel="stylesheet" type="text/css" />
    <link href="{{@Config::get('app.url')}}/melon/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="{{@Config::get('app.url')}}/melon/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="{{@Config::get('app.url')}}/melon/assets/css/icons.css" rel="stylesheet" type="text/css" />

    <!-- Login -->
    <link href="{{@Config::get('app.url')}}/melon/assets/css/login.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{@Config::get('app.url')}}/melon/assets/css/fontawesome/font-awesome.min.css">
    <!--[if IE 7]>
        <link rel="stylesheet" href="assets/css/fontawesome/font-awesome-ie7.min.css">
    <![endif]-->

    <!--[if IE 8]>
        <link href="assets/css/ie8.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

    <!--=== JavaScript ===-->
</head>

<body class="login">
    <!-- Logo -->
    <div style="height:20px;"></div>
    <div class="logo">
        <img src="logo.png" alt="logo" style="width:35px;"/>
        <strong>{{@@$systemconfig->system_name}}</strong>
    </div>
    <!-- /Logo -->

    <!-- Login Box -->
    <div class="box">
        <div class="content">
            <!-- Login Formular -->
            <form class="form-vertical login-form" action="doLogin" method="post">
                {{csrf_field()}}
                <!-- Title -->
                <h3 class="form-title">ĐĂNG NHẬP VÀO HỆ THỐNG</h3>

                <!-- Error Message -->
                @if ($err_msg !='')
                <div class="alert fade in alert-danger" style="display: yes;">
                    <i class="icon-remove close" data-dismiss="alert"></i>
                    {{$err_msg}}
                </div>
                @endif

                <!-- Input Fields -->
                <div class="form-group">
                    <!--<label for="username">Username:</label>-->
                    <div class="input-icon">
                        <i class="icon-user"></i>
                        <input type="text" name="username" class="form-control" placeholder="Username" autofocus="autofocus" required/>
                    </div>
                </div>
                <div class="form-group">
                    <!--<label for="password">Password:</label>-->
                    <div class="input-icon">
                        <i class="icon-lock"></i>
                        <input type="password" name="password" class="form-control" placeholder="Password" data-rule-required="true" data-msg-required="Please enter your password." required />
                    </div>
                </div>
                <!-- /Input Fields -->

                <!-- Form Actions -->
                <div class="form-actions">
                    <label class="checkbox pull-left"><input type="checkbox" class="uniform" name="remember"> Remember me</label>
                    <button type="submit" class="submit btn btn-primary pull-right">
                        ĐĂNG NHẬP <i class="icon-angle-right"></i>
                    </button>
                </div>
            </form>
            <!-- /Login Formular -->

            
        </div> <!-- /.content -->

        
    </div>
    <!-- /Login Box -->
    
</body>
</html>