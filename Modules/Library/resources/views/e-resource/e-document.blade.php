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
                        <h2><span>E-Documents</span></h2>
                        <div class="row">
                            <div class="d-flex justify-content-end flex-wrap mb-3">
                                @for ($i = 65; $i <= 90; $i++)
                                    <a href="{{ route('front.documents', array_merge(Request::query(), ['letter_sort' => chr($i)])) }}" class="btn btn-sm btn-outline-primary m-1">
                                        {{ chr($i) }}
                                    </a>
                                @endfor
                            </div>

                            <table class="table table-striped table-bordered align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th style="width:60px;"><i class="fa fa-image"></i></th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Subject</th>
                                    <th>Articles</th>
                                    <th>Year</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($books as $book)
                                    <tr>
                                        <td>
                                            @if($book->cover_photo != '')
                                                <img src="{{ asset($book->cover_photo) }}" class="img-fluid" style="width:60px;" alt="">
                                            @else
                                                <img src="{{ asset('default/cover/' . strtolower($book->type) . '.jpg') }}" class="img-fluid" style="width:60px;" alt="">
                                            @endif
                                        </td>
                                        <td><a href="{{ route('e-document.show', $book->id) }}">{{ $book->title }}</a></td>
                                        <td>
                                            @php
                                                $articles = '';
                                                $subjects = '';
                                                if ($book->authors) {
                                                    foreach ($book->authors as $author) {
                                                        if (!empty($author['author_name'])) {
                                                            echo '<span class="badge bg-info text-dark me-1">' . $author['author_name'] . '</span>';
                                                        }
                                                        if (!empty($author['auth_subject'])) {
                                                            $subjects .= ($subjects ? ', ' : '') . $author['auth_subject'];
                                                        }
                                                        if (!empty($author['author_article'])) {
                                                            $articles .= ($articles ? ', ' : '') . $author['author_article'];
                                                        }
                                                    }
                                                }
                                            @endphp
                                        </td>
                                        <td>{{ $subjects }}</td>
                                        <td>{{ $articles }}</td>
                                        <td>{{ (int) $book->publication_year }}</td>
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
