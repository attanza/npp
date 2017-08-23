@extends('layouts.app')
@section('content')
<section class="section">
  <div class="container">
    <div class="columns">
      <div class="column">
        <dream-photo :dream="{{$dream}}"></dream-photo>
      </div>{{-- column --}}

      <div class="column">
        <dream-comments :dream="{{$dream}}"></dream-comments>
      </div>{{-- card --}}
    </div>{{-- column --}}
  </div>{{-- container --}}
</section>
@endsection
@section('styles')
  <style media="screen">
    .media-left .image img {
      border-radius: 50%;
    }
  </style>
@endsection
