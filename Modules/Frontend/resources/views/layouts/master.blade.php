<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'BIISS Library') }}</title>
    <link rel="icon" href="/default/favicon.ico" type="image/x-icon">

    <!-- Include Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/frontend/css/style.css">

    <!-- font-family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- owl-carousel-css-link -->
    <link rel="stylesheet" href="/frontend/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="/frontend/owlcarousel/owl.theme.default.min.css">
    <link rel="stylesheet" href="/frontend/css/custom.css">

    @yield('header')
</head>

<body>
<!-- Header Section -->
<header class="sticky-top">
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/frontend/images/logo.png" alt="BIISS" height="40">
            </a>
            <!-- Search -->
            <div class="position-relative d-none d-lg-block">
                <!-- <div class="position-relative w-100">
                    <input type="search" class="form-control ps-5 search-input-header"
                        placeholder="Bangladesh Institute of International and Strategic Studies (BIISS)">
                </div> -->
                <h4 class="font-poppins">Bangladesh Institute of International and Strategic Studies (BIISS)</h4>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-primary" style=" color: #5592CB; border-color: #5592CB;">
                        <i class="fa fa-heart"></i> (0)
                    </a>
                    @if(auth()->guest())

                        <a href="{{ route('auth.login') }}" class="btn"
                           style="background-color: #5592CB; color: #FFFFFF;">Login</a>
                    @else
                        <!-- Profile Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle d-flex align-items-center profileButton" type="button"
                                    id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i> <!-- Bootstrap Icons user icon -->
                                <span>{{ ucwords(auth()->user()->name ?? '') }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="{{ route('auth.profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('auth.change-password') }}">Change
                                        Password</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('auth.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-default btn-block dropdown-item"
                                                style="border-radius: initial; background: none; color: darkred"
                                        >
                                            <i class="fa fa-sign-out-alt"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <x-frontend::top-nav></x-frontend::top-nav>
</header>

@if(!request()->routeIs(['front.search', 'single.show', 'e-book.show', 'e-document.show', 'e-journal.show', 'library.reader']))
    <x-frontend::hero></x-frontend::hero>
@endif

@yield('content')

@if(!request()->routeIs(['library.reader']))
    <!-- Footer Section -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <img src="/frontend/images/logo.png" alt="BIISS" class="mb-4" height="60">
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled mb-2">
                        <li class="mb-2"><a href="/">Home</a></li>
                        <li class="mb-2"><a href="{{ route('front.newBooks') }}">New Books</a></li>
                        <li class="mb-2"><a href="{{ route('front.allBooks') }}">Books</a></li>
                        <li class="mb-2"><a href="{{ route('front.journals') }}">Journals</a></li>
                        <li class="mb-2"><a href="{{ route('front.magazines') }}">Magazines</a></li>
                        <li class="mb-2"><a href="{{ route('front.documents') }}">Documents</a></li>
                        <li class="mb-2"><a href="{{ route('front.seminars') }}">Seminar Proceeding</a></li>
                        <li class="mb-2"><a href="/contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Services</h5>
                    <ul class="list-unstyled mb-2">
                        <li class="mb-2"><a href="#">Payment Methods</a></li>
                        <li class="mb-2"><a href="#">Money-back</a></li>
                        <li class="mb-2"><a href="#">Shipping</a></li>
                        <li class="mb-2"><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Social</h5>
                    <ul class="list-unstyled mb-2">
                        <li class="mb-2"><a href="#" class="text-decoration-underline">Facebook</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-underline">Instagram</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-underline">Twitter</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-underline">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-top pt-4 mt-4 d-flex justify-content-between align-items-center">
                <p class="mb-0 text-center">All Rights Reserved <span id="current-year"></span> | BIISS</p>
                <p class="mb-0 text-center text-decoration-underline">Terms & Conditions</p>
            </div>
        </div>
    </footer>
@endif
<script src="/frontend/js/jquery-3.7.1.min.js"></script>
<script src="/frontend/owlcarousel/owl.carousel.min.js"></script>
<script src="/frontend/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>

@yield('footer')
</body>

</html>
