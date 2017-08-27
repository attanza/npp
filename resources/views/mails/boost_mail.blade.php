@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Hallo {{$dream->user->first_name}}</h3>
    <p>{{$subject}}.</p>
    <p>
      Klik pada link berikut untuk menuju laman mimpimu:
      <a href="{{route('dream.show', $dream->slug)}}">
        {{route('dream.show', $dream->slug)}}
      </a>
    </p>
  </div>
@endsection
