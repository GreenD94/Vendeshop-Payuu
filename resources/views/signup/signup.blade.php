@extends('layout.app')
@section('title')
signup
@endsection
@section('page')

        <signup-component  :routes="{{$routes}}" ></signup-component >
@endsection