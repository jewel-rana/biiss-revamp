@extends("{$theme['default']}::layouts.master")
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a href="{{ url('dashboard/feature/add/' . $item->id . '?type=magazine')}}" class="btn btn-primary" target="_blank"><i class="fa fa-plus"></i> Add to Top Magazine</a>
                <a class="btn btn-secondary" href="{{ url('dashboard/library/edit/' . $item->id . '?type=' . $item->type ) }}"><i class="fa fa-edit"></i> Edit</a>
                <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this item?');" href="{{ url('dashboard/library/remove/' . $item->id) }}"><i class="fa fa-times"></i> Delete</a>
                <a class="btn btn-success" href="{{ route('issue.create', $item->id) }}" target="_blank"><i class="fa fa-chevron-left"></i> Issue</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <?php
                        if( $item->cover_photo == !null){  ?>
                             <img class="media-object img-thumbnail" src="{{ asset( $item->cover_photo ) }}" style="width:350px">
                        <?php } else { ?>
                              <img class="media-object img-thumbnail" src="{{ asset('default/cover/' . strtolower( $item->type ) . '.jpg' ) }}" style="width: 100%">
                        <?php }?>
                    </a>
                    @if( $item->file == !null )
                    <div>
                        <a class="btn btn-primary" href="{{ asset( $item->file ) }}" target="_blank"><i class="fa fa-download"></i> Download E-Book</a>
                    </div>
                    @endif
                    <hr>
                    <h4>Bibliography </h4>
                    <div>
                        <p>{{ $item->bibliography }}</p>
                    </div>
                </div>
                <div class="media-body">
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th>Type</th>
                                <td>{{ ucwords( $item->type ) }}</td>
                                <th>FREQ</th>
                                <td>{{ ucwords( $item->friq ) }}</td>
                            </tr>
                            <tr>
                                <th>Title </th>
                                <td colspan="3">{{ $item->title }}</td>
                            </tr>
                            <tr>
                                <th>Authors </th>
                                <td colspan="3">
                                    @if( $item->authors )
                                    <table class="table">
                                        <tr>
                                            <th>Author Name</th>
                                            <th>Subject</th>
                                            <th>Articles</th>
                                            <th>Pages</th>
                                        </tr>
                                        @foreach( $item->authors as $author )
                                        <tr>
                                            <td>{{ $author->author_name }}</td>
                                            <td>{{ $author->auth_subject }}</td>
                                            <td>{{ $author->author_article }}</td>
                                            <td>{{ $author->pagi }}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Season </th>
                                <td>{{ $item->season }}</td>
                                <th>Month </th>
                                <td>{{ $item->month_of_publish }}</td>
                            </tr>
                            <!-- <tr>
                                <th>Authormark : </th>
                                <td>{{ $item->authormark }}</td>
                                <th>Pagination (PAGI)</th>
                                <td>{{ $item->pagination }}</td>
                            </tr> -->
                            <tr>
                                <th>Date of Publication </th>
                                <td colspan="3">{{ ( !empty( $item->accession ) && strtotime( $item->accession ) > 0 ) ? date('d/m/Y', strtotime( $item->accession ) ) : '' }}</td>
                            </tr>
                            <tr>
                                <th>Publisher </th>
                                <td>{{ $item->publisher }}</td>
                                <th>Publication Year</th>
                                <td>{{ ucwords( $item->publication_year ) }}</td>
                            </tr>
                            <tr>
                                <th>Place</th>
                                <td>{{ ucwords( $item->place ) }}</td>
                                <th>Source</th>
                                <td>{{ ucwords( $item->source ) }}</td>
                            </tr>
                            <tr>
                                <th>From</th>
                                <td>{{ ucwords( $item->from_where ) }}</td>
                                <th>Edate</th>
                                <td>{{ ( !empty( $item->created_at ) ) ? date("d/m/Y", strtotime($item->created_at ) ) : '' }}</td>
                            </tr>
                            <!-- <tr>
                                <th>Self : </th>
                                <td>{{ $item->self }}</td>
                                <th>Rack</th>
                                <td>{{ ucwords( $item->rack ) }}</td>
                            </tr> -->
                            <tr>
                                <th>Volume </th>
                                <td>{{ $item->volume_number }}</td>
                                <th>Number</th>
                                <td>{{ $item->item_number }}</td>
                            </tr>
                            <tr>
                                <!-- <th>Bill & Boucher : </th>
                                <td>{{ $item->bill_and_voucher }}</td> -->
                                <th>Remarks</th>
                                <td colspan="3">{{ $item->remarks }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if( strtolower( $item->type ) != 'seminar')
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Copy</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Issue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $item->copies->count() > 0 )
                            @foreach( $item->copies as $key => $cpy )
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $cpy->copy_number }}
                                    @if( $cpy->issued !== 2 )
                                    <a id="lostThisCopy" href="#" data-id="{{ $item->id }}" data-copy="{{ $cpy->copy_number }}"><span class="badge badge-danger">Lost this copy</span></a>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        switch( $cpy->issued ){
                                            case '1' : echo '<span class="badge badge-warning">Issued</span>';
                                            break;
                                            case '0' : echo '<span class="badge badge-success">Available</span>';
                                            break;
                                            default : echo '<span class="badge badge-info">Unknown / Lost</span>';
                                            break;
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @if( $cpy->issued == 0 )
                                        <a class="btn btn-success" href="{{ url('dashboard/issue/create/' . $item->id . '/?copy=' . $cpy->copy_number ) }}">Issue</a>
                                    @elseif( $cpy->issued == 1)
                                        <a class="btn btn-warning takeReturn" id="{{ $cpy->id }}" data-copy="{{ $cpy->copy_number }}" href="{{ url('dashboard/issue/return/' . $cpy->id . '/?copy=' . $cpy->copy_number) }}">Take Return</a>
                                    @else
                                        <span class="">This copy has been lost</span>
                                    @endif

                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-warning"><strong>Sorry!</strong> No copies found in stock.</div>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="4">
                                    <div class="float-right">
                                        <a href="#" class="btn-xs" id="addMoreCopy" data-id="{{ $item->id }}">Add more copy</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ownjs')

    <script>
        $(document).ready(function() {
            $('.takeReturn').on("click", function( e ) {
                var id = $(this).attr('id');
                var copy = $(this).attr('data-copy');
                var parent = $(this).parents('#parent');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ url('ajax/issueReturn') }}",
                    data: {id: id, copy: copy},
                    dataType: "json",
                    success: function( response ) {
                        if( response.status == true ) {
                            $(parent).remove();
                            swal("Success!", response.msg, "success").then((willDelete) =>{
                            window.location.reload();
                       });
                        }else {
                            swal("Sorry!", response.msg, "error");
                        }
                    }
                });

                return false;
            });

            $('#addMoreCopy').on("click", async function(e) {
                var id = $(this).attr('data-id');
                var url = "{{ url('ajax/dashboard/library/add-copy') }}";
                var confirmed = confirm('Are you sure to add 1 more copy in this item?');

                if( confirmed ){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {id: id},
                        dataType: "json",
                        success: function( response ) {
                            if( response.success == true ) {
                                $(parent).remove();
                                swal("Success!", response.msg, "success").then((willDelete) =>{
                                    window.location.reload();
                                });
                            }else {
                                swal("Sorry!", response.msg, "error");
                            }
                        }
                    });
                }

                return false;

            });

            $('#lostThisCopy').on("click", async function(e) {
                var id = $(this).attr('data-id');
                var copy = $(this).attr('data-copy');
                var url = "{{ url('ajax/dashboard/library/lost') }}";
                var confirmed = confirm('Are you sure lost this copy of this book?');

                if( confirmed ){
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
                        success: function( response ) {
                            if( response.success == true ) {
                                $(parent).remove();
                                swal("Success!", response.msg, "success").then((willDelete) =>{
                                    window.location.reload();
                                });
                            }else {
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
