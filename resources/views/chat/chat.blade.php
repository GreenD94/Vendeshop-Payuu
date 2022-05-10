@extends('layout.app')
@section('title')
chat
@endsection
@section('page')

        <chat-component :user="{{$user}}" :routes="{{$routes}}" ></chat-component >
@endsection