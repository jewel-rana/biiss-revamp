@extends("{$theme['default']}::layouts.master")

@section('owncss')

@endsection

@section('content')

            <!-- begin row -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-md-12">
                    <!-- begin result-container -->
                    <div class="result-container">

                         {{ Form::open(['url' => '', 'method' => 'POST', 'id' => 'submitIssueForm']) }}
                        <div class="row" id="issueFormParent">
                            <div class="col-md-2">
                                @php
                                    $coverPhoto = ( $issue->item['cover_photo'] ) ? asset( $issue->item['cover_photo'] ) : asset('default/cover/' . strtolower( $issue->item['type'] ) . '.jpg');
                                @endphp
                                <img src="{{ $coverPhoto }}" id="coverPhoto" class="img-fluid" alt="{{ $issue->item['title'] }}">
                                <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                            </div>
                            <div class="col-md-4 basicInfo">
                                <h4>Basic Information</h4>
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <th>Item Title</th>
                                            <td>
                                                <span id="itemTitle">{{ $issue->item['title'] }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Issued To</th>
                                            <td>
                                                <span id="itemType">{{ $issue->member['name'] }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Issue Date</th>
                                            <td>
                                                <span id="itemAuthor">{{ date('d/m/Y', strtotime( $issue->start_date ) ) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Expired Date</th>
                                            <td>
                                                <span id="itemPublisher">{{ date('d/m/Y', strtotime( $issue->end_date ) ) }}</span>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <th>Late Count</th>
                                            <td>
                                                <span id="itemPublishDate">

                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Issue Status</th>
                                            <td>
                                                <span id="itemSelf"></span>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 issueInfo">
                                <h4>Re-Issue Period</h4>

                                <div class="form-group">
                                    <label>Re-Issue Days (<small>Total Days to Re-Issue</small>)</label>
                                    <input type="text" name="issueDays" placeholder="Exmple: 5" class="form-control" required="true">
                                </div>

                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitIssue">Re-Issue</button>
                                </div>


                            </div>
                            <div class="clearfix"></div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <!-- end result-container -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->


                            <!-- #modal-alert -->
                            <div class="modal fade" id="modal-alert">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Alert Header</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger m-b-0">
                                                <h5><i class="fa fa-info-circle"></i> Alert Header</h5>
                                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                                            <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Action</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

@endsection

@section('ownjs')
<script type="text/javascript" src="{{  asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    jQuery( function() {

        //submit Issue
        $('#submitIssueForm').on("submit", function( e ) {
            e.defaultPrevented;

            $.ajaxSetup({

            });

            $.ajax({
                type: "POST",
                url: "{{ url('ajax/extendIssue') }}",
                data: $(this).serialize(),
                dataType: "json",
                success: function( response ) {
                    if( response.status == true ) {
                        swal({
                            title: "Success!",
                            text: response.msg,
                            type: "success",
                        }).then((willDelete) => {
                            window.location.href = "{{ url('dashboard/issue/?type=active') }}";
                        });
                    }else {
                        swal("Sorry!", response.msg, "error");
                    }
                }
            });

            return false;
        });
    });

</script>


@endsection
