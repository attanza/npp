@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Hallo {{$user->first_name}},</h3>
    <p>Terima Kasih anda telah berpartisipasi dalam mendukung <b>Gerakan Berjuta Mimpi Indonesia</b> dengan mendeklarasikan mimpi anda. </p>
    <p>Tetaplah berinteraksi dengan kami dan juga <i>"The Dreamers"</i> lainnya. Agar kita bisa saling mendukung untuk mewujudkan mimpi kita.</p>
    <p>
      Klik disini untuk mengakses laman mimpi anda : <a href="{{route('profile', $user->username)}}">{{route('profile', $user->username)}}</a>
    </p>
  </div>
@endsection
