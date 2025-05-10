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
<<<<<<< HEAD
                    <h4 class="panel-title">Journal</h4>
=======
                    <h4 class="panel-title">{{ $title }}</h4>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body">
                        {!! Form::open(array('route' => 'journal.store','method'=>'POST', 'files' => true, 'runat'=>'server')) !!}

                        {{ Form::hidden('type', 'journal', array('id' => 'invisible_id')) }}
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
                                        <strong>Journal Type :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('journal_type', null, array('placeholder' => 'journal type', 'class' => 'form-control')) !!}
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
                                        <strong>Tag :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {{ Form::text('taggles', null, ['class' => 'form-control', 'placeholder' => 'Exp: Tag1, Tag2, Tag3, Tag4, Tag5']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
                                        <strong>Journal Article :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('journal_article', null, array('placeholder' => 'journal article', 'class' => 'form-control')) !!}
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

<<<<<<< HEAD
=======

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
                                        <strong>Select Category <span style="color: red">*</span> :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::select('category[]', $category, [], array('class' => 'form-control multi-select','multiple'=>'multiple')) !!}
                                        </div>
                                    </div>
                                </div>

>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
                                        <strong>Copy :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('copy', 1, array('placeholder' => 'copy', 'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group form-float">
                                        <strong>Price  :</strong>
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
                                        <strong>ISSN Number :</strong>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
                                            {!! Form::text('journal_issn', null, array('placeholder' => 'journal issn', 'class' => 'form-control')) !!}
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
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group form-float">
                                                <strong>Journal Cover :</strong>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
<<<<<<< HEAD
                                                    {!! Form::file('cover_photo', array('class'=>'form-control','style'=>'padding:0')) !!}
=======
                                                    {!! Form::file('cover_photo', array('class'=>'form-control','id'=>'imgInpJournal')) !!}
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group form-float show_images">
                                                <img id="blahJ" src="{{Request::root()}}/images/preview_file.png" style="width:50%" alt="your image" />
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

@endsection