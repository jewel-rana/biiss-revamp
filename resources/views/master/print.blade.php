<!DOCTYPE html>
<html>
<head>
	<title>{{ $title }}</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/print.css') }}">
</head>
<body>
	<page size="A4">
		@yield('content')
	</page>
</body>
<script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!--yield own js -->
@yield('ownjs')
</html>