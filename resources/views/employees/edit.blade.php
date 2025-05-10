@extends('layouts.app')

@section('owncss')
    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
    <link rel="stylesheet" href="{{asset('/tinymce/parsley.css') }}" />

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Create New Employee</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('employee.index') }}"> Back</a>
            </div>
        </div>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {!! Form::model($employee, ['method' => 'PATCH','route' => ['employee.update', $employee->id],'files' => true]) !!}


        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="employee_basic_info">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4>Employee Basic Info</h4>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>First name:</strong>
                                <div class="form-line">
                                    {!! Form::text('first_name', $employee->first_name, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Middle name:</strong>
                                <div class="form-line">
                                    {!! Form::text('middle_name', $employee->middle_name, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Last name:</strong>
                                <div class="form-line">
                                    {!! Form::text('last_name', $employee->last_name, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Nationality:</strong>
                                <div class="form-line">
                                    {!! Form::text('nationality', $employee->nationality, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Birthday:</strong>
                                <div class="form-line">
                                    {!! Form::text('birthday',  $employee->birthday, array('placeholder' => '','id'=>'datetimepicker','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Gender:</strong>
                                <div class="form-line">

                                    {!! Form::select('gender', ['Male'=>'Male', 'Female'=>'Female'], ['Male'=>'Male'], array('class' => 'form-control show-tick')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>National Id:</strong>
                                <div class="form-line">
                                    {!! Form::text('national_id', $employee->national_id, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Marital status:</strong>
                                <div class="form-line">

                                    {!! Form::select('marital_status', ['Married'=>'Married', 'Single'=>'Single', 'Divorced'=>'Divorced','Widowed'=>'Widowed'], $employee->marital_status, array('class' => 'form-control show-tick')) !!}
                                </div>
                            </div>
                        </div>





                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>city:</strong>
                                <div class="form-line">
                                    {!! Form::text('city', $employee->city, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Country:</strong>
                                <div class="form-line">
                                    {!! Form::select('country', $countrylist, $employee->country, array('class' => 'form-control show-tick')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Postal code:</strong>
                                <div class="form-line">
                                    {!! Form::text('postal_code', $employee->postal_code, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Home phone:</strong>
                                <div class="form-line">
                                    {!! Form::text('home_phone', $employee->home_phone, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Mobile phone:</strong>
                                <div class="form-line">
                                    {!! Form::text('mobile_phone', $employee->mobile_phone, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Avatar:</strong>
                                <div class="form-line">
                                    {!! Form::file('avatar', null, array('class'=>'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Avatar:</strong>
                                <div class="form-line">
                                    <img class="media-object img-thumbnail" src="/uploads/profile/{{ $employee->avatar }}" width="40">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Address:</strong>
                                <div class="form-line">
                                    {!! Form::textarea('address', $employee->address, array('placeholder' => '','class' => 'form-control','id'=>'addresstextarea')) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="employee_job_info">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4>Employee Job Info</h4>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Job title:</strong>
                                    <div class="form-line">
                                        {!! Form::text('job_title', $employee->job_title, array('placeholder' => '','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Pay grade:</strong>
                                    <div class="form-line">
                                        {!! Form::text('pay_grade', $employee->pay_grade, array('placeholder' => '','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Work phone:</strong>
                                    <div class="form-line">
                                        {!! Form::text('work_phone', $employee->work_phone, array('placeholder' => '','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Private email:</strong>
                                    <div class="form-line">
                                        {!! Form::text('private_email', $employee->private_email, array('placeholder' => '','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Work email:</strong>
                                    <div class="form-line">
                                        {!! Form::text('work_email', $employee->work_email, array('placeholder' => '','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Joined date:</strong>
                                    <div class="form-line">
                                        {!! Form::text('joined_date', $employee->joined_date, array('placeholder' => '','id'=>'datetimepicker_join','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Confirmation date:</strong>
                                    <div class="form-line">
                                        {!! Form::text('confirmation_date', $employee->confirmation_date, array('placeholder' => '','id'=>'datetimepicker_confirmation','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Supervisor:</strong>
                                    <div class="form-line">


                                        {!! Form::select('supervisor', ['0' => 'Select'] + $employees, $employee->supervisor, array('class' => 'form-control show-tick')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Department:</strong>
                                    <div class="form-line">
                                        {!! Form::select('department', $departments,  $employee->department, array('class' => 'form-control show-tick')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Termination date:</strong>
                                    <div class="form-line">
                                        {!! Form::text('termination_date', $employee->termination_date, array('placeholder' => '','id'=>'datetimepicker_termination','class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Employment status:</strong>
                                    <div class="form-line">
                                        {!! Form::select('status', ['Active'=>'Active', 'Terminated'=>'Terminated'], $employee->status, array('class' => 'form-control show-tick')) !!}
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group note_form">
                                    <strong>Notes:</strong>
                                    <div class="form-line">
                                        {!! Form::textarea('notes', $employee->notes, array('placeholder' => '','class' => 'form-control','id'=>'notetextarea')) !!}
                                    </div>
                                </div>
                            </div>





                        </div>
                    </div>
                </div>
            </div>
















            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>







        {!! Form::close() !!}
@endsection


@section('ownjs')
    <script src="{{asset('/date/jquery.datetimepicker.full.js') }}"></script>

    <script>
        $('#datetimepicker').datetimepicker({
            dayOfWeekStart : 1,
            lang:'en',

        });

        $('#datetimepicker_join').datetimepicker({
            dayOfWeekStart : 1,
            lang:'en',

        });
        $('#datetimepicker_confirmation').datetimepicker({
            dayOfWeekStart : 1,
            lang:'en',

        });
        $('#datetimepicker_termination').datetimepicker({
            dayOfWeekStart : 1,
            lang:'en',

        });
    </script>


    <script src="{{asset('/tinymce/parsley.min.js') }}"></script>
    <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '#notetextarea',
            plugin: 'link code',
            menubar: false
        });

        tinymce.init({
            selector: '#addresstextarea',
            plugin: 'link code',
            menubar: false
        });
    </script>

@endsection