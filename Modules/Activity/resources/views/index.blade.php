@extends('metis::layouts.master')

@section('header')
    <style>
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
        }
    </style>
@endsection

@section('content')
    <div id="content">
        <div class="outer">
            <div class="inner bg-light lter">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <header>
                                <div class="icons"><i class="fa fa-table"></i></div>
                                <h5>{{ $title ?? 'Audit logs' }}</h5>
                                <div class="toolbar">
                                    <nav style="padding: 8px;">
                                    </nav>
                                </div>
                                <!-- /.toolbar -->
                            </header>
                            <div id="collapse4" class="body">
                                <table id="dataTable"
                                       class="table table-bordered table-condensed table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Causer Type</th>
                                        <th>Causer</th>
                                        <th>Subject</th>
                                        <th>Subject ID</th>
                                        <th>Message</th>
                                        <th>IP</th>
                                        <th>Created at</th>
                                        <th class="table-actions">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!--End Datatables-->
            </div>
            <!-- /.inner -->
        </div>
        <!-- /.outer -->
    </div>
    <!-- /#content -->
@endsection

@section('footer')
    <script>
        jQuery(function ($) {
            let table = $('#dataTable').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: '{{ route('activity.index') }}',
                    data: function (data) {
                        data.subject_type = $('#filterPanel #subjectType').val();
                        data.subject_id = $('#filterPanel #subjectId').val();
                        data.keyword = $('#filterPanel #keywords').val();
                    }
                },
                "bAutoWidth": true,
                "sPageButtonActive": "active",
                dom: 'lr<"toolbar">tip',
                stateSave: true,
                "stateDuration": 60 * 60 * 24 * 7,
                deferRender: true,
                "lengthChange": true,
                lengthMenu: [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]],
                "pageLength": 50,
                "bFilter": true,
                "bInfo": true,
                "searching": true,
                "order": [[0, "DESC"]],
                columns: [
                    {"data": 'causer', order: true},
                    {"data": 'causer_name'},
                    {"data": 'subject'},
                    {"data": 'subject_id'},
                    {"data": 'message', searching: false, sortable: false},
                    {"data": 'ip'},
                    {"data": 'created_at'},
                    {"data": 'actions', searching: false, sortable: false}
                ],
                "createdRow": function (row, data, index) {
                    // if ( data[6] == 'Disable' ){
                    //     $(row).addClass('highlightError');
                    // }
                }
            });
            document.querySelector('div#dataTable_wrapper .toolbar').innerHTML = "<div class='form-inline' id='filterPanel'>" +
                "<div class='form-group mx-sm-3 mr'>" +
                "<input type='text' class='form-control' id='keywords' placeholder='Causer ID / Name / Mobile'>" +
                "</div>" +
                "<div class='btn-group pt pr pb pl'>" +
                "<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' data-bs-auto-close='outside'><i class='fa fa-filter'></i>" +
                "<span class='caret'></span></button>" +
                "<div class='dropdown-menu dropdown-menu-right' style='padding: 10px;'>" +
                "<div class=''>" +
                "<label for='idAddress'>IP Address</label>" +
                "<input type='text' class='form-control' id='idAddress' placeholder='IP Address'>" +
                "</div>" +
                "<div class=''>" +
                "<label for='subjectType'>Subject Type</label>" +
                "<select class='form-control' id='subjectType' data-popper-placement='Subject Type'></select>" +
                "</div>" +
                "<div class='pt-3'>" +
                "<label for='subjectId'>Subject ID</label>" +
                "<input type='text' class='form-control' id='subjectId' placeholder='Subject ID'>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";

            $("#filterPanel #roleId").select2({
                allowClear: true,
                width: "100%",
                placeholder: "Select role",
                delay: 250,
                ajax: {
                    url: '{{ route('role.suggestion') }}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            term: params.term
                        }
                    },
                    results: function (data, page) {
                        return {results: data.data};
                    }
                }
            });

            $("#filterPanel input").on("keyup", function () {
                table.draw();
            });
            $("#filterPanel select").on("change", function () {
                table.draw();
            });

            $('table').on('click', '.showActivity', function () {
                let data = $(this).data('content');
                console.log(data);
                $(modal).find('.modal-title').text('Audit Log Info: #' + data.id);
                $(modal).find('.modal-dialog').addClass('modal-dialog-lg');
                $(modal).find('.modal-footer').hide();
                $(modal).find('.modal-body').html(
                    '<table class="table table-striped">' +
                    '<tr>' +
                    '<td>ID</td>' +
                    '<td>: ' + data.id + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Log Name</td>' +
                    '<td>: ' + data.log_name + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Causer Type</td>' +
                    '<td>: ' + data.causer_type + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Causer ID</td>' +
                    '<td>: ' + data.causer_id + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Subject</td>' +
                    '<td>: ' + data.subject_type + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Subject ID</td>' +
                    '<td>: ' + data.subject_id + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>IP Address</td>' +
                    '<td>: ' + data.ip + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Message</td>' +
                    '<td>: ' + data.message + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Model Attributes</td>' +
                    '<td>: <pre>' + JSON.stringify(data.data.attributes, null, 4) + '</pre></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Changes</td>' +
                    '<td>:  <pre>' + JSON.stringify(data.data.changes, null, 4) + '</pre></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Host Info</td>' +
                    '<td>:  <pre>' + JSON.stringify(data.data.hosts, null, 4) + '</pre></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Created At</td>' +
                    '<td>: ' + data.created_at + '</td>' +
                    '</tr>' +
                    '</table>'
                );
                $(modal).modal('show');
            });
        });

    </script>
@endsection
