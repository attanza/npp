<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Negeri Para Pemimpi</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('styles')

</head>
<body>
    <div id="app">
        @if (Auth::check())
          <user-init :user="{{Auth::user()}}"></user-init>
          <notification-listener username="{{Auth::user()->username}}"></notification-listener>
        @endif
        @include('layouts.partials.mainNav')
        {{-- @include('slots.mobile_nav') --}}
        <mobile-nav></mobile-nav>
        @yield('content')
        @include('slots.session_messages')
        @include('layouts.partials.footer')
    </div>
    <script>var baseUrl = "{{url('/')}}"</script>
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scripts')

</body>
</html>
