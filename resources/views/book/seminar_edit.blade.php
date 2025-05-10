@extends('master.app')
@section('owncss')
    <link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="{{asset('/css/select2.min.css') }}" />
    <style>
        .show_images img{
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Seminar</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('book.index') }}"> Back</a>
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

    {!! Form::model($book, ['method' => 'PATCH','route' => ['book.update', $book->id],'files' => true]) !!}


    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="employee_basic_info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Seminar Title <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('title', null, array('placeholder' => 'title', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Seminar Organizer <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('seminar_organizer', null, array('placeholder' => 'seminar organizer', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Seminar Place :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('seminar_place', null, array('placeholder' => 'seminar place', 'class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Seminar Rapporteurs :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('seminar_rapporteurs', null, array('placeholder' => 'seminar rapporteurs', 'class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>



                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Publisher <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('publisher', null, array('placeholder' => 'publisher', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Year of Publication <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('year_of_publication', null, array('placeholder' => 'year_of_publication', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Select Category <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>

                                    {!! Form::select('category[]', $category,json_decode($book->category), array('required' => 'required','class' => 'form-control multi-select','multiple'=>'multiple')) !!}

                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Copy :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('copy', null, array('readonly','placeholder' => 'copy', 'class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">



                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Self <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('self', null, array('placeholder' => 'self', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Rack <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('rack', null, array('placeholder' => 'rack', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Bibliography :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('bibliography', null, array('placeholder' => 'bibliography', 'class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Seminar Summary :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::textarea('abstraction', null, array('placeholder' => 'seminar summary','class' => 'form-control','rows'=>6)) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>PDF :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::file('e_book', array('class'=>'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group form-float">
                                        <strong>Seminar Cover <span style="color: red">*</span> :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::file('cover_photo', array('class'=>'form-control','id'=>'imgInpSeminar')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group form-float show_images">
                                        <img id="blahS" src="{{Request::root()}}/images/preview_file.png" alt="your image" />
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
        $('#blahS').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInpSeminar").change(function() {
        readURL(this);
     });

  </script>


  <script src="{{asset('/js/select22.min.js')}}"></script>
  <script type="text/javascript">
      $(".multi-select").select2();
  </script>

  <script src="{{asset('/date/jquery.datetimepicker.full.js') }}"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
      $( "#datetimepicker_join" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#datetimepicker_confirmation" ).datepicker({ dateFormat: 'yy-mm-dd' });
  </script>

@endsection