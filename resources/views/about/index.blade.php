@extends('layouts.app')
@section('content')
<div class="body-bg-black  animated fadeIn">
  <section class="section bg-transparent">
    <div class="container">
      <div class="columns">
        <div class="column">
          <figure class="image">
            <center>
              <img src="{{asset('images/resource/about_hero_img.png')}}" alt="Tentang Negeri Para Pemimpi">
            </center>
          </figure>
          <div class="is-size-4-desktop is-size-6-mobile is-size-5-tablet has-text-warning animated fadeIn">
            <div class="columns is-desktop m-b-20">
              <div class="column is-8 is-offset-2">
                <p class="has-text-centered">
                  <strong>Negeri Para Pemimpi</strong> adalah tempat untuk setiap orang yang memiliki mimpi
                  dan ingin mewujudkannya, kami menyediakan berbagai macam media yang dapat
                  menjadikan mimpi-mimpi (goals) menjadi lebih <strong>“POWERFUL”</strong>
                  dengan metode yang kami miliki.
                </p>
              </div>
            </div>
            <p class="m-t-20">
              Pada tahun 2013 akhir, negeri para pemimpi pertama kali meluncurkan buku “50 First Dreams” yaitu sebuah buku kerja pengganti <i>vision board</i>. Buku ini disusun berdasarkan sebuah metode yang kami buat yang kami sebut “Soul Of The Dreamers”.
            </p>
          </div>
          <figure class="m-t-20">
            <center>
              <img src="{{asset('images/resource/soul_of_dreamer.png')}}" alt="Soul of the dreamer" width="50%">
            </center>
          </figure>
          <div class="is-size-4-desktop is-size-6-mobile is-size-5-tablet has-text-warning m-t-20">
            <p>
              Saat ini kami sedang membangun sebuah media sosial yang kami beri julukan <strong>“The Next Level of Social Media”</strong>  yaitu <strong>NPP Dream Cards</strong>. Sambil menunggu proses pembangunan sistem kami meluncurkan gerakan “Berjuta Mimpi Indonesia”, dengan gerakan ini kami menambahkan sebuah <i>fiture</i> dalam website negeriparapemimpi.com yang dapat digunakan para pengguna untuk meng-upload satu mimpi dan berinteraksi dengan pengguna lainnya, mimpi yang di upload dalam Berjuta Mimpi Indonesia ini akan menjadi mimpi pertama di <strong>NPP Dream Cards</strong> nantinya.
            </p>
            <p class="m-t-10">
              Selain ketiga produk itu kami juga akan terus mengembangkan produk-produk lainnya, baik itu berupa produk <i>offline</i>, produk digital ataupun merupakan sebuah <i>event</i>.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section bg-transparent product">
    <div class="container">
      <figure class="image">
        <img src="{{asset('images/resource/logo_produk.png')}}" alt="">
      </figure>
      <figure class="image npp-book m-t-50">
        <img src="{{asset('images/resource/buku.jpg')}}" alt="">
      </figure>
    </div>
  </section>

  <section class="section bg-transparent order">
    <div class="container">
      <div class="columns">
       <div class="column">
         <div class="is-size-4-desktop is-size-6-mobile is-size-5-tablet has-text-warning m-t-20">
           <p class="content">
             Buku ini adalah buku berjenis <i>workbook</i>, jadi pemilik buku ini akan mengisikan mimpi-mimpi yang ingin diwujudkan. Dengan metode yang kami rancang, buku ini akan membantu anda cara yang tepat untuk menyiapkan warisan yang sesungguhnya (”The True Legacy”).
           </p>
           <p class="content">
             Segera miliki buku NPP “50 First Dreams”, dapatkan harga khusus hanya Rp. 175.000,- (belum termasuk ongkos kirim).
           </p>
         </div>
       </div>
       <div class="column">
         <order-form></order-form>
       </div>
     </div>
    </div>
  </section>
</div>
@endsection
@section('styles')
  <style>
    strong{
      color: #ffcc2a;
    }
    .npp-book img {
      border-radius: 3px;
    }
  </style>
@endsection
