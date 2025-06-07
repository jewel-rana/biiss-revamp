@extends("{$theme['default']}::layouts.master")

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Member Profile Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('user.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="media">
                <div class="media-left">
                    <a href="#">

                        <?php if($member->avatar !=''){
                        ?>

                            <img class="media-object img-thumbnail" src="{{Request::root()}}/uploads/profile/{{ $member->avatar }}" width="350">
                        <?php
                        }else{
                        ?>
                             <img class="media-object img-thumbnail" src="{{Request::root()}}/images/avatar_small.png" width="350">
                        <?php
                        }

                        ?>



                    </a>
                </div>
                <div class="media-body">
                    <dl class="dl-horizontal">

                        <dt>Name : </dt>
                        <dd>{{ $member->name }}</dd>


                        <dt>Email : </dt>
                        <dd>{{ $member->email }}</dd>

                        <dt>Contact number : </dt>
                        <dd>{{ $member->contact_number }}</dd>

                        <dt>Address : </dt>
                        <dd>{{ $member->address }}</dd>

                    </dl>
                    <div class="media-body">
                        <dl class="dl-horizontal">
                            <h5>History of book issues .</h5>
                            @if( !empty( $issuedBooks ) && is_object( $issuedBooks ) )
                            <table class="table table-bordered table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-left">Name of Books</th>
                                        <th>Status</th>
                                        <th>Issued</th>
                                        <th>Expire</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $issuedBooks as $issue )
                                    <!-- {{ $issue->is_returned }} -->
                                    <tr>
                                        <td class="text-left">
                                            <a href="{{ url('dashboard/book/' . $issue->book_id) }}" target="ext">
                                                {{ ucwords( $issue->book_title ) }}
                                            </a>
                                        </td>
                                        <td>
                                        @if( $issue->is_returned  )
                                            <span style="background:green" class="badge badge-success">Returned</span>
                                        @else
                                            @if( $issue->end_date > date('Y-md') )
                                                <span style="background:red" class="badge badge-danger">Expired</span>
                                            @else
                                                <span style="background:lightgreen;color:#465ddc;" class="badge badge-primary">Not returned</span>
                                            @endif
                                        @endif
                                        </td>
                                        <td>{{ $issue->start_date }}</td>
                                        <td>{{ $issue->end_date }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                                <div class="alert alert-warning">
                                    <strong>No issued books found.</strong>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

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
$(document).ready(function() {
    var table = $('#example').DataTable( {
        "pageLength": 25,
        "bInfo": true,
        "searching": true,
        "lengthChange": true,
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'print',
                title: 'Bangladesh Institute of International and Strategic Studies (BIISS)',
                messageTop: '<h2>Print Report : Journals</h2>',
                exportOptions: {
                    columns: [ 1, 2, ':visible' ]
                },
                autoPrint: false,
                text: 'Print',
            },
            {
              extend: 'csvHtml5',
              exportOptions: {
                    columns: [ 1, 2, 3, 4, 5, 6, 7 ],
                }
            },
            'colvis'
        ],
        select: {
            style: 'multi'
        },
        "columnDefs": [
            {"targets": [0], "searchable": false, "orderable": false, "visible": true},
            { "type": "num", "targets": 1 }
        ],
      "order": [[1, 'asc']]
    });

} );
</script>
@endsection
