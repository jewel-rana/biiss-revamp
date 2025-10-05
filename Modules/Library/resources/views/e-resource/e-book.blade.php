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
                        <h2>
                            <span>E-Books</span>
                            <span><button class="btn btn-primary" onclick="printSection('printable')"><i class="fa fa-print"></i></button></span>
                        </h2>
                        <div class="row pt-2">
                            <div class="paginate float-end mb-3">
                                @for ($i = 65; $i <= 90; $i++)
                                    <a href="{{ route('e-book', array_merge(request()->query(), ['letter_sort' => chr($i)])) }}" class="myclass">
                                        {{ chr($i) }}
                                    </a>
                                @endfor

                            </div>
                            <div id="customFilters"
                                 style="padding:15px 10px;background: #fff;border:1px solid #eee;border-top-left-radius: 4px;border-top-right-radius: 4px;">

                                <form method="GET">
                                    <div class="row g-2">
                                        <input type="hidden" name="letter_sort"
                                               value="{{ request()->get('letter_sort', 'a') }}">
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
                                            <button type="submit" class="btn btn-primary" id="filterButton"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="printable">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width:60px;"><i class="fa fa-image"></i></th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Subject</th>
                                        <th>Year</th>
                                        <th style="width: 60px"><i class="fa fa-file-pdf-o"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($books->count())
                                        @foreach( $books as $book )
                                            @if($book->hasEResource())
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
                                                    <td>
                                                        <a href="{{ route('e-book.show', $book->id ) }}">{{ $book->title }}</a>
                                                    </td>
                                                    <td>
                                                            <?php
                                                            $articles = '';
                                                            $subjects = '';
                                                            if ($book->authors) :
                                                                foreach ($book->authors as $author) :
                                                                    if (!empty($author['author_name'])) {
                                                                        echo '<span class="me-1">' . $author['author_name'] . '</span>';
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
                                                    <td><?php echo $subjects; ?></td>
                                                    <td>{{ (int) $book->publication_year }}</td>
                                                    <td>
                                                        @if($book->hasEResource())
                                                            <a href="{{ route('library.reader', [$book->type, $book->id]) }}"
                                                               target="_blank">
                                                                <img src="/frontend/images/pdf-svgrepo-com.svg"
                                                                     width="80"
                                                                     height="80"
                                                                     class="img-fluid pdfReaderIcon img-rounded"
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
                            </div>
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
    <script>
        function printSection(sectionId) {
            const el = document.getElementById(sectionId);
            if (!el) return;

            const printWin = window.open('', '', 'width=1024,height=768');
            printWin.document.open();
            printWin.document.write(`<!doctype html><html><head><meta charset="utf-8"><title>Print</title>
        <style>
          @page { size: A4 portrait; margin: 12mm; }
          body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
          table { width: 100%; border-collapse: collapse; }
          th, td { border: 1px solid #000; padding: 6px; }
        </style>
    </head><body>${el.innerHTML}</body></html>`);
            printWin.document.close();

            // Copy stylesheets from the current page
            const head = printWin.document.head;
            document.querySelectorAll('link[rel="stylesheet"], style').forEach(node => {
                head.appendChild(node.cloneNode(true));
            });

            printWin.onload = function () {
                printWin.focus();
                printWin.print();
                printWin.close();
            };
        }
    </script>
@endsection
