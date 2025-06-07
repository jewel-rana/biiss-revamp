@extends("{$theme['default']}::layouts.master")
@section('owncss')
    <link rel="stylesheet" href="{{ asset('/date/jquery.datetimepicker.css') }}"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('/tinymce/parsley.css') }}"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('user.index') }}">Back</a>
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

    <form method="POST" action="{{ route('member.update', $member->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="employee_basic_info">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group form-float">
                                    <strong>Member ID (Account Number) <span style="color: red">*</span> :</strong>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"
                                                                           aria-hidden="true"></i></span>
                                        <input type="text" name="account_id"
                                               value="{{ old('account_id', $member->account_id) }}"
                                               placeholder="Account Number" required class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group form-float">
                                    <strong>Name <span style="color: red">*</span> :</strong>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"
                                                                           aria-hidden="true"></i></span>
                                        <input type="text" name="name" value="{{ old('name', $member->name) }}"
                                               placeholder="Name"
                                               required class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group form-float">
                                    <strong>Email <span style="color: red">*</span> :</strong>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"
                                                                           aria-hidden="true"></i></span>
                                        <input type="email" name="email" value="{{ old('email', $member->email) }}"
                                               placeholder="Email" required class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 passwordField">
                                <div class="form-group form-float">
                                    <strong>Password <span style="color: red">*</span> :</strong>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"
                                                                           aria-hidden="true"></i></span>
                                        <input type="password" name="password" placeholder="Password"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 passwordField">
                                <div class="form-group form-float">
                                    <strong>Confirm Password <span style="color: red">*</span> :</strong>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"
                                                                           aria-hidden="true"></i></span>
                                        <input type="password" name="confirm-password" placeholder="Confirm Password"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group form-float">
                                    <strong>Status <span style="color: red">*</span> :</strong>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-check"
                                                                           aria-hidden="true"></i></span>
                                        <select name="status" class="form-control">
                                            <option value="1" @if(old('status', $member->status) == 1) selected @endif>
                                                Active
                                            </option>
                                            <option value="0" @if(old('status', $member->status) == 0) selected @endif>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group form-float">
                                    <strong>Contact Number <span style="color: red">*</span> :</strong>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"
                                                                           aria-hidden="true"></i></span>
                                        <input type="text" name="contact_number"
                                               value="{{ old('contact_number', $member->contact_number) }}"
                                               placeholder="Contact number" required class="form-control">
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <strong>Address :</strong>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marker"
                                                                           aria-hidden="true"></i></span>
                                        <textarea name="address" placeholder="Address" class="form-control"
                                                  rows="6">{{ old('address', $member->address) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group form-float">
                                            <strong>Avatar :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-upload"
                                                                                   aria-hidden="true"></i></span>
                                                <input type="file" name="avatar" class="form-control" id="imgInp"
                                                       style="padding:5px;height:45px;">
                                                <small>Maximum image size is 2MP. (But don't upload very large image.
                                                    Upload below 100Kb.)</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group form-float">
                                            <img id="blah" class="img-fluid" src="{{ asset($member->avatar ?? 'default/avatar.png') }}" alt="your image"/>
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
    </form>
@endsection

@section('ownjs')
    <script>
        jQuery(function ($) {
            $('#roleSelect').on("change", function () {
                if ($(this).val() == 2) {
                    $('.passwordField').toggleClass('hide');
                }
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            readURL(this);
        });
    </script>
@endsection
