@extends("{$theme['default']}::layouts.master")
@section('owncss')

@endsection

@section('content')
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


    <div class="row">

            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="{{ url('dashboard/library/') }}" class="btn btn-xs btn-circle btn-default"><i class="fa fa-chevron-left"></i> Back to List</a>
                    </div>
<<<<<<< HEAD
                    <h4 class="panel-title">Seminar</h4>
=======
                    <h4 class="panel-title">{{ $title }}</h4>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body">
                        {!! Form::open(array('route' => 'seminar.store','method'=>'POST', 'files' => true, 'runat'=>'server')) !!}

                        {{ Form::hidden('type', 'seminar', array('id' => 'invisible_id')) }}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
                                        <strong>Seminar Title <span style="color: red">*</span> :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('title', null, array('placeholder' => 'title', 'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
<<<<<<< HEAD
                                        <strong>Tag :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {{ Form::text('taggles', null, ['class' => 'form-control', 'placeholder' => 'Exp: tag1, tag2, tag3']) }}
                                            </div>
=======
                                        <strong>Tag <span style="color: red">*</span> :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            <article class="block">
                                                <div class="input textarea clearfix exampleSeminar"></div>
                                            </article>
                                        </div>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
<<<<<<< HEAD
                                        <strong>Seminar Organizer :</strong>
=======
                                        <strong>Seminar Organizer <span style="color: red">*</span> :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('seminar_organizer', null, array('placeholder' => 'seminar organizer', 'class' => 'form-control')) !!}
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
<<<<<<< HEAD
                                        <strong>Publisher :</strong>
=======
                                        <strong>Publisher <span style="color: red">*</span> :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('publisher', null, array('placeholder' => 'publisher', 'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
<<<<<<< HEAD
                                        <strong>Year of Publication :</strong>
=======
                                        <strong>Year of Publication <span style="color: red">*</span> :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('year_of_publication', null, array('placeholder' => 'year_of_publication', 'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
<<<<<<< HEAD
                                        <strong>Copy <span style="color: red">*</span> :</strong>
=======
                                        <strong>Select Category <span style="color: red">*</span> :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::select('category[]', $category, [], array('class' => 'form-control multi-select','multiple'=>'multiple')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
                                        <strong>Copy :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('copy', null, array('placeholder' => 'copy', 'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">



                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
<<<<<<< HEAD
                                        <strong>Self :</strong>
=======
                                        <strong>Self <span style="color: red">*</span> :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('self', null, array('placeholder' => 'self', 'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
<<<<<<< HEAD
                                        <strong>Rack :</strong>
=======
                                        <strong>Rack <span style="color: red">*</span> :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('rack', null, array('placeholder' => 'rack', 'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
                                        <strong>Bibliography :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::textarea('bibliography', null, array('placeholder' => 'bibliography', 'class' => 'form-control')) !!}
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
<<<<<<< HEAD
                                            {!! Form::file('e_book', array('class'=>'form-control', 'style' => 'padding:0')) !!}
=======
                                            {!! Form::file('e_book', array('class'=>'form-control')) !!}
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-float">
<<<<<<< HEAD
                                                <strong>Seminar Cover :</strong>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                    {!! Form::file('cover_photo', array('class'=>'form-control','style'=>'padding:0')) !!}
=======
                                                <strong>Seminar Cover <span style="color: red">*</span> :</strong>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                    {!! Form::file('cover_photo', array('class'=>'form-control','id'=>'imgInpSeminar')) !!}
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                                </div>
                                            </div>
                                        </div><br />
                                        <div class="col-md-12">
                                            <div class="form-group form-float show_images">
                                                <img id="blahS" src="{{Request::root()}}/images/preview_file.png" style="width:50%" alt="your image" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>


@endsection



@section('ownjs')

<<<<<<< HEAD
  <script src="{{asset('/date/jquery.datetimepicker.full.js') }}"></script>
  <script>
      $( "#datetimepicker_join" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#datetimepicker_confirmation" ).datepicker({ dateFormat: 'yy-mm-dd' });
  </script>

=======
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
@endsection
