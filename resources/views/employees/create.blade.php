

@extends('layouts.app')
@section('owncss')
    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
    <link rel="stylesheet" href="{{asset('/tinymce/parsley.css') }}" />

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Create New Employee</h3>
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
    {!! Form::open(array('route' => 'employee.store','method'=>'POST', 'files' => true)) !!}
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
                                {!! Form::text('first_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Middle name:</strong>
                            <div class="form-line">
                                {!! Form::text('middle_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Last name:</strong>
                            <div class="form-line">
                                {!! Form::text('last_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Nationality:</strong>
                            <div class="form-line">
                                {!! Form::text('nationality', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Birthday:</strong>
                            <div class="form-line">
                                {!! Form::text('birthday', null, array('placeholder' => '','id'=>'datetimepicker','class' => 'form-control')) !!}
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
                                {!! Form::text('national_id', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Marital status:</strong>
                            <div class="form-line">

                                {!! Form::select('marital_status', ['Married'=>'Married', 'Single'=>'Single', 'Divorced'=>'Divorced','Widowed'=>'Widowed'], ['Widowed'=>'Widowed'], array('class' => 'form-control show-tick')) !!}
                            </div>
                        </div>
                    </div>





                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>city:</strong>
                            <div class="form-line">
                                {!! Form::text('city', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Country:</strong>
                            <div class="form-line">
                               {!! Form::select('country', $countrylist, null, array('class' => 'form-control show-tick')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Postal code:</strong>
                            <div class="form-line">
                                {!! Form::text('postal_code', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Home phone:</strong>
                            <div class="form-line">
                                {!! Form::text('home_phone', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Mobile phone:</strong>
                            <div class="form-line">
                                {!! Form::text('mobile_phone', null, array('placeholder' => '','class' => 'form-control')) !!}
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

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Address:</strong>
                            <div class="form-line">
                                {!! Form::textarea('address', null, array('placeholder' => '','class' => 'form-control','id'=>'addresstextarea')) !!}
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
                                    {!! Form::text('job_title', null, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Pay grade:</strong>
                                <div class="form-line">
                                    {!! Form::text('pay_grade', null, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Work phone:</strong>
                                <div class="form-line">
                                    {!! Form::text('work_phone', null, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Private email:</strong>
                                <div class="form-line">
                                    {!! Form::text('private_email', null, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Work email:</strong>
                                <div class="form-line">
                                    {!! Form::text('work_email', null, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Joined date:</strong>
                                <div class="form-line">
                                    {!! Form::text('joined_date', null, array('placeholder' => '','id'=>'datetimepicker_join','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Confirmation date:</strong>
                                <div class="form-line">
                                    {!! Form::text('confirmation_date', null, array('placeholder' => '','id'=>'datetimepicker_confirmation','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Supervisor:</strong>
                                <div class="form-line">

                                    {!! Form::select('supervisor', ['0' => 'Select'] + $employees, null, array('class' => 'form-control show-tick')) !!}

                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Department:</strong>
                                <div class="form-line">
                                   {!! Form::select('department', $departments, null, array('class' => 'form-control show-tick')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Termination date:</strong>
                                <div class="form-line">
                                    {!! Form::text('termination_date', null, array('placeholder' => '','id'=>'datetimepicker_termination','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Employment status:</strong>
                                <div class="form-line">
                                    {!! Form::select('status', ['Active'=>'Active', 'Terminated'=>'Terminated'], ['Active'=>'Active'], array('class' => 'form-control show-tick')) !!}
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group note_form">
                                <strong>Notes:</strong>
                                <div class="form-line">
                                    {!! Form::textarea('notes', null, array('placeholder' => '','class' => 'form-control','id'=>'notetextarea')) !!}
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






