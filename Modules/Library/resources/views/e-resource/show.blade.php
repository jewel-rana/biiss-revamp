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
                if ($item->cover_photo != null){ ?>
                <img src="{{ asset( $item->cover_photo ) }}" alt="{{ $item->title }}"
                     class="img-fluid rounded shadow book-details-image">
                <?php } else { ?>
                <img src="{{ asset('default/cover/' . strtolower( $item->type . '.jpg')) }}" alt="book"
                     class="img-fluid rounded shadow book-details-image">
                <?php } ?>
            </div>

            <!-- Book Properties -->
            <div class="col-md-8">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h2 class="fw-bold text-primary">
                            {{ $item->title }}
                            @if( $item->volume_number != null )
                                [{{ $item->volume_number }}]
                            @endif
                        </h2>
                        <h5 class="text-secondary">by
                            @if( $item->authors )
                                @foreach( $item->authors as $key => $author )
                                    <span class="badge badge-success bg-info">{{ $author['author_name'] }}</span>
                                @endforeach
                            @endif
                            {{--                            <span class="fw-semibold">Author Name</span>--}}
                        </h5>
                    </div>
                    @if($item->file)
                        <a href="{{ route('library.reader', [$item->type, $item->id]) }}"
                           class="hover-effect p-2 rounded">
                            <img src="/frontend/images/pdf-svgrepo-com.svg" width="80" height="80" class="img-fluid"
                                 style="min-width: 80px !important;"
                                 alt="Read e-Resource">
                            <p>Read e-{{ ucfirst($item->type) }}</p>
                        </a>
                    @endif
                </div>

                <ul class="list-group list-group-flush mt-4">
                    <li class="list-group-item"><strong>Genre:</strong> {{ ucfirst( $item->type ) }}</li>
                    <li class="list-group-item"><strong>Publisher:</strong> {{ $item->publisher }}
                        - {{ $item->publication_year }}</li>
                    <li class="list-group-item"><strong>Subjects:</strong>
                        <ul>
                            @if( $item->authors )
                                @foreach( $item->authors as $tag )
                                    @if($tag->auth_subject)
                                        <li><p>{{ $tag->auth_subject }}</p></li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    @if( in_array( strtolower( $item->type ), array('document', 'magazine', 'journal') ) )
                        <li class="list-group-item"><strong>Month of Publish:</strong> {{ $item->month_of_publish }}
                        </li>
                        <li class="list-group-item"><strong>Year of Publish:</strong> {{ $item->publication_year }}</li>
                        <li class="list-group-item"><strong>Date of Publish:</strong> {{ $item->month_of_publication }}
                        </li>
                        <li class="list-group-item"><strong>Volume Number:</strong> {{ $item->volume_number }}</li>
                        <li class="list-group-item"><strong>Copy Number:</strong> {{ $item->item_number }}</li>
                        <li class="list-group-item"><strong>Season:</strong> {{ $item->season }}</li>

                    @elseif( strtolower( $item->type ) == 'book')
                        <li class="list-group-item"><strong>Call No. (AUMARK):</strong> {{ $item->call_number }}</li>
                        <li class="list-group-item"><strong>Author Mark:</strong> {{ $item->authormark }}</li>
                        <li class="list-group-item"><strong>Accession Number(ACC):</strong> {{ $item->acc_number }}</li>

                        {{--                        @php--}}
                        {{--                            $available = 0;--}}
                        {{--                            if( $item->copies ) :--}}
                        {{--                                foreach( $item->copies as $copy ) :--}}
                        {{--                                    if( $copy->issued == 0 ) :--}}
                        {{--                                        $available = 1;--}}
                        {{--                                    endif;--}}
                        {{--                                endforeach;--}}
                        {{--                            endif;--}}
                        {{--                        @endphp--}}
                        {{--                        @if( $available )--}}
                        {{--                            @php--}}
                        {{--                                $author = '';--}}
                        {{--                                if( $item->authors ) :--}}
                        {{--                                    $count = ( int ) count( $item->authors ) - 1;--}}
                        {{--                                    foreach( $item->authors as $key => $a ) :--}}
                        {{--                                        $author .= ( $count == $key ) ? $a['author_name'] . ', ' : $a['author_name'];--}}
                        {{--                                    endforeach;--}}
                        {{--                                endif;--}}

                        {{--                            @endphp--}}
                        {{--                            <form action="{{ url('/print') }}" method="POST" class="side-by-side">--}}
                        {{--                                {!! csrf_field() !!}--}}
                        {{--                                <input type="hidden" name="id" value="{{ $item->id }}">--}}
                        {{--                                <input type="hidden" name="title" value="{{ $item->title }}">--}}
                        {{--                                <input type="hidden" name="author" value="{{ $author }}">--}}
                        {{--                                <input type="hidden" name="type" value="{{ $item->type }}">--}}
                        {{--                                <button class="btn btn-warning" type="submit">Add to wishlist--}}
                        {{--                                </button>--}}
                        {{--                            </form>--}}
                        {{--                        @endif--}}
                    @endif
                </ul>

            </div>
        </div>

        @if($item->bibliography)
            <!-- Description -->
            <div class="row mt-5">
                <div class="col">
                    <h4 class="fw-bold px-lg-0 px-1">Bibliography</h4>
                    <p class="fullTextReading hide">
                        {{ $item->bibliography }}
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
