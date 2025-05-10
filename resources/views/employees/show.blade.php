@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Employee Profile</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('employee.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                       <img class="media-object img-thumbnail" src="/uploads/profile/{{ $employee->avatar }}" width="350">
                    </a>
                </div>
                <div class="media-body">
                    <dl class="dl-horizontal">
                        <dt>Full Name</dt>
                        <dd>{{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</dd>

                        <dt>Nationality</dt>
                        <dd>{{ $employee->nationality }}</dd>

                        <dt>National id</dt>
                        <dd>{{ $employee->national_id }}</dd>

                        <dt>Job title</dt>
                        <dd>{{ $employee->job_title }}</dd>

                        <dt>Address</dt>
                        <dd>{{ strip_tags($employee->address) }}</dd>

                        <dt>City</dt>
                        <dd>{{ $employee->city }}</dd>

                        <dt>Home phone</dt>
                        <dd>{{ $employee->home_phone }}</dd>

                        <dt>Department</dt>
                        <dd>{{ $employee->department }}</dd>

                        <dt>Work email</dt>
                        <dd>{{ $employee->work_email }}</dd>

                        <dt>Notes</dt>
                        <dd>{{ strip_tags($employee->notes) }}</dd>

                        <dt>supervisor</dt>
                        <dd>{{ $employee->supervisor }}</dd>

                        <dt>Joined date</dt>
                        <dd>{{ $employee->joined_date }}</dd>

                        <dt>Termination_date</dt>
                        <dd>{{ $employee->termination_date }}</dd>



                    </dl>
                </div>
            </div>









        </div>
    </div>
@endsection