@extends('master.app')
@section('owncss')
    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('/tinymce/parsley.css') }}" />

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
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
    {!! Form::model($member, ['method' => 'PATCH','route' => ['users.update', $member->id],'files' => true]) !!}

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="employee_basic_info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Select Role <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    {!! Form::select('roles[]', $roles,[], array('required' => 'required','class' => 'form-control', 'id' => 'roleSelect', 'style' => 'padding:5px;font-size:17px;height:45px;')) !!}
                                </div>
                            </div>
                        </div>

                         <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Account Number <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                     {!! Form::text('account_id', $member->account_id, array('placeholder' => 'Account Number', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                         <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Name <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                     {!! Form::text('name', $member->name, array('placeholder' => 'Name', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Email <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                    {!! Form::text('email', $member->email, array('placeholder' => 'Email', 'required' => 'required','class' => 'form-control')) !!}

                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 passwordField">
                            <div class="form-group form-float">
                                <strong>Password <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-key" aria-hidden="true"></i></span>
                                    {!! Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control')) !!}

                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 passwordField">
                            <div class="form-group form-float">
                                <strong>Confirm Password <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-key" aria-hidden="true"></i></span>
                                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}

                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Contact Number <span style="color: red">*</span>:</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    {!! Form::text('contact_number', $member->contact_number, array('placeholder' => 'Contact number', 'required' => 'required','class' => 'form-control')) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Address :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                    {!! Form::textarea('address', $member->address, array('placeholder' => 'Address','class' => 'form-control','rows'=>6)) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group form-float">
                                        <strong>Avatar :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-upload" aria-hidden="true"></i></span>
                                            {!! Form::file('avatar', array('class'=>'form-control','id'=>'imgInp', 'style' => 'padding:5px;height:45px;')) !!}
                                            <small>Maximum image size is 2MP. (But don't upload very large image. Upload below 100Kb.)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group form-float">
                                       <img class="img-fluid" src="{{Request::root()}}/images/preview_file.png" alt="your image" />
                                    </div>
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

  <script>
    //jquery
    jQuery( function( $ ) {
        $('#roleSelect').on("change", function( e ) {
            if( $(this).val() == 2 ) {
                $('.passwordField').toggleClass('hide');
            }
        })
    });

    function readURL(input) {

        if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
     });

  </script>

@endsection