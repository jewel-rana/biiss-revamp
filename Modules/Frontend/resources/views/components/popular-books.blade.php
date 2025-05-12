<div>
    <!-- Popular Books Collection -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title">Popular Books</h2>
                <a href="{{ route('front.allBooks') }}" class="view-all">View all</a>
            </div>
            <div class="row g-4">
                @if( $books->count() > 0 )
                    @foreach( $books as $book )
                        <x-frontend::book-card :book="$book"></x-frontend::book-card>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
</div>
