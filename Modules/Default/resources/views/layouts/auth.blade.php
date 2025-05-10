<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v4.2/admin/html/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Sep 2018 08:22:04 GMT -->
<head>
    <meta charset="utf-8" />
    <title>BIISS | Login</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap/4.1.3/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/animate/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/css/default/style.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/css/default/style-responsive.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/css/default/theme/default.css') }}" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/pace/pace.min.js') }}"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top">
<!-- begin #page-loader -->
<div id="page-loader" class="fade show"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin login -->
    <div class="login bg-black animated fadeInDown">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                {{-- <span class="logo"></span>  --}}<b>BIISS</b> Login
                <small>Please login with your valid credentials.</small>
            </div>
            <div class="icon">
                <i class="fa fa-lock"></i>
            </div>
        </div>
        <!-- end brand -->
        <!-- begin login-content -->
        <div class="login-content">
            @yield('content')
        </div>
        <!-- end login-content -->
    </div>
    <!-- end login -->
</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap/4.1.3/js/bootstrap.bundle.min.js') }}"></script>
<!--[if lt IE 9]>
		<script src="{{ asset('backend/color-admin-v4.2/admin/assets/crossbrowserjs/html5shiv.js') }}"></script>
		<script src="{{ asset('backend/color-admin-v4.2/admin/assets/crossbrowserjs/respond.min.js') }}"></script>
		<script src="{{ asset('backend/color-admin-v4.2/admin/assets/crossbrowserjs/excanvas.min.js') }}"></script>
	<![endif]-->
<script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('backend/color-admin-v4.2/admin/assets/js/theme/default.min.js') }}"></script>
<script src="{{ asset('backend/color-admin-v4.2/admin/assets/js/apps.min.js') }}"></script>
<!-- ================== END BASE JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
    });
</script>

</body>

</html>
