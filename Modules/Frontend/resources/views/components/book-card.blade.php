@php use Illuminate\Support\Str; @endphp
<div class="col-12 col-sm-6 col-md-4 col-lg-3">
    <a href="{{ route('single.show', $book->item['id']) }}" class="text-decoration-none"
       title="{{ $book->item['title'] }}">
        <div class="book-card rounded overflow-hidden bg-white text-center">
            @php
                $bookPhoto = ($book->item['cover_photo'])
                    ? asset($book->item['cover_photo'])
                    : asset('/default/cover/' . strtolower($book->item['type']) . '.jpg');
            @endphp
            <img src="{{ $bookPhoto }}" alt="{{ $book->item['title'] }}" class="w-100"/>
            <div class="p-2">
                <div
                    class="card-title text-primary text-truncate">{{ Str::words($book->item['title'], 4, '...') }}</div>
                <div class="card-text text-success">
                    @if(count($book->item['authors']))
                        @foreach($book->item['authors'] as $author)
                            <span class="badge bg-info text-dark">{{ $author->author_name }}</span>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>
