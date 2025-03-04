@extends('appsetting::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('appsetting.name') !!}</p>
@endsection
