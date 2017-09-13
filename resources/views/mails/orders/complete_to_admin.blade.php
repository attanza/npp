@extends('mails.mail_master')
@section('content')
  <div class="content">
    <h3 class="title is-3">Halo Tim Negeri Para Pemimpi,</h3>
    <p>
      Pesanan dengan nomor <u>#{{$order->order_no}}</u> sudah diterima oleh pemesan pada tanggal {{$order->completed_at->format('d M Y')}}.
      <br>
      Berikut detail pesanan:
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
    <p>
      Untuk melihat detail pesanan tersebut silahkan mengakses <a href="{{route('orders.show', $order->order_no)}}">Admin Panel</a>.
    </p>
  </div>
@endsection
