@extends("{$theme['frontend']}::layouts.master")

@section('header')

@endsection

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title">{{ $title ?? 'New Books' }}</h2>
            </div>
            <div class="row g-4">
                @if($books->count() > 0)
                    @foreach($books as $book)
                        <x-frontend::book-card :book="$book"></x-frontend::book-card>
                    @endforeach
                @endif

                <nav>
                    {!! $books->links('pagination::bootstrap-5') !!}
                </nav>
            </div>
        </div>
    </section>
@endsection

@section('footer')

@endsection
