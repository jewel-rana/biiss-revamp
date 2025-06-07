@extends("{$theme['default']}::layouts.master")

@section('header')
    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('/tinymce/parsley.css') }}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('user.index') }}">Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('member.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="employee_basic_info">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <strong>Account Number <span class="text-danger">*</span> :</strong>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="account_id" placeholder="Account Number" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <strong>Name <span class="text-danger">*</span> :</strong>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="name" placeholder="Name" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <strong>Email <span class="text-danger">*</span> :</strong>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" placeholder="Email" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group passwordField">
                                <strong>Password <span class="text-danger">*</span> :</strong>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password" placeholder="Password" class="form-control">
                                </div>
                            </div>

                            <div class="form-group passwordField">
                                <strong>Confirm Password <span class="text-danger">*</span> :</strong>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <strong>Contact Number <span class="text-danger">*</span>:</strong>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input type="text" name="contact_number" placeholder="Contact number" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Address :</strong>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                    </div>
                                    <textarea name="address" placeholder="Address" rows="6" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Avatar :</strong>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-upload"></i></span>
                                            </div>
                                            <input type="file" name="avatar" id="imgInp" class="form-control" style="padding:5px; height:45px;">
                                        </div>
                                        <small>Maximum image size is 2MP. (Upload below 100Kb.)</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img id="blah" class="img-fluid" src="/default/avatar.png" alt="your image"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection

@section('footer')
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
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            readURL(this);
        });
    </script>
@endsection
