@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Hallo Tim Negeri Para Pemimpi,</h3>
    <p>
      Pesanan baru telah diterima oleh sistem dengan detail sebagai berikut:
    </p>
    <table class="table">
      <tr>
        <th>Nama Product</th>
        <td>{{$product->name}}</td>
      </tr>
      <tr>
        <th>Jumlah</th>
        <td>{{$order->qty}}</td>
      </tr>
      <tr>
        <th>Nama Pemesan</th>
        <td>{{$order->name}}</td>
      </tr>
      <tr>
        <th>Nomor telpon pemesan</th>
        <td>{{$order->phone}}</td>
      </tr>
      <tr>
        <th>Alamat kirim</th>
        <td>{{$order->address}}</td>
      </tr>
    </table>
    <p>
      Silahkan proses pesanan tersebut dengan mengakses <a href="#">Admin Panel</a>.
    </p>
  </div>
@endsection
