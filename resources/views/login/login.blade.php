@extends('layout.app')
@section('title')
login
@endsection
@section('page')

        <login-component  :routes="{{$routes}}" ></login-component >
@endsection