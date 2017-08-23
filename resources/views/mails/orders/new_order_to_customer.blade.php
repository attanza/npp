@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Hallo {{$order->name}},</h3>
    <p>
      Terimakasih atas kepercayaan anda dengan melakukan pemesanan produk kami, dengan detail sebagai berikut:
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
        <th>Nomor telpon pemesan</th>
        <td>{{$order->phone}}</td>
      </tr>
      <tr>
        <th>Alamat kirim</th>
        <td>{{$order->address}}</td>
      </tr>
    </table>
    <p>
      Pesanan anda akan segera kami proses dan pemberitahuan selanjutnya akan kami informasikan via email dan/atau tim kami akan menghubungi anda.
    </p>
  </div>
@endsection
