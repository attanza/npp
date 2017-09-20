@extends('layouts.app')
@section('content')
<div class="body-bg-black">
  <div class="body-bg-home-image">
    <section class="section">
      <div class="columns is-centered animated fadeIn">
        <div class="column is-one-third is-narrow">
          <center>
            <img src="{{asset('images/resource/npp_logo_small_wide.png')}}" alt="Npp Logo Small Wide" width="60%">
          </center>
        </div>
      </div>
    </section>
    <section class="section">
      <div class="container bg-black">
        @include('slots.home_head_section')
      </div>
    </section>
  </div>
  <section class="section">
    <div class="box">
      <div class="columns animated fadeIn">
        <div class="column">
          <figure class="m-t-50">
            <center>
              <img src="{{asset('images/resource/apamimpimu.png')}}" alt="Apa Mimpimu" width="70%">
            </center>
          </figure>
        </div>
        <div class="column">
          <div class="panel m-t-20" style="padding: 15px">
            <div class="has-text-centered">
              <p class="title is-4">SATU PERTANYAAN SEDERHANA</p>
              <p class="subtitle is-6">namun sulit untuk dijawab <br> karena setiap orang pasti memiliki <br> begitu banyak mimpi yang ingin diwujudkan</p>
              <p class="title is-4 m-t-10">LANGKAH AWAL</p>
              <p class="subtitle is-6">untuk mewujudkan mimpi adalah berani <br> mendeklarasikannya kepada dunia dengan <br> begitu mimpi itu mulai menjadi sebuah EMBRIO</p>
              <figure class="has-text-centered">
                  <img src="{{asset('images/resource/tunjukan_mimpi.png')}}" alt="Tunjukan mimpi mu" width="70%">
              </figure>
            </div>
          </div>
        </div>
      </div>
      <div class="columns animated fadeIn" style="padding: 0 20px;">
        <div class="column">
          <div class="has-text-centered is-size-4 is-size-6-mobile is-size-5-tablet">
            <p>
              <strong>Berjuta Mimpi Indonesia </strong>merupakan sebuah langkah awal dari mimpi kami <br>
              untuk mewujudkan sebuah media sosial yang akan merekam sejarah mimpimu <br>
              sehingga dapat menjadi pelajaran dimasa depan dengan cara yang menyenangkan. <br>
              Mohon dukung mimpi kami ini, dengan mendeklarasikan mimpimu dalam gerakan ini. <br>
              Mari bersama mewujudkan mimpi - mimpi kita. <br>
              <strong>- Negeri Para Pemimpi -</strong>
            </p>
            <p class="content">
              <h3 class="title is3">This is One of Our Dreams</h3>
            </p>
            <figure class="m-t-20">
              <img src="{{asset('images/resource/dream_card_on_apps.jpg')}}" alt="Dream Card on Apps">
            </figure>
          </div>
        </div>
      </div>

      @include('slots.npp_video')


    </div>
  </section>
</div>
@endsection
@section('styles')
  <link rel="stylesheet" href="{{asset('css/home_page.css')}}">
@endsection
