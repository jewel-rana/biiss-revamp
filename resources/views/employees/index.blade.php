@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Employees Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('employee.create') }}"> Create New Employee</a>
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
                        <th>Employee Fullname</th>
                        <th>Nationality</th>
                        <th>Job title</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Mobile Number</th>

                        <th>Profile</th>
                        <th width="280px">Action</th>
                    </tr>
                    @foreach ($employees as $key => $employee)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</td>
                            <td>{{ $employee->nationality }}</td>
                            <td>{{ $employee->job_title }}</td>
                            <td>{{ $employee->city }}</td>
                            <td>{{ $employee->country }}</td>
                            <td>{{ $employee->mobile_phone }}</td>

                            <td><img src="/uploads/profile/{{ $employee->avatar }}" width="60"></td>

                            <td>
                                <a class="btn btn-info" href="{{ route('employee.show',$employee->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('employee.edit',$employee->id) }}">Edit</a>




                                @permission('employee-delete')

                                {!! Form::open(['method' => 'DELETE','route' => ['employee.destroy', $employee->id],'style'=>'display:inline','class'=>'delete']) !!}

                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                                {!! Form::close() !!}

                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                </table>

                    {!! $employees->appends(Request::except('page'))->render() !!}
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