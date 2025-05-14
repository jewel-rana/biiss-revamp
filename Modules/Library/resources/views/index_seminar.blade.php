@extends("{$theme['backend']}::layouts.master")

@section('owncss')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/css/jquery.dataTables.min.css') }}"/>

    <style type="text/css">
        .memberTitle {
            font-weight: bold;
            padding: 10px 5px 0;
            text-transform: uppercase;
            font-size: 18px;
        }

        .paginate {
            margin-top: 10px;
        }

        .paginate a {
            padding: 3px 5px;
            margin-right: 0px;
            border: 1px solid #99bede;
        }

        div.alphabet {
            position: relative;
            display: table;
            width: auto;
            margin-bottom: 0;
            float: right;
        }

        div.alphabet span {
            display: table-cell;
            color: #3174c7;
            cursor: pointer;
            text-align: center;
            width: auto;
            padding: 8px;
            font-size: 1.2rem;
        }

        div.alphabet span:hover {
            text-decoration: underline;
        }

        div.alphabet span.active {
            color: black;
        }

        div.alphabet span.empty {
            color: red;
        }

        div.alphabetInfo {
            display: block;
            position: absolute;
            background-color: #111;
            border-radius: 3px;
            color: white;
            top: 4em;
            height: 1.8em;
            padding-top: 0.4em;
            text-align: center;
            z-index: 1;
            min-width: 40px !important;
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

        @media print {
            html, body {
                height: auto;
            }

            #page-wrapper {
                margin: 0 0 0 0;
                border-left: #FFF;
                padding: 0 10px;
                min-height: auto;
            }

            .navbar-static-side {
                margin: 0 0 0 0;
                margin-top: 10px;
            }
        }
    </style>
@endsection
@section('content')
    <!-- begin row -->
    <form id="filterForm">
        <div class="row mb-3" id="customFilters">
            <div class="col-md-3 columns">
                <input id="start" type="text" class="form-control title" placeholder="Search by title"/>
            </div>
            <div class="col-md-3 columns">
                <input id="end" type="text" class="form-control author" placeholder="Search by author"/>
            </div>
            <div class="col-md-3 columns">
                <input id="end" type="text" class="form-control subject" placeholder="Search by subject"/>
            </div>
            <div class="col-md-2 columns">
                <input id="end" type="text" class="form-control isbn" placeholder="Search by ISBN"/>
            </div>
            <div class="col-md-1 columns">
                <div class="btn-group">
                    <!-- <button id="end" type="button" class="btn btn-primary search"><i class="fa fa-search"></i></button> -->
                    <button type="button" class="btn btn-warning resetBtn"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin result-container -->
            <div class="result-container">

                <form action="{{ route('library.print.qr') }}" method="POST" id="qrPrintForm" target="_blank">
                    @csrf
                    <div class="btn-group mb-2" role="group" aria-label="Button group with nested dropdown">
                        {{-- <button type="submit" class="btn btn-primary btn-sm">Print QR</button> --}}
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Add new
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="{{ route('library.create', ['type' => 'book']) }}"
                                   target="_blank"><i class="fa fa-plus"></i> Book</a>
                                <a class="dropdown-item" href="{{ route('library.create', ['type' => 'journal']) }}"
                                   target="_blank"><i class="fa fa-plus"></i> Journal</a>
                                <a class="dropdown-item" href="{{ route('library.create', ['type' => 'document']) }}"
                                   target="_blank"><i class="fa fa-plus"></i> Document</a>
                                <a class="dropdown-item" href="{{ route('library.create', ['type' => 'magazine']) }}"
                                   target="_blank"><i class="fa fa-plus"></i> Magazine</a>
                                <a class="dropdown-item" href="{{ route('library.create', ['type' => 'seminar']) }}"
                                   target="_blank"><i class="fa fa-plus"></i> Seminar</a>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group mb-2" role="group" aria-label="Button group with nested dropdown pull-right">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @php echo ( $type ) ? ucfirst( $type ) : 'Type'; @endphp
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="{{ route('library.index', ['type' => 'book']) }}"><i
                                        class="fa fa-circle-o"></i> Book</a>
                                <a class="dropdown-item" href="{{ route('library.index', ['type' => 'journal']) }}"><i
                                        class="fa fa-circle-o"></i> Journals</a>
                                <a class="dropdown-item" href="{{ route('library.index', ['type' => 'document']) }}"><i
                                        class="fa fa-circle-o"></i> Documents</a>
                                <a class="dropdown-item" href="{{ route('library.index', ['type' => 'magazine']) }}"><i
                                        class="fa fa-circle-o"></i> Magazines</a>
                                <a class="dropdown-item" href="{{ route('library.index', ['type' => 'seminar']) }}"><i
                                        class="fa fa-circle-o"></i> Seminars</a>
                            </div>
                        </div>
                    </div>
                    <table id="example" class="dataTable1 display" style="width:100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Author</th>
                            <th>Author Mark</th>
                            <th>ISBN</th>
                            <th>Call Number</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Author</th>
                            <th>Author Mark</th>
                            <th>ISBN</th>
                            <th>Call Number</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('ownjs')
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/dataTables.select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/vfs_fonts.js') }}"></script>
    <script language="javascript" type="text/javascript">
        var table;
        var customFilter = document.getElementById('customFilters');
        var _alphabetSearch = '';
        var alphabet;
        var columnData;
        var bins;

        $.fn.DataTable.ext.search.push(function (settings, searchData) {
            if (!_alphabetSearch) {
                return true;
            }

            if (searchData[0].charAt(0) === _alphabetSearch) {
                return true;
            }

            return false;
        });


        function bin(data) {
            var letter, bins = {};

            for (var i = 0, ien = data.length; i < ien; i++) {
                letter = data[i].charAt(0).toUpperCase();

                if (bins[letter]) {
                    bins[letter]++;
                } else {
                    bins[letter] = 1;
                }
            }

            return bins;
        }


        function deleteLibraryItem(id) {
            var parent = $(this).parents('tr');
            var url = "{{ url('dashboard/library') }}/" + id;
            var data = null;

            var confirmed = confirm('Are you sure to delete this item?');

            if (confirmed) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: url,
                    data: data,
                    success: function (data, textStatus, xhr) {
                        if (data.success == true) {
                            $(parent).remove();
                        }

                        return false;
                    }
                });
            }

            return false;
        }

        $(document).ready(function () {
            var table = $('#example').DataTable({
                "processing": true,
                "pageLength": 100,
                "bInfo": true,
                "searching": true,
                "lengthChange": true,
                "dom": '<"top"i>rt<"bottom"flp><"clear">',
                "dom": 'Bfrtip',
                "buttons": [
                    {
                        extend: 'print',
                        title: function () {
                            return "<div style='font-size:14px;text-align:center'>Bangladesh Institute of International and Strategic Studies (BIISS)</div>";
                        },
                        messageTop: '<div style="font-size:13px;text-align:center">Print Report : Seminar Proceedings</div>',
                        exportOptions: {
                            columns: [1, 2, ':visible']
                        },
                        autoPrint: true,
                        text: 'Print',
                        pageSize: 'A4',
                        customize: function (win) {
                            $(win.document.body)
                                .css({'font-size': '10pt', 'padding': '50px 35px'});

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css({'font-size': 'inherit', 'color': '#000'});

                            // $(win.document.body).find( 'table td' ).css('border', '1px solid #000');
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        },
                        header: true,
                        title: 'Bangladesh Institute of International and Strategic Studies (BIISS)',
                        messageTop: 'Print Report : Seminar Proceedings',
                        orientation: 'portrate',
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 8; //<-- set fontsize to 16 instead of 10
                            doc.styles.tableHeader.fontSize = 8;
                            doc.defaultStyle.alignment = 'center';
                            $(doc).find('h1').css('font-size', '8pt');
                            $(doc).find('h1').css('text-align', 'center');
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                        },
                        text: 'PDF',
                    },
                    'colvis'
                ],
                select: {
                    style: 'multi'
                },
                "ajax": {
                    url: "{{ route('ajax.datatable.items', ['type' => $type]) }}",
                    data: function (param) {
                        param.isbn = $('.isbn').val() || '0',
                            param.title = $('.title').val() || '0',
                            param.author = $('.author').val() || '0',
                            param.subject = $('.subject').val() || '0'
                    }
                },
                "columns": [
                    {"data": "title"},
                    {"data": "authors"},
                    {"data": "authormark"},
                    {"data": "isbn"},
                    {"data": "call_number"},
                    {
                        mRender: function (data, type, row) {
                            var str = '<div class="btn-group">';
                            str += '<a href="/dashboard/issue/create/' + row['id'] + '" onclick="addToplisted(' + row['id'] + ');" target="_blank" class="btn btn-success" target="_blank" id="' + row['id'] + '"><i class="fa fa-plus"></i> Issue</a>';
                            str += '<a href="/dashboard/library/' + row['id'] + '" onclick="viewItem(' + row['id'] + ');" target="_blank" class="btn btn-primary" target="_blank" id="' + row['id'] + '"><i class="fa fa-eye"></i> View</a>';

                            str += '<a href="/dashboard/library/' + row['id'] + '/edit" class="btn btn-success" target="_blank" id="' + row['id'] + '"><i class="fa fa-edit"></i> Edit</a>';

                            str += '<a href="#" class="btn btn-danger deleteItem" id="' + row['id'] + '"><i class="fa fa-times"></i> Delete</a>';

                            str += '</div>';

                            return str;
                        }
                    }
                ],
                "order": [[0, 'asc']],
                "initComplete": function () {
                    alphabetSearchStuff();
                }
            });

            function alphabetSearchStuff() {
                // table.column(1).data();
                var alphabet = $('<div class="alphabet"/>').append('Search: ');
                var columnData = table.column(0).data();
                bins = bin(columnData);

                $('<span class="clear active"/>')
                    .data('letter', '')
                    .data('match-count', columnData.length)
                    .html('None')
                    .appendTo(alphabet);

                for (var i = 0; i < 26; i++) {
                    var letter = String.fromCharCode(65 + i);

                    $('<span/>')
                        .data('letter', letter)
                        .data('match-count', bins[letter] || 0)
                        .addClass(!bins[letter] ? 'empty' : '')
                        .html(letter)
                        .appendTo(alphabet);
                }

                alphabet.insertBefore(table.table().container());

                alphabet.on('click', 'span', function () {
                    alphabet.find('.active').removeClass('active');
                    $(this).addClass('active');

                    _alphabetSearch = $(this).data('letter');
                    table.draw();
                });

                var info = $('<div class="alphabetInfo"></div>')
                    .appendTo(alphabet);

                alphabet
                    .on('mouseenter', 'span', function () {
                        info
                            .css({
                                opacity: 1,
                                left: $(this).position().left,
                                width: $(this).width()
                            })
                            .html($(this).data('match-count'));
                    })
                    .on('mouseleave', 'span', function () {
                        info.css('opacity', 0);
                    });
            }

            //checkbox checked all selected rows
            $(table).find('tr.selected').each(function () {
                $(this).find('.itemcheckbox').prop('checked', true);
            });

            //select / deselect checkbox on click table row
            $('#example tbody').on('click', 'tr', function () {
                var checkbox = $(this).find('.itemcheckbox');
                //check selected or not
                if ($(this).hasClass('selected')) {
                    $(checkbox).prop('checked', false);
                } else {
                    //checked current item
                    $(checkbox).prop("checked", true);
                }
            });

            $('#example').on('click', '.deleteItem', function () {
                console.log($(this));
                var parent = $(this).parents('tr');
                var id = $(this).attr('id');
                var url = "{{ url('dashboard/library') }}/" + id;

                var confirmed = confirm('Are you sure to delete this item?');

                if (confirmed) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: null,
                        success: function (data, textStatus, xhr) {
                            if (data.success == true) {
                                table.row(parent).remove().draw();
                            }

                            return false;
                        }
                    });
                }

                return false;
            });

            $(document).on('keyup', '.subject, .author, .title, .isbn', function () {
                table.ajax.reload();
            });
            //reset filter
            $(document).on('click', '.resetBtn', function () {
                $('#filterForm')[0].reset();
                table.ajax.reload();
            });

            //check all item
            $('#checkedall').on("click", function (e) {
                e.defaultPrevented;
                var parent = $(this).parents('table');

                if ($(this).is(":checked")) {

                    $(parent).find(".itemcheckbox").each(function () {
                        $(this).prop('checked', true);

                        //select datatable columns
                        var dtparent = $(this).parents('tr');

                        $(dtparent).addClass('selected');
                    });
                } else {
                    $(parent).find(".itemcheckbox").each(function () {
                        $(this).prop('checked', false);

                        //select datatable columns
                        var dtparent = $(this).parents('tr');
                        $(dtparent).removeClass('selected')
                    });
                    ;
                }
            });

        });
    </script>

@endsection
