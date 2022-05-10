<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, user-scalable=no, shrink-to-fit=no" />
    <meta name="HandheldFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{config('app.description')}}">
    <meta name="author" content="{{config('app.author')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') | {{config('app.name')}}</title>
    @yield('css')
    @stack('scripts')

</head>
<body>
        <div id="app">
            @yield('page')                  
        </div>   
  
    <script >
        window.Laravel = {
            csrfToken:  "{{ csrf_token() }}",
        }
    </script>
    <script src="{{mix('/js/app.js')}}"></script>
    @yield('vue')
    @yield('extra')
    @stack('modal')

</body>

</html>
