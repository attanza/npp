@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Hallo,</h3>
    <p>Anda menerima email ini karena kami menerisa permintaan Reset Password akun anda.</p>
    <p>
      Jika anda tidak pernah melakukan melakukan permintaan ini, mohon abaikan email ini.
    </p>
    <p>
      Klik pada link berikut jika anda ingin Reset password anda :
      <a href="{{url('password/reset/'.$token)}}">
        {{url('password/reset/'.$token)}}
      </a>
    </p>

  </div>
@endsection
