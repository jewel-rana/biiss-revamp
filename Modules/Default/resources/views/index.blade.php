@extends('default::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('default.name') !!}</p>
@endsection
