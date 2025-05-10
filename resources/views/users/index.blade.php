@extends('master.app')
<?php
use App\BookIssue;

?>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('users.create') }}"> Create new member</a>
            </div>
        </div>
    </div>
    <!----------------------search start-------------------------->
    <div class="row">
        <div class="col-lg-4">
            {!! Form::open(array('route' => 'users.index','method'=>'GET')) !!}
            <div class="input-group">
                {!! Form::text('search', null, array('placeholder' => 'Search for...','class' => 'form-control')) !!}
                <span class="input-group-btn">
                 {!! Form::submit('Go!', ['class' => 'btn btn-default']) !!}
                </span>
            </div><!-- /input-group -->
            {!! Form::close() !!}
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
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th width="5%">Member ID</th>
                        <th width="15%">Name</th>
                        <th width="25%">Email</th>
                        <th width="10%">Contact Number</th>
                        <th width="5%">Roles</th>
                        <th width="10%">Book Issues</th>
                        <th width="10%">Address</th>
                        <th width="5%">Avatar</th>
                        <th width="10%">Action</th>
                    </tr>
                    @foreach ($members as $key => $member)
                        <tr>
                            <td>{{ $member->account_id }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->contact_number }}</td>
                            <td>
                                @if(!empty($member->roles))
                                    @foreach($member->roles as $v)
                                        <label class="label label-success" style="width: 75px;display: inline-block;">{{ $v->display_name }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.show',$member->id) }}?tab=history"> 
                                    {{ $member->issued_books_count }} Books
                                </a>
                            </td>

                            <td>{{ $member->address }}</td>
                            <td>
                                <?php if($member->avatar !=''){
                                ?>
                                    <img src="{{Request::root()}}/uploads/profile/{{ $member->avatar }}" width="60" height="45">
                                <?php
                                }else{
                                 ?>
                                    <img src="{{ asset('default/avatar.png') }}" width="60" height="45">

                                <?php
                                }

                                ?>


                            </td>




                            <td>
                            <div class="btn-group">
                                <a class="btn btn-sm btn-info" href="{{ route('users.show',$member->id) }}">Show</a>
                                <a class="btn btn-sm btn-warning" href="{{ route('users.edit',$member->id) }}">Edit</a>
                                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $member->id],'style'=>'display:inline', 'class'=>'delete']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                                {!! Form::close() !!}
                            </div>
                            </td>
                        </tr>
                    @endforeach
                </table>

                    {!! $members->appends(Request::except('page'))->render() !!}
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