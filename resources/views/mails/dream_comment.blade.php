@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Hallo,</h3>
    @if ($comment->owner == $comment->dream->user)
      <p><b>{{$comment->dream->user->first_name}} {{$comment->dream->user->last_name}}</b> membalasa tanggapan mimpinya, dengan tanggapan sebagai berikut: </p>
    @else
      <p><b>{{$comment->owner->first_name}} {{$comment->owner->last_name}}</b> memberikan tanggapan mimpi yang dimiliki oleh <b>{{$comment->dream->user->first_name}} {{$comment->dream->user->last_name}}</b>, dengan tanggapan sebagai berikut: </p>
    @endif
    <p><i>"{{$comment->body}}"</i></p>
    <p>
      Klik pada link berikut untuk melihat lebih lengkap:
      <a href="{{url('/dream/'.$comment->dream->slug.'/'.$comment->id)}}">
        {{url('/dream/'.$comment->dream->slug.'/'.$comment->id)}}
      </a>
    </p>
  </div>
@endsection
