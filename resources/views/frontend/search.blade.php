@extends("{$theme['frontend']}::layouts.master")

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/css/jquery.dataTables.min.css') }}"/>
    <style type="text/css">

        .paginate {
            margin-top: 10px;
        }

        .paginate a {
            padding: 3px 5px;
            margin-right: 0px;
            border: 1px solid #99bede;
        }

        div.dataTables_wrapper div.dataTables_info {
            font-size: 15px;
            padding: 15px 0;
            font-weight: bold;
        }

        div.dataTables_wrapper div.dataTables_filter {
            display: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: inherit;
            margin-left: 0;
            margin-right: 0;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover, .dataTables_wrapper .dataTables_paginate .paginate_button:focus {
            background: transparent;
            border: 0;
        }
    </style>
<style>
    /* Apply Bootstrap's form-control behavior to Awesomplete input */
    .awesomplete input.form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    /* Suggestion dropdown positioning */
    .awesomplete ul {
        position: absolute;
        top: 100%; /* place directly below input */
        left: 0;
        right: 0; /* match container width */
        z-index: 1000;
        margin: 0;
        padding: 0;
        list-style: none;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-top: none;
        max-height: 250px;
        overflow-y: auto;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }

    /* Suggestion list items */
    .awesomplete li {
        padding: 0.5rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f1f1f1;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Active/hover styling */
    .awesomplete li:hover,
    .awesomplete li[aria-selected="true"] {
        background-color: #e9ecef;
        color: #212529;
    }
</style>

@endsection

@section('content')

    <div class="pageContent mt-4">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="new_book">
                        <!-- Set up your HTML -->
                        <h2><span>Search</span></h2>
                        <div id="customFilters"
                             style="padding:15px 10px;background: #fff;border:1px solid #eee;border-top-left-radius: 4px;border-top-right-radius: 4px;">
                            <div class="row g-2">
                                <div class="col-md-4" style="position: relative;">
                                    <input type="text" id="filterQuery" class="form-control"
                                           value="{{ request()->input('keyword') }}"
                                           autocomplete="off"
                                           placeholder="Title">
                                </div>
                                <div class="col-md-1">
                                    <select class="form-select" id="searchType" style="max-width: 100px;">
                                        <option value="like">Match</option>
                                        <option value="exact">Exact</option>
                                    </select>
                                </div>
                                <div class="col-md-4" style="position: relative;">
                                    <input type="text" id="filterAuthor" class="form-control"
                                           value="{{ request()->input('author') }}"
                                           autocomplete="off"
                                           placeholder="Author">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" id="filterType">
                                        <option value="">Type</option>
                                        <option value="book">Books</option>
                                        <option value="journal">Journals</option>
                                        <option value="magazine">Magazines</option>
                                        <option value="document">Documents</option>
                                        <option value="seminar_proceeding">Seminar Proceedings</option>
                                    </select>
                                </div>
                                <div class="col-md-1 d-grid">
                                    <button class="btn btn-warning" id="filterButton">Filter</button>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped display" id="dataTable" style="width:100%">
                            <thead>
                            <tr>
                                <th style="width:60px;"><i class="fa fa-image"></i></th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Subject</th>
                                <th>Articles</th>
                                <th>Type</th>
                                <th>Year</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('plugins/awesomplete/awesomplete.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/vfs_fonts.js') }}"></script>
    <script language="javascript" type="text/javascript">
        var table;
        var customFilter = document.getElementById('customFilters');

        $(document).ready(function () {
            table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    'url': "{{ route('datatable.frontend.search') }}",
                    'data': function (data) {
                        // Read values
                        data.q = $('#filterQuery').val();
                        data.author = $('#filterAuthor').val();
                        data.type = $('#filterType').val();
                        data.search_type = $('#searchType').val();
                    }
                },
                "pageLength": 25,
                "bFilter": false,
                "bInfo": false,
                "searching": false,
                "dom": '<"top"i>rt<"bottom"flp><"clear">',
                "lengthChange": true,
                "columns": [
                    {"data": "photo"},
                    {
                        "mRender": function (data, type, row) {
                            return '<a href="/single/' + row['id'] + '" title="' + row['title'] + '">' + row['title'] + '</a>';
                        }
                    },
                    {"data": "author"},
                    {"data": "subjects"},
                    {"data": "articles"},
                    {"data": "type"},
                    {"data": "publication_year"}
                ],
                "columnDefs": [{"targets": [0, 2], "searchable": false, "orderable": false, "visible": true}],
                "order": [[1, 'asc']]
            });


            //Custom Filters ( title search )
            $(customFilter).find('#filterQuery').click(function (event) {

                table.draw();
            });
            $(customFilter).find('#filterAuthor').click(function (event) {
                table.draw();
            });


            //Custom Filters ( ISBN search )
            $(customFilter).find('#filterType').change(function () {
                table.draw();
            });

            $(customFilters).find('#filterButton').click(function (event) {
                table.draw();
            });
        });
    </script>
    <script>
        function getXHR() {
            if (window.XMLHttpRequest) return new XMLHttpRequest();
            return new ActiveXObject("Microsoft.XMLHTTP");
        }

        function initAwesomplete() {
            const input = document.getElementById("filterQuery");
            const typeInput = document.getElementById("filterType");

            const awesomplete = new Awesomplete(input);

            input.onkeyup = function (e) {
                const code = (e.keyCode || e.which);

                if ([37, 38, 39, 40, 27, 13].includes(code)) return;

                const value = this.value;
                const type = typeInput.value;

                const xhr = getXHR();
                const requestUrl = `/ajax/library/front/suggestions/${encodeURIComponent(value)}?type=${encodeURIComponent(type)}`;

                xhr.open("GET", requestUrl, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 304)) {
                        try {
                            const list = JSON.parse(xhr.responseText);
                            awesomplete.list = list;
                            awesomplete.data = function (i, input) {
                                return { label: i.level, value: i.value };
                            }
                        } catch (e) {
                            console.error("Invalid JSON returned:", xhr.responseText);
                        }
                    }
                };
                xhr.send();
            };
        }



        function initAuthorAwesomplete() {
            const input = document.getElementById("filterAuthor");

            const awesomplete = new Awesomplete(input);

            input.onkeyup = function (e) {
                const code = (e.keyCode || e.which);

                if ([37, 38, 39, 40, 27, 13].includes(code)) return;

                const value = this.value;

                const xhr = getXHR();
                const requestUrl = `/ajax/library/front/author-suggestions/${encodeURIComponent(value)}`;

                xhr.open("GET", requestUrl, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 304)) {
                        try {
                            const list = JSON.parse(xhr.responseText);
                            awesomplete.list = list;
                            awesomplete.data = function (i, input) {
                                return { label: i.level, value: i.value };
                            }
                        } catch (e) {
                            console.error("Invalid JSON returned:", xhr.responseText);
                        }
                    }
                };
                xhr.send();
            };
        }

        // Run when page loads
        window.addEventListener('load', initAwesomplete);
        window.addEventListener('load', initAuthorAwesomplete);
    </script>
@endsection
