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
