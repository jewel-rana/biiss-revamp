@extends('master.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('book_issue.index') }}"> Back</a>
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
    {!! Form::open(array('route' => 'banners.store','method'=>'POST', 'files' => true, 'runat'=>'server')) !!}

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="employee_basic_info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">


                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>About Photo :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                    {!! Form::textarea('details', null, array('placeholder' => 'Details','class' => 'form-control','rows'=>6)) !!}
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group form-float">
                                        <strong>Banner Photo <span style="color: red">*</span> :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-upload" aria-hidden="true"></i></span>
                                            {!! Form::file('banner_image', array('class'=>'form-control','required' => 'required','id'=>'imgInp')) !!}

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group form-float">
                                        <img id="blah" src="{{Request::root()}}/images/preview_file.png" alt="your image" />
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