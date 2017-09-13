@extends('layouts.app')
@section('content')
<section class="section">
  <div class="container">
    <div class="columns">
      <div class="column">
        <dream-photo :dream="{{$dream}}"></dream-photo>
        <div class="columns m-t-10">
          <div class="column">
            <boost :dream_id="{{$dream->id}}"></boost>
          </div>{{-- column --}}
        </div>{{-- columns m-t-1 --}}
      </div>{{-- column --}}

      <div class="column">
        <div class="box">
          <dream-comments :dream="{{$dream}}"></dream-comments>
        </div>
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
