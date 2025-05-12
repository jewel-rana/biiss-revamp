@extends('banner::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('banner.name') !!}</p>
@endsection
