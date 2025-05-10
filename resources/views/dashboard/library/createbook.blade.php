@extends('master.app')
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
                    <h4 class="panel-title">{{ $title }}</h4>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body">
                        {!! Form::open(array('route' => 'book.store','method'=>'POST', 'files' => true, 'runat'=>'server')) !!}

                        {{ Form::hidden('type', 'book', array('id' => 'invisible_id')) }}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Origin :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::select('origin', ['local'=>'local','international'=>'international'], ['local'=>'local'], array('class' => 'form-control show-tick')) !!}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Tag :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {{ Form::text('taggles', null, ['class' => 'form-control', 'placeholder' => 'Exp: tag1, tag2, tag3']) }}
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Title <span style="color: red">*</span> :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('title', null, array('placeholder' => 'title', 'class' => 'form-control')) !!}
                                                <!-- {{ Form::hidden('subject', 'abc') }} -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Author :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('author', null, array('placeholder' => 'author', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Author type :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('author_type', null, array('placeholder' => 'author type', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Edition :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('edition', null, array('placeholder' => 'edition', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Publisher :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('publisher', null, array('placeholder' => 'publisher', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Year of Publication :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('year_of_publication', null, array('placeholder' => 'year of publication', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Illustration :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('illustration', null, array('placeholder' => 'illustration', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Volume :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('volume', null, array('placeholder' => 'volume', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Series :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('series', null, array('placeholder' => 'series', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
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
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('copy', null, array('placeholder' => 'copy', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Price :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('price', null, array('placeholder' => 'price', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Currency :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('currency', null, array('placeholder' => 'currency', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>ISBN :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('isbn', null, array('placeholder' => 'isbn', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Source :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('source', null, array('placeholder' => 'source', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Self :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('self', null, array('placeholder' => 'self', 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Rack :</strong>
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
                                            <strong>Date of Accusation :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::text('date_of_accusation', null, array('placeholder' => 'date of accusation', 'class' => 'form-control','id' => 'datetimepicker_join')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>Abstraction :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::textarea('abstraction', null, array('placeholder' => 'abstraction','class' => 'form-control','rows'=>6)) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group form-float">
                                            <strong>PDF :</strong>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                {!! Form::file('e_book', array('class'=>'form-control', 'style' => 'padding:0')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12">
                                                <div class="form-group form-float">
                                                    <strong>Book Cover :</strong>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                                        {!! Form::file('cover_photo', array('class'=>'form-control','id'=>'imgInp')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12">
                                                <div class="form-group form-float show_images">
                                                    <img id="blah" src="{{Request::root()}}/images/preview_file.png" style="width:50%" alt="your image" />
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

  <script src="{{asset('/date/jquery.datetimepicker.full.js') }}"></script>
  <script>
      $( "#datetimepicker_join" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#datetimepicker_confirmation" ).datepicker({ dateFormat: 'yy-mm-dd' });
  </script>
  
@endsection