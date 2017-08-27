<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Negeri Para Pemimpi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.0/css/bulma.min.css">
    <style>

    </style>
  </head>
  <body>
  <section class="hero is-black">
    <div class="hero-body">
      <div class="container">
        <figure>
          <img src="{{asset('images/resource/npp_logo.png')}}" alt="Negeri Para Pemimpi logo" width="200px;">
        </figure>
      </div>
    </div>
  </section>
  <section class="section">
    <div class="container">
      @yield('content')
    </div>
  </section>
  <footer class="footer">
  <div class="container">
    <p><i>Email ini dikirim secara otomatis, mohon untuk tidak membalas email ini.</i></p>
    <p>
      Jika anda membutuhkan bantuan silahkan hubungi kami di <a href="{{route('contact.index')}}">Kontak Kami</a>
    </p>
  </div>
</footer>
  </body>
</html>
