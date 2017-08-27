@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Hallo,</h3>
    <p>{{$subject}}, dengan tanggapan sebagai berikut:</p>
    <div class="box">
      <p><i>{!! $comment->body !!}</i></p>
    </div>
    <p>
      Klik pada link berikut untuk melihat lebih lengkap:
      <a href="{{url('/dream/'.$comment->dream->slug.'/'.$comment->id)}}">
        {{url('/dream/'.$comment->dream->slug.'/'.$comment->id)}}
      </a>
    </p>
  </div>
@endsection
