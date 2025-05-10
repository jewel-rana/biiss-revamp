@extends("{$theme['frontend']}::layouts.master")

@section('header')

@endsection

@section('content')
    <!-- Book Details Section -->
    <div class="container py-5">
        <div class="row g-4">
            <!-- Book Image -->
            <div class="col-md-4 text-center">
                <img src="/frontend/images/two.jpg" alt="Book Cover" class="img-fluid rounded shadow book-details-image">
            </div>

            <!-- Book Properties -->
            <div class="col-md-8">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h2 class="fw-bold text-primary">Book Title Here</h2>
                        <h5 class="text-secondary">by <span class="fw-semibold">Author Name</span></h5>
                    </div>
                    <a href="#" class="hover-effect p-2 rounded">
                        <img src="/frontend/images/pdf-svgrepo-com.svg" width="80" height="80" class="img-fluid" alt="PDF Icon">
                    </a>
                </div>

                <ul class="list-group list-group-flush mt-4">
                    <li class="list-group-item"><strong>Genre:</strong> Fiction</li>
                    <li class="list-group-item"><strong>Published:</strong> 2023</li>
                    <li class="list-group-item"><strong>ISBN:</strong> 123-4567890123</li>
                    <li class="list-group-item"><strong>Price:</strong> $19.99</li>
                </ul>

            </div>
        </div>

        <!-- Description -->
        <div class="row mt-5">
            <div class="col">
                <h4 class="fw-bold px-lg-0 px-1">Description</h4>
                <p class="text-muted text-justify px-lg-0 px-1">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, illo! Nostrum repellendus minus
                    maxime velit iste ut, non obcaecati! Dicta quae ipsam omnis magnam reprehenderit, quas doloremque
                    perspiciatis ratione nesciunt quia molestias, pariatur expedita voluptate quo? Totam impedit magni
                    earum magnam consequuntur corporis pariatur quas eius ab voluptate accusantium quia, officiis
                    debitis nisi voluptas exercitationem atque, tenetur ipsum numquam nam fuga? Possimus fugit a
                    laudantium quisquam ipsum at repellat doloribus nam, ducimus fugiat qui eligendi blanditiis, magnam
                    unde iure impedit reiciendis est nulla. Ipsa consequatur voluptate beatae quisquam cupiditate
                    quibusdam laboriosam nisi culpa, doloribus minus autem nostrum numquam architecto expedita!
                </p>
            </div>
        </div>
    </div>

    <div class="pageContent pt-4" style="padding: 45px 0;">
        <div class="container mt-5">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="single_book_title">
                        <h3>{{ $book->title }}</h3>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 single_thumbonail">
                    <div class="thumbnail">
                        <?php
                        if ($book->cover_photo != null){ ?>
                        <img src="{{ asset( $book->cover_photo ) }}" alt="{{ $book->title }}">
                        <?php } else { ?>
                        <img src="{{ asset('default/cover/' . strtolower( $book->type . '.jpg')) }}" alt="book">
                        <?php } ?>
                        @if( Auth::user() )
                            <a href="{{ url('dashboard/library/edit/' . $book->id . '/?type=' . $book->type) }}"
                               style="border: 1px solid #ddd;padding: 4px 28px;">Edit</a>
                        @endif
                        @if( $book->file )
                            <a href="{{ asset( $book->file ) }}" class="btn btn-success btn-block btn-lg"
                               style="margin:15px auto;">Download e-book</a>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div class="add_to_card_section">
                        <div class="details">
                            <table class="table table-bordered table-striped table-condensed">
                                <tr>
                                    <th>Title</th>
                                    <td> : {{ $book->title }} @if( $book->volume_number != null )
                                            [{{ $book->volume_number }}]
                                        @endif</td>
                                </tr>
                                <tr>
                                    <th>Author</th>
                                    <td> :
                                        @if( $book->authors )
                                            @foreach( $book->authors as $key => $author )
                                                <span
                                                    class="badge badge-success bg-info">{{ $author['author_name'] }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td> : {{ ucfirst( $book->type ) }}</td>
                                </tr>
                                <tr>
                                    <th>Publisher</th>
                                    <td> : {{ $book->publisher }} - {{ $book->publication_year }}</td>
                                </tr>
                                <tr>
                                    <th>Subjects</th>
                                    <td>
                                        <ul>
                                            @if( $book->authors )
                                                @foreach( $book->authors as $tag )
                                                    <li>
                                                        <p>{{ $tag->auth_subject }}</p>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                                @if( in_array( strtolower( $book->type ), array('document', 'magazine', 'journal') ) )
                                    <tr>
                                        <th>Month</th>
                                        <td>{{ $book->month_of_publish }}</td>
                                    </tr>
                                    <tr>
                                        <th>Year</th>
                                        <td>{{ $book->publication_year }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Publication</th>
                                        <td>{{ $book->month_of_publication }}</td>
                                    </tr>
                                    <tr>
                                        <th>Volume</th>
                                        <td>{{ $book->volume_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Number</th>
                                        <td>{{ $book->item_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Season</th>
                                        <td>{{ $book->season }}</td>
                                    </tr>
                                    <tr>
                                        <th>Articles</th>
                                        <td>
                                            <ul>
                                                @if( $book->authors )
                                                    @foreach( $book->authors as $author )
                                                        <li>
                                                            <p>{{ $author->author_article }}</p>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                @elseif( strtolower( $book->type ) == 'book')
                                    <tr>
                                        <th>Call No. (AUMARK)</th>
                                        <td> : {{ $book->call_number }} ({{ $book->authormark }})</td>
                                    </tr>
                                    <tr>
                                        <th>ACCNO</th>
                                        <td> : {{ $book->acc_number }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="readMoreParent"><strong>Bibliography : </strong>
                                                {{ strpos(strip_tags($book->bibliography), 50) }}
                                                @if (strlen(strip_tags($book->bibliography)) > 50)
                                                    ...
                                                    <button class="btn btn-info btn-sm readMore">Read More</button>
                                                @endif
                                            </p>
                                            <p class="fullTextReading hide"><strong>Bibliography : </strong>
                                                {{ $book->bibliography }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            @php
                                                $available = 0;
                                                if( $book->copies ) :
                                                    foreach( $book->copies as $copy ) :
                                                        if( $copy->issued == 0 ) :
                                                            $available = 1;
                                                        endif;
                                                    endforeach;
                                                endif;
                                            @endphp
                                            @if( $available )
                                                @php
                                                    $author = '';
                                                    if( $book->authors ) :
                                                        $count = ( int ) count( $book->authors ) - 1;
                                                        foreach( $book->authors as $key => $a ) :
                                                            $author .= ( $count == $key ) ? $a['author_name'] . ', ' : $a['author_name'];
                                                        endforeach;
                                                    endif;

                                                @endphp
                                                <form action="{{ url('/print') }}" method="POST" class="side-by-side">
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="id" value="{{ $book->id }}">
                                                    <input type="hidden" name="title" value="{{ $book->title }}">
                                                    <input type="hidden" name="author" value="{{ $author }}">
                                                    <input type="hidden" name="type" value="{{ $book->type }}">
                                                    <button class="btn btn-warning" type="submit">Add to wishlist
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
