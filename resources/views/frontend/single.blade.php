@extends("{$theme['frontend']}::layouts.master")

@section('header')

@endsection

@section('content')
    <!-- Book Details Section -->
    <div class="container py-5">
        <div class="row g-4">
            <!-- Book Image -->
            <div class="col-md-4 text-center">
                <?php
                if ($book->cover_photo != null){ ?>
                <img src="{{ asset( $book->cover_photo ) }}" alt="{{ $book->title }}"
                     class="img-fluid rounded shadow book-details-image">
                <?php } else { ?>
                <img src="{{ asset('default/cover/' . strtolower( $book->type . '.jpg')) }}" alt="book"
                     class="img-fluid rounded shadow book-details-image">
                <?php } ?>
            </div>

            <!-- Book Properties -->
            <div class="col-md-8">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h2 class="fw-bold text-primary">
                            {{ $book->title }}
                            @if( $book->volume_number != null )
                                [{{ $book->volume_number }}]
                            @endif
                        </h2>
                        <h5 class="text-secondary">by
                            @if( $book->authors )
                                @foreach( $book->authors as $key => $author )
                                    <span class="badge badge-success bg-info">{{ $author['author_name'] }}</span>
                                @endforeach
                            @endif
                            {{--                            <span class="fw-semibold">Author Name</span>--}}
                        </h5>
                    </div>
                    @if($book->file)
                        <a href="{{ route('library.reader', [$book->type, $book->id]) }}"
                           class="hover-effect p-2 rounded">
                            <img src="/frontend/images/pdf-svgrepo-com.svg" width="80" height="80" class="img-fluid"
                                 style="min-width: 80px !important;"
                                 alt="Read e-Resource">
                            <p>Read e-{{ ucfirst($book->type) }}</p>
                        </a>
                    @endif
                </div>

                <ul class="list-group list-group-flush mt-4">
                    <li class="list-group-item"><strong>Genre:</strong> {{ ucfirst( $book->type ) }}</li>
                    <li class="list-group-item"><strong>Publisher:</strong> {{ $book->publisher }}
                        - {{ $book->publication_year }}</li>
                    <li class="list-group-item"><strong>Subjects:</strong>
                        <ul>
                            @if( $book->authors )
                                @foreach( $book->authors as $tag )
                                    @if($tag->auth_subject)
                                        <li><p>{{ $tag->auth_subject }}</p></li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    @if( in_array( strtolower( $book->type ), array('document', 'magazine', 'journal') ) )
                        <li class="list-group-item"><strong>Month of Publish:</strong> {{ $book->month_of_publish }}
                        </li>
                        <li class="list-group-item"><strong>Year of Publish:</strong> {{ $book->publication_year }}</li>
                        <li class="list-group-item"><strong>Date of Publish:</strong> {{ $book->month_of_publication }}
                        </li>
                        <li class="list-group-item"><strong>Volume Number:</strong> {{ $book->volume_number }}</li>
                        <li class="list-group-item"><strong>Copy Number:</strong> {{ $book->item_number }}</li>
                        <li class="list-group-item"><strong>Season:</strong> {{ $book->season }}</li>

                    @elseif( strtolower( $book->type ) == 'book')
                        <li class="list-group-item"><strong>Call No. (AUMARK):</strong> {{ $book->call_number }}</li>
                        <li class="list-group-item"><strong>Author Mark:</strong> {{ $book->authormark }}</li>
                        <li class="list-group-item"><strong>Accession Number(ACC):</strong> {{ $book->acc_number }}</li>

                        {{--                        @php--}}
                        {{--                            $available = 0;--}}
                        {{--                            if( $book->copies ) :--}}
                        {{--                                foreach( $book->copies as $copy ) :--}}
                        {{--                                    if( $copy->issued == 0 ) :--}}
                        {{--                                        $available = 1;--}}
                        {{--                                    endif;--}}
                        {{--                                endforeach;--}}
                        {{--                            endif;--}}
                        {{--                        @endphp--}}
                        {{--                        @if( $available )--}}
                        {{--                            @php--}}
                        {{--                                $author = '';--}}
                        {{--                                if( $book->authors ) :--}}
                        {{--                                    $count = ( int ) count( $book->authors ) - 1;--}}
                        {{--                                    foreach( $book->authors as $key => $a ) :--}}
                        {{--                                        $author .= ( $count == $key ) ? $a['author_name'] . ', ' : $a['author_name'];--}}
                        {{--                                    endforeach;--}}
                        {{--                                endif;--}}

                        {{--                            @endphp--}}
                        {{--                            <form action="{{ url('/print') }}" method="POST" class="side-by-side">--}}
                        {{--                                {!! csrf_field() !!}--}}
                        {{--                                <input type="hidden" name="id" value="{{ $book->id }}">--}}
                        {{--                                <input type="hidden" name="title" value="{{ $book->title }}">--}}
                        {{--                                <input type="hidden" name="author" value="{{ $author }}">--}}
                        {{--                                <input type="hidden" name="type" value="{{ $book->type }}">--}}
                        {{--                                <button class="btn btn-warning" type="submit">Add to wishlist--}}
                        {{--                                </button>--}}
                        {{--                            </form>--}}
                        {{--                        @endif--}}
                    @endif
                </ul>

            </div>
        </div>

        @if($book->bibliography)
            <!-- Description -->
            <div class="row mt-5">
                <div class="col">
                    <h4 class="fw-bold px-lg-0 px-1">Bibliography</h4>
                    <p class="fullTextReading hide">
                        {{ $book->bibliography }}
                    </p>
                </div>
            </div>
        @endif
    </div>

@endsection

@section('footer')

    <script type="text/javascript">
        jQuery(function ($) {
            $('.readMore').on("click", function (e) {
                var parent = $(this).parents('.readMoreParent');
                var parentOfParent = $(this).parents('.details');

                $(parent).hide();

                $(parentOfParent).find('.fullTextReading').removeClass('hide');

            });
        });
    </script>
@endsection
