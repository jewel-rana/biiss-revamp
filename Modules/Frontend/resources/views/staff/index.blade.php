@extends("{$theme['frontend']}::layouts.master")

@section('header')
    <style>
        .staff-card{ transition:transform .15s ease, box-shadow .15s ease; height:100%;}
        .staff-card:hover{ transform:translateY(-2px); box-shadow:0 .5rem 1rem rgba(0,0,0,.10); }
        .staff-photo{ aspect-ratio:1/1; object-fit:cover; width:100%; }
        .staff-title{ font-size:.95rem; color:#475569; }
        .badge-dept{ background:#eff6ff; color:#1d4ed8; }
    </style>
@endsection

@section('content')
    @php
        // Static staff data
        $staff = [
            [
                'name' => 'Major General Md Shaheenul Haque, ndc, psc',
                'designation' => 'Director General',
                'department' => 'Administration',
                'photo' => asset('default/staff/shaheenul.jpg'),
                'email' => 'dg@biiss.org',
                'phone' => '+8802-222288491',
                'profile_url' => 'https://biiss.org/view-page/54',
            ],
            [
                'name' => 'MD. Emdadul Islam',
                'designation' => 'Library Officer',
                'department' => 'Library',
                'photo' => asset('default/staff/emdad.jpg'),
                'email' => 'emdad@biiss.org',
                'phone' => '+8802-222288492',
                'profile_url' => 'https://biiss.org/view-page/54',
            ],
            [
                'name' => 'MD. Nazmul Ahsan',
                'designation' => 'Cataloger',
                'department' => 'Library',
                'photo' => asset('default/staff/nazmul.jpg'),
                'email' => 'nazmul@biiss.org',
                'phone' => '+8802-222288490',
                'profile_url' => 'https://biiss.org/view-page/54',
            ],
            [
                'name' => 'MD. Mr...',
                'designation' => 'Library Officer',
                'department' => 'Library',
                'photo' => asset('default/staff/shamsul.jpg'),
                'email' => 'shamsul@biiss.org',
                'phone' => '+8802-222288493',
                'profile_url' => 'https://biiss.org/view-page/54',
            ],
        ];
    @endphp

    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">{{ $title ?? 'Library Staff' }}</h2>
            </div>

            <div class="row g-4">
                @foreach($staff as $person)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card staff-card">
                            <img src="{{ $person['photo'] ?? asset('images/placeholders/staff.png') }}"
                                 alt="{{ $person['name'] }}"
                                 class="staff-photo card-img-top"
                                 onerror="this.src='{{ asset('images/placeholders/staff.png') }}'">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1">{{ $person['name'] }}</h5>
                                <div class="staff-title mb-2">{{ $person['designation'] }}</div>

                                @if(!empty($person['department']))
                                    <span class="badge badge-dept mb-3">{{ $person['department'] }}</span>
                                @endif

                                <ul class="list-unstyled small mb-3">
                                    @if(!empty($person['email']))
                                        <li class="mb-1">
                                            <i class="bi bi-envelope me-1"></i>
                                            <a href="mailto:{{ $person['email'] }}">{{ $person['email'] }}</a>
                                        </li>
                                    @endif
                                    @if(!empty($person['phone']))
                                        <li class="mb-1">
                                            <i class="bi bi-telephone me-1"></i>
                                            <a href="tel:{{ preg_replace('/\s+/', '', $person['phone']) }}">{{ $person['phone'] }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('footer')
@endsection
