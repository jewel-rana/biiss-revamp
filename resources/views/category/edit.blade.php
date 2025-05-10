@extends('master.app')

@section('owncss')

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
<<<<<<< HEAD
=======
            <div class="pull-left">
                <h2>Category Edit</h2>
            </div>
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('category.index') }}"> Back</a>
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



{!! Form::model($item, ['method' => 'PATCH','route' => ['category.update', $item->id],'files' => true]) !!}
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="employee_basic_info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Name :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    {!! Form::text('name', $item->name, array('placeholder' => 'Name', 'required' => 'required','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group form-float">
                                <strong>Details :</strong>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
<<<<<<< HEAD
                                    {!! Form::text('details', $item->details, array('placeholder' => 'details', 'class' => 'form-control')) !!}
=======
                                    {!! Form::text('details', $item->details, array('placeholder' => 'details', 'required' => 'required','class' => 'form-control')) !!}
>>>>>>> f846c3cb8de86ea077c1e6bfb4b37842a13c0209
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


@endsection