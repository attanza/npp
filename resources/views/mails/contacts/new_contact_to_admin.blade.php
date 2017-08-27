@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Dear Tim Negeri Para Pemimpi</h3>
    <p>
      Pesan baru telah diterima oleh sistem dengan detail sebagai berikut:
    </p>
    <table class="table">
      <tr>
        <th>Pengirim</th>
        <td>{{$newContact->name}}</td>
      </tr>
      <tr>
        <th>Email</th>
        <td>{{$newContact->email}}</td>
      </tr>
      <tr>
        <th>Telepon</th>
        <td>{{$newContact->phone}}</td>
      </tr>
      <tr>
        <th>Subject</th>
        <td>{{$newContact->subject}}</td>
      </tr>
      <tr>
        <th>Pesan</th>
        <td>{{$newContact->message}}</td>
      </tr>
    </table>

  </div>
@endsection
