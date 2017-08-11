@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Hallo {{$user->first_name}},</h3>
    <p>Selamat datang di negeri para pemimpi, terimakasih telah bergabung bersama kami. Tinggal satu langkah lagi untuk segera dapat mendeklarasikan mimpi Anda dan bergabung dengan <b>Gerakan Berjuta Mimpi Indonesia</b>.
    Silahkan klik link dibawah ini untuk mengaktifkan akun anda:</p>
    <p>
      <a href="{{route('npp-activation', ['email'=>$user->email, 'code'=>$user->activation->code])}}">{{route('npp-activation', ['email'=>$user->email, 'code'=>$user->activation->code])}}</a>
    </p>
  </div>
@endsection
