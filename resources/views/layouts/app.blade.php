<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:url"           content="https://www.negeriparapemimpi.com/" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Negeri Para Pemimpi" />
    <meta property="og:description"   content="Your description" />
    <meta property="og:image"         content="https://www.negeriparapemimpi.com/images/resource/apamimpimu_small.png" />

    <link rel="icon" type="image/png" href="/images/resource/ico.png">
    <title>Negeri Para Pemimpi</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/cropper.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    @yield('styles')

</head>
<body>
    <div id="app">
        @if (Auth::check())
          <user-init></user-init>
          <notification-listener username="{{Auth::user()->username}}"></notification-listener>
        @endif
        @include('layouts.partials.mainNav')
        <mobile-nav></mobile-nav>

        <div class="content-wrapper">

          @yield('content')
          @include('slots.modals')
          @include('slots.session_messages')
        </div>
    </div>
        @include('layouts.partials.footer')
        {{-- <a href="javascript:void(0)" onclick="fb_share('{{$url}}', '{{$data->title}}')" class="fbBtn">facebook</a> --}}

    <script>var baseUrl = "{{url('/')}}";</script>
    {{-- <script src="{{asset('js/global.js')}}"></script> --}}
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{asset('js/stretchy.js')}}" data-filter=".textarea" async></script>
    @yield('scripts')

</body>
</html>
