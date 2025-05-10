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
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="filterQuery" class="form-control"
                                               value="<?php echo ( isset( $_GET['search'] ) ) ? $_GET['search'] : ''; ?>"
                                               placeholder="Title">
                                        <select class="form-select" id="searchType" style="max-width: 100px;">
                                            <option value="like">Like</option>
                                            <option value="exact">Exact</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="filterAuthor" class="form-control"
                                           value="<?php echo ( isset( $_GET['author'] ) ) ? $_GET['author'] : ''; ?>"
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


        var url = "{{ route('datatable.frontend.search') }}";
        $(document).ready(function () {
            table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    'url': url,
                    'data': function (data) {
                        // Read values
                        // data.q = $('#filterQuery').val();
                        // data.author = $('#filterAuthor').val();
                        // data.type = $('#filterType').val();
                        // data.search_type = $('#searchType').val();
                    }
                },
                "pageLength": 25,
                "bFilter": false,
                "bInfo": false,
                "searching": false,
                "dom": '<"top"i>rt<"bottom"flp><"clear">',
                "lengthChange": true,
                "columns": [
                    {
                        "mRender": function (data, type, row) {
                            return '<img src="' + row['photo'] + '" class="img-responsive" style="width:60px;" alt="' + row['title'] + '">';
                        }
                    },
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
                // alert('filterQuery')
                console.log("filterQuery");

                table.draw();
            });
            $(customFilter).find('#filterAuthor').click(function (event) {
                // alert('filterAuthor')
                console.log("ofsdfdsfsdf");
                table.draw();
            });


            //Custom Filters ( ISBN search )
            $(customFilter).find('#filterType').change(function () {
                // alert('filterType')
                table.draw();
            });

            $(customFilters).find('#filterButton').click(function (event) {
                console.log("hellow, World!");
                table.draw();
            });
        });
    </script>
    <script>


        //carousel
        addLoadListener(initAwesomplete);

        function initAwesomplete() {
            var input = document.getElementById("librarySuggest");
            // var awesomplete = new Awesomplete(input);
            var value = input.value;

            var awesomplete = new Awesomplete(input);
            input.onkeyup = function (e) {
                var code = (e.keyCode || e.which);

                if (code === 37 || code === 38 || code === 39 || code === 40 || code === 27 || code === 13) {
                    return false;
                } else {

                    var xhr = getXHR();
                    var value = this.value;
                    xhr.open("GET", "{{ url('ajax/library/front/suggestions') }}/" + value, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4) {
                            if (xhr.status == 200 || xhr.status == 304) {
                                // response = xhr.responseText; // or xhr.responseXML;

                                var list = JSON.parse(xhr.responseText).map(function (i) {
                                    return i;
                                });
                                awesomplete.list = list;
                                awesomplete.data = function (i, input) {
                                    return {label: i.level, value: i.value};
                                }
                            }
                        }
                    };
                    xhr.send();

                }
            }

            input.addEventListener('awesomplete-selectcomplete', function () {

                // var xhr = new XMLHttpRequest();
                // xhr.open('GET', "{{ url('ajax/library/item') }}/" + this.value + "/?type=", true);
                // xhr.onreadystatechange = function()
                // {
                //   if(xhr.readyState == 4){
                //     if(xhr.status == 200 || xhr.status == 304)
                //     {
                //         $('.pagination').hide();
                //         document.getElementById("searchResult").innerHTML = xhr.response;
                //     }
                //   }
                // };
                // xhr.send();
            });
        }

        //carousel
        addLoadListener(initAuthorAwesomplete);

        function initAuthorAwesomplete() {
            var input = document.getElementById("authorSuggest");
            // var awesomplete = new Awesomplete(input);
            var value = input.value;

            var awesomplete = new Awesomplete(input);
            input.onkeyup = function (e) {
                var code = (e.keyCode || e.which);

                if (code === 37 || code === 38 || code === 39 || code === 40 || code === 27 || code === 13) {
                    return false;
                } else {

                    var xhr = getXHR();
                    var value = this.value;
                    xhr.open("GET", "{{ url('ajax/library/front/authorsuggestions') }}/" + value, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4) {
                            if (xhr.status == 200 || xhr.status == 304) {
                                // response = xhr.responseText; // or xhr.responseXML;

                                var list = JSON.parse(xhr.responseText).map(function (i) {
                                    return i;
                                });
                                awesomplete.list = list;
                                awesomplete.data = function (i, input) {
                                    return {label: i.level, value: i.value};
                                }
                            }
                        }
                    };
                    xhr.send();

                }
            }

            input.addEventListener('awesomplete-selectcomplete', function () {

                // var xhr = new XMLHttpRequest();
                // xhr.open('GET', "{{ url('ajax/library/item') }}/" + this.value + "/?type=", true);
                // xhr.onreadystatechange = function()
                // {
                //   if(xhr.readyState == 4){
                //     if(xhr.status == 200 || xhr.status == 304)
                //     {
                //         $('.pagination').hide();
                //         document.getElementById("searchResult").innerHTML = xhr.response;
                //     }
                //   }
                // };
                // xhr.send();
            });
        }

        function getXHR() {
            //ajax request
            var xhr;
            try {
                xhr = new XMLHttpRequest();
            } catch (error) {
                try {
                    xhr = new ActiveXObject('Microsoft.XMLHTTP');
                } catch (error) {
                    xhr = null;
                }
            }
            return xhr;
        }

        //Load Listener
        function addLoadListener(fn) {
            if (typeof window.addEventListener != 'undefined') {
                window.addEventListener('load', fn, false);
            } else if (typeof document.addEventListener != 'undefined') {
                document.addEventListener('load', fn, false);
            } else if (typeof window.attachEvent != 'undefined') {
                window.attachEvent('onload', fn);
            } else {
                var oldfn = window.onload;
                if (typeof window.onload != 'function') {
                    window.onload = fn;
                } else {
                    window.onload = function () {
                        oldfn();
                        fn();
                    };
                }
            }
        }

    </script>

@endsection
