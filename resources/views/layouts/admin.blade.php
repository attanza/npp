<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Negeri Para Pemimpi</title>
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/cropper.min.css')}}">
  @yield('styles')

</head>
<body>
  <div id="app">
    @include('layouts.partials.mainNav')
    <section class="section" style="margin-top: -20px;">
      <div class="columns is-mobile">
        <div class="column is-one-quarter">
          @include('layouts.partials.sidebar')
        </div>
        <div class="column">
          @yield('content')
        </div>
      </div>
    </section>

    @include('slots.session_messages')
  </div>
  <script>var baseUrl = "{{url('/')}}";</script>
  <script src="{{ mix('js/app.js') }}"></script>
  <script src="{{asset('js/stretchy.js')}}" data-filter=".textarea" async></script>
  @yield('scripts')
</body>
</html>
