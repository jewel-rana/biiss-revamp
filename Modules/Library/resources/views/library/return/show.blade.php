@extends("{$theme['default']}::layouts.master")

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('return.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="media">
                <div class="media-left">
                    @if( $return->item['cover_photo'] != null )
                    <a href="#">
                        <img class="media-object img-thumbnail" src="{{ asset( $return->item['cover_photo'] ) }}" width="350">
                    </a>
                    @else
                        <img class="media-object img-thumbnail" src="{{ asset('default/cover/' . strtolower( $return->item['type'] ) . '.jpg') }}" width="350">
                    @endif
                </div>
                <div class="media-body">
                    <dl class="dl-horizontal">
                        <table class="table table-bordered table-condensed table-striped">
                            <tbody>
                                <tr>
                                    <th>Title : </th>
                                    <td>
                                        <a href="{{ route('library.show', $return->item['id']) }}" target="_blank">
                                            {{ $return->item['title'] }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Member Name : </th>
                                    <td>
                                        <a href="{{ route('user.show', $return->member['id']) }}" target="_blank">
                                            {{ $return->member['name'] }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Copy Number : </th>
                                    <td>{{ $return->issue['stock']['copy_number'] }}</td>
                                </tr>
                                <tr>
                                    <th>Issue Date : </th>
                                    <td>{{ date('d-m-Y', strtotime( $return->issue['start_date']) ) }}</td>
                                </tr>
                                <tr>
                                    <th>Return Expire Date : </th>
                                    <td>{{ date('d-m-Y', strtotime( $return->issue['end_date']) ) }}</td>
                                </tr>
                                <tr>
                                    <th>Return Date : </th>
                                    <td>{{ date('d-m-Y h:i a', strtotime( $return->return_date) ) }}</td>
                                </tr>
                                <tr>
                                    <th>Late Count : </th>
                                    <td>{{ $return->late_count }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
