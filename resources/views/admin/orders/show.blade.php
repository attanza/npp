@extends('layouts.admin')
@section('content')
  <nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
      <li><a href="/admin/dashboard">Dashboard</a></li>
      <li><a href="/admin/orders">Order List</a></li>
      <li class="is-active"><a href="#" aria-current="page">{{$order->order_no}}</a></li>
    </ul>
  </nav>
  <h3 class="title is-3">Detail Order</h3>
  <div class="columns">
    <div class="column">
      <table class="table is-bordered is-striped is-narrow is-fullwidth">
        <tr>
          <th>Nama Pemesan</th>
          <td>{{$order->name}}</td>
        </tr>
        <tr>
          <th>Telepon Pemesan</th>
          <td>{{$order->phone}}</td>
        </tr>
        <tr>
          <th>Email Pemesan</th>
          <td>{{$order->email}}</td>
        </tr>
        <tr>
          <th>Alamat Kirim</th>
          <td>{{$order->address}}</td>
        </tr>
      </table>
    </div>
    <div class="column">
      <form action="{{route('orders.update', $order->id)}}" method="POST">
        {{csrf_field()}}
        {{ method_field('PUT') }}
      <table class="table is-bordered is-striped is-narrow is-fullwidth">
        <tr>
          <th>Nomor Pesanan</th>
          <td>{{$order->order_no}}</td>
        </tr>
        <tr>
          <th>Nama Produk</th>
          <td>{{$order->product->name}}</td>
        </tr>
        <tr>
          <th>Jumlah</th>
          <td>{{$order->qty}}</td>
        </tr>
        <tr>
          <th>Tanggal Pesan</th>
          <td>{{$order->created_at->format('d M Y')}}</td>
        </tr>
        @if ($order->status != 3)
          <tr>
            <th>Status</th>
            <td>
              <div class="field">
                <div class="control">
                  <div class="select">
                    <select name="status">
                      @foreach($status as $stat)
                        <option value="{{$stat['id']}}"
                        @if($order->status == $stat['id']) selected @endif @if($stat['id'] == 3) disabled @endif>
                          {{$stat['name']}}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="field">
                <div class="control">
                  <label class="checkbox">
                    <input type="checkbox" name="send_mail">
                     Kirim notifikasi
                  </label>
                </div>
              </div>
            </td>
            <td>
              <button type="submit" class="button is-primary">Simpan perubahan</button>
            </td>
          </tr>
        @else
          <tr>
            <th>Status</th>
            <td>Terkirim</td>
          </tr>
          <tr>
            <th>Diterima pada</th>
            <td>{{$order->completed_at->format('d M Y')}}</td>
          </tr>
        @endif

      </table>
      </form>
    </div>
  </div>
  <h3 class="title is-3">Detail Produk</h3>
  <div class="columns">
    <div class="column">
      <figure class="image">
        <img src="{{$order->product->photo}}" alt="{{$order->product->name}}">
      </figure>
    </div>
    <div class="column">
      <table class="table is-bordered is-striped is-narrow is-fullwidth">
        <tr>
          <th>Kode Product</th>
          <td>{{$order->product->code}}</td>
        </tr>
        <tr>
          <th>Nama Produk</th>
          <td>{{$order->product->name}}</td>
        </tr>
        <tr>
          <th>Harga satuan</th>
          <td>{{number_format($order->product->price)}}</td>
        </tr>
        <tr>
          <th>Stock</th>
          <td>{{$order->product->stock}}</td>
        </tr>
        <tr>
          <th>Info</th>
          <td>{{$order->product->description}}</td>
        </tr>

      </table>
    </div>
  </div>
@endsection
