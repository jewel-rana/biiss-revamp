<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v4.2/admin/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Sep 2018 08:18:28 GMT -->
<head>
    <meta charset="UTF-8" />
    <title><?php echo ( isset( $pageTitle ) ) ? $pageTitle . ' | BIISS' : 'AdminPanel | BIISS'; ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap/4.1.3/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/css/dataTables.bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/css/buttons.dataTables.min.css') }}"/>

    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/fontawesome/5.3/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/css/default/style.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/css/default/style-responsive.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/css/default/theme/default.css') }}" rel="stylesheet" id="theme" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/custom.css') }}">
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/jquery-jvectormap/jquery-jvectormap.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{ asset('backend/color-admin-v4.2/admin/assets/plugins/pace/pace.min.js') }}"></script>
    <!-- ================== END BASE JS ================== -->

    @yield('owncss')
</head>
<body>
<!-- begin #page-loader -->
<div id="page-loader" class="fade show"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <!-- begin #header -->
    <div id="header" class="header navbar-default">
        <!-- begin navbar-header -->
        <div class="navbar-header">
            {{--				<a href="{{ route('dashboard') }}" class="navbar-brand"><b>BIISS</b> AdminPanel</a>--}}
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- end navbar-header -->

        <!-- begin header-nav -->
        <ul class="navbar-nav navbar-right">
            <li class="dropdown navbar-user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <?php
                    $photo = ( auth()->check() && auth()->user()->avatar != null ) ? asset( 'uploads/profile/'. auth()->user()->avatar ) : asset('default/avatar.png');
                    ?>
                    <img src="{{ $photo }}" alt="" />
                    <span class="d-none d-md-inline"></span> <b class="caret"></b>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ url('/') }}" class="dropdown-item">Visit Site</a>
                    {{-- <a href="{{ url('dashboard/profile') }}" class="dropdown-item">Profile</a> --}}
                    {{-- <a href="{{ url('dashboard/profile/change-password') }}" class="dropdown-item">Change Password</a> --}}
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('logout') }}" class="dropdown-item">Log Out</a>
                </div>
            </li>
        </ul>
        <!-- end header navigation right -->
    </div>
    <!-- end #header -->

    <x-default::sidebar></x-default::sidebar>

    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
{{--        <ol class="breadcrumb pull-right">--}}
{{--            <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>--}}
{{--            <li class="breadcrumb-item active">--}}
{{--                {{ Request::segment(2) }}--}}
{{--            </li>--}}
{{--        </ol>--}}
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">
            @if(isset($pageTitle))
                {{ $pageTitle }}
            @else

            @endif
            <small></small>
        </h1>
        <!-- end page-header -->
        @yield('content')
    </div>
    <!-- end #content -->

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
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
<script type="text/javascript" src="{{  asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>

{{-- Yielded pages special and necessary js --}}
@yield('ownjs')

</body>
</html>
