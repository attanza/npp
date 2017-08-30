@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Hallo {{$user->first_name}},</h3>
    <p>Anda telah melakukan pembaharuan password pada {{$user->updated_at->format('d M Y')}}.</p>
    <p>
      Jika anda tidak pernah melakukan permbaharuan password ini segera lakukan <a href="{{route('password.request')}}">Reset password</a>.
    </p>
    <p>
      Untuk melanjutkan interaksi bersama <i>The Dreamers</i> lainnya silahkan kunjungi <a href="{{url('/')}}">laman kami</a>.
    </p>
  </div>
@endsection
