<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Bangladesh Institute of International and Strategic Studies (BIISS)</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('default/favicon.ico') }}" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('/font-awesome/4.5.0/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/awesomplete/awesomplete.css') }}">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Custom Css -->
    <link href="{{asset('/css/frontend/style.css')}}" rel="stylesheet">
    <style>
        .adminHoverChange button:hover {
            background-color: white !important;
        }

        /* The flip card container - set the width and height to whatever you want. We have added the border property to demonstrate that the flip itself goes out of the box on hover (remove perspective if you don't want the 3D effect */
        .flip-card {
            background-color: transparent;
            width: 100%;
            height: 384px;
            border: 1px solid #f1f1f1;
            perspective: 1000px; /* Remove this if you don't want the 3D effect */
            margin-bottom: 25px;
        }

        /* This container is needed to position the front and back side */
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }

        /* Do an horizontal flip when you move the mouse over the flip box container */
        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        /* Position the front and back side */
        .flip-card-front, .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
        }

        /* Style the front side (fallback if image is missing) */
        .flip-card-front {
            background-color: #bbb;
            color: black;
            overflow: hidden;
        }

        .flip-card-front > .placeholder {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: #0828834d;
            color: #66fc68;
            height: auto;
            overflow: hidden;
            padding: 5px 10px;
            border-top: 3px solid #54c2f5;
        }

        /* Style the back side */
        .flip-card-back {
            background-color: dodgerblue;
            color: white;
            transform: rotateY(180deg);
            padding: 15px;
        }

        .flip-card-back > h1 {
            font-size: 18px;
        }
    </style>
    @yield('owncss')
</head>

<body>


<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand biiss-lago" href="{{ url('/') }}"><img
                    src="{{Request::root()}}/images/biiss-logo.png"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="{{ request()->is('new-books') ? 'active' : '' }}"><a href="{{ url('/new-books') }}">New
                        Books</a></li>
                <li class="{{ request()->is('all-books') ? 'active' : '' }}"><a href="{{ url('/all-books') }}">Books</a>
                </li>
                <li class="{{ request()->is('journals') ? 'active' : '' }}"><a
                        href="{{ url('/journals') }}">Journals</a></li>
                <li class="{{ request()->is('magazines') ? 'active' : '' }}"><a
                        href="{{ url('/magazines') }}">Magazines</a></li>
                <li class="{{ request()->is('documents') ? 'active' : '' }}"><a
                        href="{{ url('/documents') }}">Documents</a></li>
                <li class="{{ request()->is('seminars') ? 'active' : '' }}"><a href="{{ url('/seminars') }}">Seminar
                        Proceeding</a></li>
                <li class="{{ request()->is('contact') ? 'active' : '' }}"><a href="{{ url('/contact') }}">Contact</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                {{--                <li><a href="{{ url('/print') }}">Wishlist ({{ Cart::instance('default')->count(false) }})</a></li>--}}

                @if (Route::has('login'))

                    @if (Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false"> <span class="forcolor"> <i class="fa fa-user"
                                                                                                      aria-hidden="true"></i> {{ Auth::user()->name }} <span
                                        class="caret"></span></span></a>
                            <ul class="dropdown-menu">


                                <li><a href="{{ url('/dashboard') }}"
                                       style="border: medium none;background: #fff; padding-left: 28px;">Admin</a></li>

                                <li><a href="#" class="adminHoverChange">
                                        {{--<i class="material-icons">input</i>--}}

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                              style="float: left;background: #fff;">
                                            {{ csrf_field() }}
                                            <button type="submit" class=""
                                                    style="border: medium none;background: #fff;">Log Out
                                            </button>
                                        </form>

                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ url('/login') }}"><span class="forcolor"><i class="fa fa-user"
                                                                                    aria-hidden="true"></i> Login</span></a>
                        </li>
                    @endif

                @endif


            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<?php
$bannerss = App\Models\Options::where('name', 'banner')->orderBy('id', 'DESC')->limit(3)->get();
?>

<div class="header_slider_area">
    @if( Request::segment(1) != 'single')
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">


                    <?php $i = 0; ?>
                @foreach ($bannerss as $key => $book)

                        <?php if ($i == 0){ ?>
                    <div class="item active">
                        <img src="{{Request::root()}}/uploads/banners/{{ $book->value }}" alt="book">
                        <div class="carousel-caption">
                                <?php $i++; ?>
                        </div>
                    </div>

                    <?php }else{ ?>

                    <div class="item">
                        <img src="{{Request::root()}}/uploads/banners/{{ $book->value }}" alt="book">
                        <div class="carousel-caption">
                                <?php $i++; ?>
                        </div>
                    </div>

                    <?php } ?>

                @endforeach

            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="search_total_section">
            <div class="search_heading">
                <h2>Bangladesh Institute of International and Strategic Studies (BIISS)</h2>
            </div>
            <div class="search_section">
                <form action="/" id="searchForm" method="GET">
                    <div class="form-group">
                        <label for="usr">Search in the Library</label>
                        <div class="input-group input-group-lg">
                            <input type="text" name="search" placeholder="Search by Title, Article, Subjects"
                                   class="form-control" id="librarySuggest">
                            <div class="input-group-addon">
                                <input type="text" name="author" placeholder="Search by Author..." class="form-control"
                                       id="authorSuggest">
                            </div>
                            <div class="input-group-btn">
                                <button class="btn btn-warning" id="globalSearchButton"><i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

<!--
<div class="top_area">
     <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="search_total_section">
                    <div class="search_heading">
                        <h2>Bangladesh Institute of International and Strategic Studies (BIISS)</h2>
                    </div>
                    {{--@yield('content_search')--}}

</div>
</div>
</div>
</div>

</div>-->

<div class="main_contain_area">


    @yield('content')

</div>

<div class="footer_area">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <a href="{{ url('/') }}"><img src="{{Request::root()}}/images/biiss-logo.png" height="60px"></a>
            </div>
        </div>
        <div class="row">


            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="footer_content_left">

                    <p style="padding-top: 20px;">© <?php echo date('Y') ?> BIISS - Bangladesh Institute of
                        International and Strategic Studies.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="footer_content_right">
                    <ul>
                        <li><a href="https://www.facebook.com/onBIISS"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        </li>
                        <li><a href="https://twitter.com/BiissInfo/media"><i class="fa fa-twitter"
                                                                             aria-hidden="true"></i></a></li>
                        <li><a href="https://www.youtube.com/channel/UCo7gBkVSKSGGqzAI06QTvyQ"><i
                                    class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Jquery Core Js -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Bootstrap Core Js -->
<script src="{{asset('/plugins/bootstrap/js/bootstrap.js')}}"></script>

<script type="text/javascript" src="{{ asset('plugins/awesomplete/awesomplete.min.js') }}"></script>
<script type="text/javascript">
    addLoadListener(initAwesomplete);

    function initAwesomplete() {
        var input = document.getElementById("librarySuggest");
        // var awesomplete = new Awesomplete(input);
        var value = input.value;

        var awesomplete = new Awesomplete(input, Awesomplete.FILTER_STARTSWITH);
        input.onkeyup = function (e) {
            var code = (e.keyCode || e.which);

            if (code === 37 || code === 38 || code === 39 || code === 40 || code === 27 || code === 13) {
                return false;
            } else {
                var xhr = getXHR();
                var value = this.value;
                xhr.open("GET", "{{ url('ajax/library/front/suggestions') }}/" + value, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200 || xhr.status == 304) {
                            // response = xhr.responseText; // or xhr.responseXML;
                            var list = JSON.parse(xhr.responseText).map(function (i) {
                                return i;
                            });
                            awesomplete.list = list;
                            awesomplete.data = function (i, input) {
                                return {label: i.level, value: i.value};
                            }
                        }
                    }
                };
                xhr.send();

            }
        }

        input.addEventListener('awesomplete-selectcomplete', function () {

            // var xhr = new XMLHttpRequest();
            // xhr.open('GET', "{{ url('ajax/library/item') }}/" + this.value + "/?type=", true);
            // xhr.onreadystatechange = function()
            // {
            //   if(xhr.readyState == 4){
            //     if(xhr.status == 200 || xhr.status == 304)
            //     {
            //         $('.pagination').hide();
            //         document.getElementById("searchResult").innerHTML = xhr.response;
            //     }
            //   }
            // };
            // xhr.send();
        });
    }

    //carousel
    addLoadListener(initAuthorAwesomplete);

    function initAuthorAwesomplete() {
        var input = document.getElementById("authorSuggest");
        // var awesomplete = new Awesomplete(input);
        var value = input.value;

        var awesomplete = new Awesomplete(input);
        input.onkeyup = function (e) {
            var code = (e.keyCode || e.which);

            if (code === 37 || code === 38 || code === 39 || code === 40 || code === 27 || code === 13) {
                return false;
            } else {

                var xhr = getXHR();
                var value = this.value;
                xhr.open("GET", "{{ url('ajax/library/front/authorsuggestions') }}/" + value, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200 || xhr.status == 304) {
                            // response = xhr.responseText; // or xhr.responseXML;

                            var list = JSON.parse(xhr.responseText).map(function (i) {
                                return i;
                            });
                            awesomplete.list = list;
                            awesomplete.data = function (i, input) {
                                return {label: i.level, value: i.value};
                            }
                        }
                    }
                };
                xhr.send();

            }
        }

        input.addEventListener('awesomplete-selectcomplete', function () {

            // var xhr = new XMLHttpRequest();
            // xhr.open('GET', "{{ url('ajax/library/item') }}/" + this.value + "/?type=", true);
            // xhr.onreadystatechange = function()
            // {
            //   if(xhr.readyState == 4){
            //     if(xhr.status == 200 || xhr.status == 304)
            //     {
            //         $('.pagination').hide();
            //         document.getElementById("searchResult").innerHTML = xhr.response;
            //     }
            //   }
            // };
            // xhr.send();
        });
    }

    function getXHR() {
        //ajax request
        var xhr;
        try {
            xhr = new XMLHttpRequest();
        } catch (error) {
            try {
                xhr = new ActiveXObject('Microsoft.XMLHTTP');
            } catch (error) {
                xhr = null;
            }
        }
        return xhr;
    }

    //Load Listener
    function addLoadListener(fn) {
        if (typeof window.addEventListener != 'undefined') {
            window.addEventListener('load', fn, false);
        } else if (typeof document.addEventListener != 'undefined') {
            document.addEventListener('load', fn, false);
        } else if (typeof window.attachEvent != 'undefined') {
            window.attachEvent('onload', fn);
        } else {
            var oldfn = window.onload;
            if (typeof window.onload != 'function') {
                window.onload = fn;
            } else {
                window.onload = function () {
                    oldfn();
                    fn();
                };
            }
        }
    }
</script>

@yield('ownjs')


</body>

</html>
