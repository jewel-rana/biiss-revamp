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
                                    <a href="{{ route('e-document', array_merge(Request::query(), ['letter_sort' => chr($i)])) }}"
                                       class="btn btn-sm btn-outline-primary m-1">
                                        {{ chr($i) }}
                                    </a>
                                @endfor
                            </div>
                            <div id="customFilters"
                                 style="padding:15px 10px;background: #fff;border:1px solid #eee;border-top-left-radius: 4px;border-top-right-radius: 4px;">

                                <form method="GET">
                                    <div class="row g-2">
                                        <input type="hidden" name="letter_sort" value="{{ request()->get('letter_sort', 'a') }}">
                                        <div class="col-md-4" style="position: relative;">
                                            <input type="text" id="filterQuery" class="form-control"
                                                   name="keyword"
                                                   value="{{ request()->input('keyword') }}"
                                                   autocomplete="off"
                                                   placeholder="Title">
                                        </div>
                                        <div class="col-md-4" style="position: relative;">
                                            <input type="text" id="filterAuthor" name="author" class="form-control"
                                                   value="{{ request()->input('author') }}"
                                                   autocomplete="off"
                                                   placeholder="Author">
                                        </div>
                                        <div class="col-md-2" style="position: relative;">
                                            <input type="text" id="filterSubject" name="subject" class="form-control"
                                                   value="{{ request()->input('subject') }}"
                                                   autocomplete="off"
                                                   placeholder="Subject">
                                        </div>
                                        <div class="col-md-1" style="position: relative;">
                                            <input type="text" id="filterYear" name="year" class="form-control"
                                                   value="{{ request()->input('year') }}"
                                                   autocomplete="off"
                                                   placeholder="Year">
                                        </div>
                                        <div class="col-md-1 d-grid">
                                            <button type="submit" class="btn btn-primary" id="filterButton"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
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
                                    <th style="width: 60px"><i class="fa fa-file-pdf"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($books->count())
                                    @foreach($books as $book)
                                        @if($book->hasEResource())
                                            <tr>
                                                <td>
                                                    @if($book->cover_photo != '')
                                                        <img src="{{ asset($book->cover_photo) }}" class="img-fluid"
                                                             style="width:60px;" alt="">
                                                    @else
                                                        <img
                                                            src="{{ asset('default/cover/' . strtolower($book->type) . '.jpg') }}"
                                                            class="img-fluid" style="width:60px;" alt="">
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('e-document.show', $book->id) }}">{{ $book->title }}</a>
                                                </td>
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
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">No resource found!</td>
                                    </tr>
                                @endif
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
