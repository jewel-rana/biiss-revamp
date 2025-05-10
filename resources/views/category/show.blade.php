@extends('master.app')
<?php

?>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Category Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('category.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="media">

                <div class="media-body">
                    <dl class="dl-horizontal">

                        <dt>Name : </dt>
                        <dd>{{ $item->name }}</dd>


                        <dt>Details : </dt>
                        <dd>{{ $item->details }}</dd>

                    </dl>
                </div>
            </div>



        </div>
    </div>
@endsection