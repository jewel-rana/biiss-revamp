@extends("{$theme['frontend']}::layouts.master")

@section('header')
    <style type="text/css">
        .paginate a {
            padding: 5px 8px;
            margin-right: 2px;
            border: 1px solid #337ab7;
        }
    </style>
@endsection

@section('content')
    <div class="pageContent pt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="new_book">
                        <!-- Set up your HTML -->
                        <h2><span>E-Books</span></h2>
                        <div class="row pt-2">
                            <div class="paginate float-end mb-3">
                                <?php
                                for ($i = 65; $i <= 90; $i++) {
                                    printf('<a href="' . route('front.allBooks', array_merge(request()->query(), array('letter_sort' => chr($i)))) . '" class="myclass">%1$s</a> ', chr($i));
                                } ?>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th style="width:60px;"><i class="fa fa-image"></i></th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Subject</th>
                                    <th>Articles</th>
                                    <th>Year</th>
                                    <th style="width: 60px"><i class="fa fa-file-pdf"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $books as $book )
                                    <tr>
                                        <td>
                                            @if( $book->cover_photo != '' )
                                                <img src="{{ asset($book->cover_photo) }}" class="img-fluid"
                                                     style="width:60px;" alt="">
                                            @else
                                                <img
                                                    src="{{ asset('default/cover/' . strtolower( $book->type ) . '.jpg') }}"
                                                    class="img-fluid" style="width:60px;">
                                            @endif
                                        </td>
                                        <td><a href="{{ route('e-book.show', $book->id ) }}">{{ $book->title }}</a></td>
                                        <td>
                                                <?php
                                                $articles = '';
                                                $subjects = '';
                                                if ($book->authors) :
                                                    foreach ($book->authors as $author) :
                                                        if (!empty($author['author_name'])) {
                                                            echo '<span class="badge bg-info me-1">' . $author['author_name'] . '</span>';
                                                        }
                                                        if (!empty($author['auth_subject'])) {
                                                            if (!empty($subjects)) {
                                                                $subjects .= ', ';
                                                            }
                                                            $subjects .= $author['auth_subject'];
                                                        }
                                                        if (!empty($author['author_article'])) {
                                                            if (!empty($articles)) {
                                                                $articles .= ', ';
                                                            }
                                                            $articles .= $author['author_article'];
                                                        }
                                                    endforeach;
                                                endif;
                                                ?>
                                        </td>
                                        <td>
                                                <?php
                                                if (empty($subjects)) {
                                                    if (!empty($book->tags)) {
                                                        foreach ($book->tags as $tag) {
                                                            if (!empty($subjects)) {
                                                                $subjects .= ', ';
                                                            }
                                                            $subjects .= $tag['categories'];
                                                        }
                                                    }
                                                }
                                                echo $subjects;
                                                ?>
                                        </td>
                                        <td>
                                                <?php echo $articles; ?>
                                        </td>
                                        <td>{{ (int) $book->publication_year }}</td>
                                        <td>
                                            @if($book->hasEResource())
                                                <a href="{{ route('library.reader', [$book->type, $book->id]) }}"
                                                   target="_blank">
                                                    <img src="/frontend/images/pdf-svgrepo-com.svg" width="80"
                                                         height="80" class="img-fluid pdfReaderIcon img-rounded"
                                                         style="min-width: 40px !important;"
                                                         title="Read: {{ ucwords($book->title) }}"
                                                         data-bs-toggle="tooltip" data-bs-placement="top"
                                                         alt="Read e-{{ ucfirst($book->type) }}">
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <nav>
                                {!! $books->links('pagination::bootstrap-5') !!}
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')

@endsection
