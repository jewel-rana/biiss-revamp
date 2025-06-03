<div>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5592CB; color: #FFFFFF;">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto item-center">
                    <li class="nav-item px-1">
                        <a class="nav-link {{ $theme['current_path'] == '/' ? 'active bg-white text-dark rounded-pill' : 'text-white' }} px-3 my-1 font-weight-bold"
                           href="/">Home</a>
                    </li>
                    <li class="nav-item px-1">
                        <a class="nav-link {{ $theme['current_path'] == 'new-books' ? 'active bg-white text-dark rounded-pill' : 'text-white' }} font-weight-bold px-3 my-1"
                           href="{{ route('front.newBooks') }}">New Books</a>
                    </li>
                    <li class="nav-item px-1">
                        <a class="nav-link {{ $theme['current_path'] == 'all-books' ? 'active bg-white text-dark rounded-pill' : 'text-white' }} font-weight-bold px-3 my-1"
                           href="{{ route('front.allBooks') }}">Books</a>
                    </li>
                    <li class="nav-item px-1">
                        <a class="nav-link {{ $theme['current_path'] == 'journals' ? 'active bg-white text-dark rounded-pill' : 'text-white' }} font-weight-bold px-3 my-1"
                           href="{{ route('front.journals') }}">Journals</a>
                    </li>
                    <li class="nav-item px-1">
                        <a class="nav-link {{ $theme['current_path'] == 'magazines' ? 'active bg-white text-dark rounded-pill' : 'text-white' }} font-weight-bold px-3 my-1"
                           href="{{ route('front.magazines') }}">Magazines</a>
                    </li>
                    <li class="nav-item px-1">
                        <a class="nav-link {{ $theme['current_path'] == 'documents' ? 'active bg-white text-dark rounded-pill' : 'text-white' }} font-weight-bold px-3 my-1"
                           href="{{ route('front.documents') }}">Documents</a>
                    </li>
                    <li class="nav-item px-1">
                        <a class="nav-link {{ $theme['current_path'] == 'seminars' ? 'active bg-white text-dark rounded-pill' : 'text-white' }} font-weight-bold px-3 my-1"
                           href="{{ route('front.seminars') }}">Seminar Proceeding</a>
                    </li>
                    <li class="nav-item px-1 dropdown active">
                        <a class="nav-link dropdown-toggle text-white font-weight-bold px-3 my-1 activeb" href="#"
                           id="navbarDropdownMenuLink" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            e-Resources
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item {{ $theme['current_path'] == 'e-resource/e-book' ? 'active' : '' }}" href="{{ route('e-book') }}">e-Books</a></li>
                            <li><a class="dropdown-item {{ $theme['current_path'] == 'e-resource/e-document' ? 'active' : '' }}"
                                   href="{{ route('e-document') }}">e-Documents</a></li>
                            <li><a class="dropdown-item {{ $theme['current_path'] == 'e-resource/e-journal' ? 'active' : '' }}" href="{{ route('e-journal') }}">e-Journals</a></li>
                        </ul>
                    </li>
                    {{--                    <li class="nav-item px-1">--}}
                    {{--                        <a class="nav-link {{ $theme['current_path'] == '/' ? 'active bg-white text-dark rounded-pill' : 'text-white' }} font-weight-bold px-3 my-1" href="{{ route('front.contact') }}">Contact</a>--}}
                    {{--                    </li>--}}
                </ul>
            </div>
        </div>
    </nav>
</div>
