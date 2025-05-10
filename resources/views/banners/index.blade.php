@extends('master.app')
<?php
use App\User;
?>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('banners.create') }}">New Banner</a>
            </div>
        </div>
    </div>

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
                        <th>Banner Photo</th>
                        <th>About Photo</th>

                        <th width="280px">Action</th>
                    </tr>
                    @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ ++$i }}</td>

                            <td><img src="{{Request::root()}}/uploads/banners/{{ $item->value }}" width="160" height="45"></td>

                            <td>{{ $item->details }}</td>



                            <td>
                                {!! Form::open(['method' => 'DELETE','route' => ['banners.destroy', $item->id],'style'=>'display:inline', 'class'=>'delete']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
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
        $(".delete").on("submit", function(){
            return confirm("Do you want to delete this?");
        });
    </script>
@endsection