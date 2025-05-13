@extends("{$theme['default']}::layouts.master")

@section('owncss')

    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}">
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <table class="table table-bordered" id="myDataTable">
                    <thead>
                    <tr>
                        <th data-orderable="false">No</th>
                        <th>Title</th>
                        <th>Copy</th>
                        <th style="width:90px;">Issued By</th>
                        <th style="width:120px;">Member Name</th>
                        <th style="width:120px;">Issue Date</th>
                        <th style="width:120px;">Return Date</th>
                        <th>Late</th>
                        <th width="120px" data-orderable="false">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( !empty( $items ) && $items->count() > 0 )
                        @php $i = 1; @endphp
                        @foreach( $items as $item )

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <a href="{{ route('library.show', $item->item_id ) }}" target="_blank">
                                        {{ $item->item?->title }}
                                    </a>
                                </td>
                                <td><?php echo $item->issue?->stock?->copy_number; ?></td>

                                <td>
                                    @if($item->member)
                                        <a href="{{ route('member.show', $item->member?->id ) }}"
                                           target="_blank">
                                            {{ $item->member?->name }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if($item->admin)
                                        <a href="{{ route('user.show', $item->admin?->id ) }}"
                                           target="_blank">
                                            {{ $item->admin?->name }}
                                        </a>
                                    @endif
                                </td>
                                <td>{{ date('d-m-Y', strtotime( $item->issue?->start_date ) ) }}</td>
                                <td>{{ date('d-m-Y h:i a', strtotime( $item->return_date ) ) }}</td>
                                <td>{{ $item->late_count }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('return.show', $item->id) }}"
                                       target="_blank">Show</a>
                                    <form action="{{ route('return.destroy', $item->id) }}" method="POST"
                                          style="display:inline" class="delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                {{-- {!! $items->appends(Request::except('page'))->render() !!} --}}
            </div>
        </div>
    </div>

@endsection

@section('ownjs')
    <script type="text/javascript" href="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{asset('/date/jquery.datetimepicker.full.js') }}"></script>

    <script type="text/javascript" src="{{  asset('plugins/DataTables-1.10.18/js/jquery.dataTables.js') }}"></script>

    <script type="text/javascript"
            src="{{  asset('plugins/DataTables-1.10.18/js/dataTables.bootstrap4.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    <script>
        $(document).ready(function () {
            $('#myDataTable_filter input[name=search]').datepicker();
            $('#myDataTable').dataTable();
            $(".delete").on("submit", function () {
                return confirm("Do you want to delete this?");
            });
        });
    </script>
@endsection
