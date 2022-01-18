<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title> @lang('general.title')</title>

        <link rel="stylesheet" href="/css/app.css">

    </head>
    <body>

        <div id="app"></div>

        <script src="{{url('js')}}/jquery-3.2.1.min.js"></script>
        <script src="{{url('js')}}/bootstrap.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
    </body>
</html>
