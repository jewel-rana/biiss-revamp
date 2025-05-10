@extends('master.app')
@section('owncss')

<<<<<<< HEAD
<link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />

=======
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
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
<<<<<<< HEAD
                                <strong>Origin :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::select('origin', ['local'=>'local','international'=>'international'], ['local'=>'local'], array('class' => 'form-control show-tick')) !!}
                                    {{ Form::hidden('type', 'book') }}
=======
                                <strong>Origin <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::select('origin', ['local'=>'local','international'=>'international'], ['local'=>'local'], array('class' => 'form-control show-tick')) !!}
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Title <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('title', null, array('placeholder' => 'title', 'class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Author <span style="color: red">*</span> :</strong>
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
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>

                                    {!! Form::select('category[]', $category,json_decode($book->category), array('class' => 'form-control multi-select','multiple'=>'multiple')) !!}

                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
<<<<<<< HEAD
                                <strong>Copy <span style="color: red">*</span> :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('copy', null, array('placeholder' => 'copy', 'class' => 'form-control')) !!}
=======
                                <strong>Copy :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('copy', null, array('readonly','placeholder' => 'copy', 'class' => 'form-control')) !!}
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
<<<<<<< HEAD
                                <strong>Price  :</strong>
=======
                                <strong>Price <span style="color: red">*</span> :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('price', null, array('placeholder' => 'price', 'class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
<<<<<<< HEAD
                                <strong>Currency  :</strong>
=======
                                <strong>Currency <span style="color: red">*</span> :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
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
<<<<<<< HEAD
                                <strong>ISBN :</strong>
=======
                                <strong>ISBN <span style="color: red">*</span> :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('isbn', null, array('placeholder' => 'isbn', 'class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
<<<<<<< HEAD
                                <strong>Source :</strong>
=======
                                <strong>Source <span style="color: red">*</span> :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    {!! Form::text('source', null, array('placeholder' => 'source', 'class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

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
<<<<<<< HEAD
                                <strong>Date of Accusation :</strong>
=======
                                <strong>Date of Accusation <span style="color: red">*</span> :</strong>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
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
                                <strong>E-book :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-upload" aria-hidden="true"></i></span>
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
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group form-float">
<<<<<<< HEAD
                                        <strong>book cover :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-upload" aria-hidden="true"></i></span>
                                            {!! Form::file('cover_photo', array('class'=>'form-control','style'=>'padding:0')) !!}
=======
                                        <strong>book cover <span style="color: red">*</span> :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-upload" aria-hidden="true"></i></span>
                                            {!! Form::file('cover_photo', array('class'=>'form-control','id'=>'imgInp')) !!}
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209

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


<<<<<<< HEAD
@section('ownjs')

  <script src="{{asset('/date/jquery.datetimepicker.full.js') }}"></script>
  <script>
      $( "#datetimepicker_join" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#datetimepicker_confirmation" ).datepicker({ dateFormat: 'yy-mm-dd' });
  </script>
=======

@section('ownjs')


>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209

@endsection