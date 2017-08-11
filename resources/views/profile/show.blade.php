@extends('layouts.app')
@section('content')
  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="column">
          <avatar :profile="{{$user->profile}}"></avatar>
        </div>
        <div class="column">
          <profile-info :user_data="{{$user}}"></profile-info>
        </div>{{-- column --}}
      </div>{{-- columns --}}
    </div>{{-- container --}}
  </section>
@endsection
@section('scripts')
  <script src="{{asset('js/stretchy.js')}}" data-filter=".textarea" async></script>
@endsection
@section('styles')
  <link rel="stylesheet" href="{{asset('css/cropper.min.css')}}">
@endsection
