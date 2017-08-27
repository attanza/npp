@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Hallo {{$newContact->name}},</h3>
    <p>
      Terimaksih anda telah menghubungi kami. <br>
      Tim kami akan segera merespon anda melalu alamat email dan/atau nomor telpon yang anda cantumkan.
    </p>

  </div>
@endsection
