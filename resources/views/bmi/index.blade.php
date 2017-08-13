@extends('layouts.app')
@section('content')
  <section class="section body-bg-bmi-image">
    <div class="container">
      @include('slots.home_head_section')
    </div>
  </section>
  <section class="section">
    <div class="container">
      <dream-list></dream-list>
    </div>
  </section>
@endsection
@section('styles')
  <style>
    .body-bg-bmi-image{
      background-image: linear-gradient(rgba(0,0,0,0.0),rgba(0,0,0,0.0)), url(../images/resource/bg_bmi.png);
      background-position: center;
      background-size: 100% 100%;
      /*height: 50vh;*/
      overflow: visible;
    }
  </style>
@endsection
