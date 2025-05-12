@extends("{$theme['default']}::layouts.master")

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('season.create') }}"> Create new season</a>
            </div>
        </div>
    </div>
    <!----------------------search start-------------------------->
    <div class="row">
        <div class="col-lg-4">
            <form action="{{ route('season.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" placeholder="Search for..." class="form-control">
                    <span class="input-group-btn"><button type="submit" class="btn btn-default">Go!</button></span>
                </div><!-- /input-group -->
            </form>

        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    <!----------------------search end-------------------------->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th width="280px">Action</th>
                    </tr>
                    @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <a class="btn btn-primary"
                                   href="{{ route('season.edit',$item->id) }}">Edit</a>
                                <form action="{{ route('season.destroy', $item->id) }}" method="POST" style="display:inline" class="delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </table>

                {!! $items->appends(Request::except('page'))->render() !!}
            </div>
        </div>
    </div>

@endsection

@section('ownjs')
    <script>
        $(".delete").on("submit", function () {
            return confirm("Do you want to delete this?");
        });
    </script>
@endsection
