@extends("{$theme['default']}::layouts.master")

@section('owncss')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}">
    @section('ownjs')

        @section('content')

            <!-- begin row -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-lg-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <!-- begin panel-heading -->
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="{{ route('issue.create') }}" class="btn btn-xs btn-circle btn-default"><i
                                        class="fa fa-plus"></i> Issue new item</a>
                            </div>
                            <h4 class="panel-title">{{ $title }}</h4>
                        </div>
                        <!-- end panel-heading -->
                        <!-- begin panel-body -->
                        <div class="panel-body">
                            <div>
                                <table id="myDataTable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="1%" data-orderable="false">
                                            <i class="fa fa-image"></i>
                                        </th>
                                        <th class="text-nowrap col-md-2">Name or Title</th>
                                        <th class="text-nowrap">Copy</th>
                                        <th class="text-nowrap">Author</th>
                                        <th class="text-nowrap">Member</th>
                                        <th class="text-nowrap">Issued</th>
                                        <th class="text-nowrap">Expire</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Type</th>
                                        <th class="text-nowrap col-md-1" data-orderable="false">
                                            <i class="fa fa-cog"></i>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if( $issues->count() > 0 )
                                        @foreach($issues as $issue)
                                            <tr class="odd gradeX" id="parent">
                                                <td>
                                                    <img src="{{ $issue->item?->cover_photo }}" class="img-fluid"
                                                         alt="{{ $issue->issue?->title ?? 'Cover photo' }}"/>
                                                </td>
                                                <td>
                                                    <a href="{{ route('library.show', $issue->item_id ) }}"
                                                       target="_blank">
                                                        {{ ucwords( $issue->item?->title ) }}
                                                    </a>
                                                    @if( strtolower( $issue->item?->type ) == 'journal')
                                                        <hr>
                                                        <strong>Bundle : </strong> {{ $issue->bundle }}
                                                    @endif
                                                </td>
                                                <td>{{ $issue->stock?->copy_number }}</td>
                                                <td>
                                                    @if( $issue->item?->authors )
                                                        @foreach( $issue->item?->authors as $author )
                                                            <span
                                                                class="badge badge-info mb-2">{{ ucwords( $author->author_name ) }}</span>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($issue->member)
                                                        <a href="{{ route('user.show',$issue->member?->id) }}"
                                                           target="_blank">{{ ucwords( $issue->member?->name ) }}</a>
                                                    @endif
                                                </td>
                                                <td>{{ date('d/m/Y', strtotime( $issue->start_date ) ) }}</td>
                                                <td>{{ date('d/m/Y', strtotime( $issue->end_date ) ) }}</td>
                                                <td>
                                                    @php
                                                        if( $issue->end_date < date('Y-m-d') ) :
                                                            echo 'Expired';
                                                        else :
                                                            echo 'Active';
                                                        endif;
                                                    @endphp
                                                </td>
                                                <td>{{ $issue->item?->type }}</td>
                                                <td>
                                                    <a href="{{ url('dashboard/issue/extend/' . $issue->id ) }}"
                                                       class="btn btn-sm btn-block mb-2 btn-info" title="Re-Issue">
                                                        <i class="fa fa-redo"></i> Re-issue
                                                    </a>
                                                    <a href="{{ url('dashboard/issue/return/' . $issue->id ) }}"
                                                       class="btn btn-sm btn-block btn-success takeReturn"
                                                       id="{{ $issue->stock?->id }}"
                                                       data-copy="{{ $issue->stock?->copy_number }}"
                                                       data-url="{{ route('issue.return', $issue->id) }}"
                                                       title="Take Return">
                                                        <i class="fa fa-check"></i> Take Return
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endsection

        @section('ownjs')
            <!-- ================== BEGIN PAGE LEVEL JS ================== -->

            <script type="text/javascript"
                    src="{{  asset('plugins/DataTables-1.10.18/js/jquery.dataTables.js') }}"></script>

            <script type="text/javascript"
                    src="{{  asset('plugins/DataTables-1.10.18/js/dataTables.bootstrap4.js') }}"></script>
            <script type="text/javascript"
                    src="{{  asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
            <!-- ================== END PAGE LEVEL JS ================== -->
            <script>
                $(document).ready(function () {
                    $('#myDataTable').dataTable();
                    $('.takeReturn').on("click", function (e) {
                        var id = $(this).attr('id');
                        var copy = $(this).attr('data-copy');
                        var parent = $(this).parents('#parent');
                        let url = $(this).data('url');

                        var confirmed = confirm('Are you sure to take return of this Item.');

                        if (confirmed == true) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "POST",
                                url: url,
                                data: {id: id, copy: copy},
                                dataType: "json",
                                success: function (response) {
                                    if (response.status == true) {
                                        $(parent).remove();
                                        swal("Success!", response.msg, "success");
                                    } else {
                                        swal("Sorry!", response.msg, "error");
                                    }
                                }
                            });
                        }

                        return false;
                    });
                });
            </script>
        @endsection
