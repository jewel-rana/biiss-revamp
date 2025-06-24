@extends("{$theme['backend']}::layouts.master")
@section('owncss')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/css/jquery.dataTables.min.css') }}"/>
    <meta charset="UTF-8"/>

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

        @page {
            size: auto;
            margin: 0mm;
        }
    </style>
@endsection
@section('content')
    <!-- begin row -->
    <form id="filterForm">
        <div class="row mb-3" id="customFilters">
            <div class="col-md-2 columns">
                <input id="end" type="text" class="form-control accno" placeholder="ACCNO"/>
            </div>
            <div class="col-md-2 columns">
                <input id="end" type="text" class="form-control call_number" placeholder="CALL No."/>
            </div>
            <div class="col-md-2 columns">
                <input id="start" type="text" class="form-control title" placeholder="Search by title"/>
            </div>
            <div class="col-md-3 columns">
                <input id="end" type="text" class="form-control author" placeholder="Search by author"/>
            </div>
            <div class="col-md-3 columns">
                <input id="end" type="text" class="form-control subject" placeholder="Search by subject"/>
            </div>

            <div class="col-md-1 columns mt-3">
                <input id="minYear" type="text" class="form-control year" placeholder="Year from"/>
            </div>
            <div class="col-md-1 columns mt-3">
                <input id="maxYear" type="text" class="form-control year" placeholder="Year to"/>
            </div>

            <div class="col-md-2 columns mt-3">
                <input id="end" type="text" class="form-control publisher" placeholder="Publisher"/>
            </div>
            <div class="col-md-2 columns mt-3">
                <input id="end" type="text" class="form-control place" placeholder="Place"/>
            </div>

            <div class="col-md-3 columns mt-3">
                <input id="end" type="text" class="form-control remarks" placeholder="Remarks"/>
            </div>

            <div class="col-md-1 columns mt-3">
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
                        <button type="submit" class="btn btn-primary btn-sm">Print QR</button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Add new
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item"
                                   href="{{ route('library.create', ['type' => 'book']) }}" target="_blank"><i
                                        class="fa fa-plus"></i> Book</a>
                                <a class="dropdown-item"
                                   href="{{ route('library.create', ['type' => 'journal']) }}"
                                   target="_blank"><i class="fa fa-plus"></i> Journal</a>
                                <a class="dropdown-item"
                                   href="{{ route('library.create', ['type' => 'document']) }}"
                                   target="_blank"><i class="fa fa-plus"></i> Document</a>
                                <a class="dropdown-item"
                                   href="{{ route('library.create', ['type' => 'magazine']) }}"
                                   target="_blank"><i class="fa fa-plus"></i> Magazine</a>
                                {{-- <a class="dropdown-item" href="{{ route('library.create', ['type' => 'seminar']) }}" target="_blank"><i class="fa fa-plus"></i> Seminar</a> --}}
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
                                <a class="dropdown-item"
                                   href="{{ route('library.index', ['type' => 'book']) }}"><i
                                        class="fa fa-circle-o"></i> Book</a>
                                <a class="dropdown-item"
                                   href="{{ route('library.index', ['type' => 'journal']) }}"><i
                                        class="fa fa-circle-o"></i> Journals</a>
                                <a class="dropdown-item"
                                   href="{{ route('library.index', ['type' => 'document']) }}"><i
                                        class="fa fa-circle-o"></i> Documents</a>
                                <a class="dropdown-item"
                                   href="{{ route('library.index', ['type' => 'magazine']) }}"><i
                                        class="fa fa-circle-o"></i> Magazines</a>
                                {{-- <a class="dropdown-item" href="{{ route('library.index', ['type' => 'seminar']) }}"><i class="fa fa-circle-o"></i> Seminars</a> --}}
                            </div>
                        </div>
                    </div>
                    <table id="example" class="dataTable1 display" style="width:100%">
                        <thead>
                        <tr>
                            <th style="width:40px;">
                                <input type="checkbox" id="checkedall" name="">
                            </th>
                            <th>ACCNO.</th>
                            <th>Call Number</th>
                            <th>Author Mark</th>
                            <th>Name</th>
                            <th>Author</th>
                            <th>Publication Year</th>
                            <th>Subject</th>
                            <th>ISBN</th>
                            <th>Remarks</th>
                            <th>EDate</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th style="width:40px;">
                                Checkbox
                            </th>
                            <th>ACCNO.</th>
                            <th>Call Number</th>
                            <th>Author Mark</th>
                            <th>Name</th>
                            <th>Author</th>
                            <th>Publication Year</th>
                            <th>Subject</th>
                            <th>ISBN</th>
                            <th>Remarks</th>
                            <th>EDate</th>
                            <th>Action</th>
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
    <script type="text/javascript" src="{{ asset('plugins/DataTables/js/pdfmake.js') }}"></script>
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

            if (searchData[4].charAt(0) === _alphabetSearch) {
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
                    "dom": 'Bfrtip',
                    "buttons": [
                        {
                            text: 'Deselect',
                            action: function () {
                                table.rows().deselect();
                            }
                        },
                        {
                            extend: 'print',

                            title: 'Bangladesh Institute of International and Strategic Studies (BIISS)',
                            messageTop: 'Resource : Books',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            },
                            autoPrint: true,
                            text: 'Print',
                            pageSize: 'A4',
                            orientation: 'landscape',
                            customize: function (win) {
                                $(win.document.body)
                                    .css({
                                        'font-size': '10pt',
                                        'margin': '40px',
                                        'padding': '20px',
                                        'color': '#000',
                                        'font-family': 'Arial, sans-serif'
                                    });

                                // Header spacing
                                $(win.document.body).find('h1').css({
                                    'font-size': '16pt',
                                    'text-align': 'center',
                                    'margin-bottom': '10px'
                                });

                                // Table styling
                                const $table = $(win.document.body).find('table');

                                $table
                                    .addClass('compact')
                                    .css({
                                        'width': '100%',
                                        'font-size': '10pt',
                                        'border-collapse': 'collapse',
                                        'margin-top': '20px'
                                    });

                                $table.find('th, td')
                                    .css({
                                        'border': '1px solid #000',
                                        'padding': '6px',
                                        'text-align': 'center',
                                        'vertical-align': 'middle'
                                    });

                                $table.find('thead').css({
                                    'background-color': '#f1f1f1',
                                    'font-weight': 'bold'
                                });

                                // Optional: watermark or footer
                                $(win.document.body).append(`
            <div style="position: fixed; bottom: 20px; left: 0; width: 100%; text-align: center; font-size: 10px;">
                Printed by BIISS Library System - ${new Date().toLocaleDateString()}
            </div>
        `);
                                $(win.document.body).find('table td').css('border', '1px solid #000');
                                // Add a style tag to enforce landscape
                                const landscapeStyle = `
            <style>
                @page { size: landscape; }
            </style>
        `;
                                $(win.document.head).append(landscapeStyle)
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions: {
                                columns: [1, 2, ':visible:not(:eq(0)):not(:eq(11))'],
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            className: 'btn btn-green',
                            bom: 'true',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            },
                            header: true,
                            charset: 'UTF-8',
                            title: 'Bangladesh Institute of International and Strategic Studies (BIISS)',
                            messageTop: 'Resource : Books',
                            orientation: 'landscape',
                            customize: function (doc) {
                                // ✅ Force A4 landscape
                                doc.pageOrientation = 'landscape';

                                // ✅ Set margins (optional)
                                doc.pageMargins = [40, 40, 40, 40];

                                // ✅ Set default font size
                                doc.defaultStyle.fontSize = 9;
                                doc.styles.tableHeader.fontSize = 10;
                                doc.styles.tableHeader.alignment = 'center';


                                // ✅ Set table to 100% width
                                var tableNode = doc.content.find(function (node) {
                                    return node.table;
                                });

                                if (tableNode && tableNode.table && tableNode.table.body.length > 0) {
                                    var columnCount = tableNode.table.body[0].length;
                                    tableNode.table.widths = Array(columnCount).fill('*');
                                }

                                // ✅ Optional table layout
                                doc.content[1].layout = {
                                    hLineWidth: function () { return 1; },
                                    vLineWidth: function () { return 1; },
                                    hLineColor: function () { return '#000'; },
                                    vLineColor: function () { return '#000'; },
                                    paddingLeft: function () { return 4; },
                                    paddingRight: function () { return 4; },
                                    paddingTop: function () { return 2; },
                                    paddingBottom: function () { return 2; }
                                };
                            }
                        },
                        'colvis'
                    ],
                    select: {
                        style: 'multi'
                    }
                    ,
                    "ajax":
                        {
                            url: "{{ route('ajax.datatable.items', ['type' => $type]) }}",
                            data:

                                function (param) {
                                    param.accno = $('.accno').val() || '0';
                                    param.call_number = $('.call_number').val() || '0';
                                    param.title = $('.title').val() || '0';
                                    param.author = $('.author').val() || '0';
                                    param.subject = $('.subject').val() || '0';
                                    param.minYear = $('#minYear').val() || '0';
                                    param.maxYear = $('#maxYear').val() || '0';
                                    param.remarks = $('.remarks').val() || '0';
                                    param.publisher = $('.publisher').val() || '0';
                                    param.place = $('.place').val() || '0';
                                }
                        }
                    ,
                    "columns":
                        [
                            {
                                mRender: function (data, type, row) {
                                    return '<input type="checkbox" name="id[]" value="' + row['id'] + '" class="itemcheckbox">';
                                }
                            },
                            {"data": "acc_number"},
                            {"data": "call_number"},
                            {"data": "authormark"},
                            {"data": "title"},
                            {"data": "authors"},
                            {"data": "publication_year"},
                            {"data": "subjects"},
                            {"data": "isbn"},
                            {"data": "remarks"},
                            {"data": "edate"},
                            {
                                mRender: function (data, type, row) {
                                    var str = '<div class="btn-group">';
                                    str += '<a href="/dashboard/issue/create?id=' + row['id'] + '" onclick="addToplisted(' + row['id'] + ');" target="_blank" class="btn btn-success" target="_blank" id="' + row['id'] + '"><i class="fa fa-plus"></i> Issue</a>';
                                    str += '<a href="/dashboard/library/' + row['id'] + '" onclick="viewItem(' + row['id'] + ');" target="_blank" class="btn btn-primary" target="_blank" id="' + row['id'] + '"><i class="fa fa-eye"></i> View</a>';

                                    str += '<a href="/dashboard/library/' + row['id'] + '/edit" class="btn btn-success" target="_blank" id="' + row['id'] + '"><i class="fa fa-edit"></i> Edit</a>';

                                    str += '<a href="#" class="btn btn-danger deleteItem" id="' + row['id'] + '"><i class="fa fa-times"></i> Delete</a>';

                                    str += '</div>';

                                    return str;
                                }
                            }
                        ],
                    "columnDefs":
                        [
                            {"targets": [0], "searchable": false, "orderable": false, "visible": true},
                            { targets: [0], visible: false },
                            {"type": "num", "targets": 1}
                        ],
                    "order":
                        [[1, 'asc']],
                    "initComplete":

                        function () {
                            alphabetSearchStuff();
                        }
                })
            ;

            function alphabetSearchStuff() {
                // table.column(1).data();
                var alphabet = $('<div class="alphabet"/>').append('Search: ');
                var columnData = table.column(4).data();
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

            $(document).on('keyup', '.subject, .author, .title, .accno, .publisher, .place, #minYear,#maxYear, .call_number,.remarks', function () {
                table.ajax.reload();
            });
            $(document).on('click', '.resetBtn', function () {
                $('#filterForm')[0].reset();
                table.ajax.reload();
            });

            $('#qrPrintForm').submit(function (e) {


                if ($('#qrPrintForm input:checked').length > 0) {
                    return true;
                } else {
                    swal('Sorry!', 'No item selected.', "error");
                    return false;
                }
            });
            //category search box display on click event
            $('#collapseCategory').on("click", function (e) {
                e.defaultPrevented;

                $('#categoryFilter').toggleClass('hide');
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

                        // $(dtparent).addClass('selected');
                    });
                    // var page = table.rows({ page: 'current' }).nodes();
                    // page.select();
                } else {
                    $(parent).find(".itemcheckbox").each(function () {
                        $(this).prop('checked', false);

                        //select datatable columns
                        var dtparent = $(this).parents('tr');
                        // $(dtparent).removeClass('selected')
                    });
                    ;
                }
            });

            //check all item
            function check() {
                e.defaultPrevented;

                var parent = $('#example');

                $(parent).find(".itemcheckbox").each(function () {
                    $(this).prop('checked', true);
                });

            }

        });
    </script>

@endsection
