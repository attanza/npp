@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Dear {{$order->name}},</h3>
    <p>
      Terimaksih atas verifikasi pesanan dengan nomor <u>#{{$order->order_no}}</u> sudah anda terima.
      <br>
      Berikut detail pesanan anda:
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
        <th>Alamat kirim</th>
        <td>{{$order->address}}</td>
      </tr>
    </table>
  </div>
@endsection
