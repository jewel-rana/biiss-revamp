@extends('master.app')
<?php
use App\Category;
?>
@section('content')
    <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="{{ url('dashboard/feature/create/?type=' . $type ) }}" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Add new</a>
                    </div>
                    <h4 class="panel-title">{{ $title }}</h4>
                </div>
                <div class="panel-body">
                    
            </div>
        </div>

@endsection

@section('ownjs')



@endsection