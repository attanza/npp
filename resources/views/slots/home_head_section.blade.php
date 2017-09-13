<div class="columns">
  <div class="column m-t-20 animated fadeInLeft">
    <div class="tile is-parent is-vertical">
      <figure class="tile is-child">
        <center>
          <img src="{{asset('images/resource/bmi_atas.png')}}" alt="Berjuta Mimpi Indonesia" width="80%">
        </center>
      </figure>
      <article class="tile is-child">
        <h2 class="title is-2 has-text-centered has-text-warning">Total mimpi:</h2>
        <dream-counter></dream-counter>
      </article>
    </div>
  </div>
  <div class="column animated fadeInRight" style="padding: 20px;">
    @if (Auth::guest())
      <login></login>
      <register></register>
    @else
      <div class="card bg-yellow-opacity m-l-20 m-r-20 m-t-30">
        <div class="card-content">
          <h1 class="title is-1-desktop">Hallo, {{Auth::user()->first_name}}</h1>
          <p class="is-size-4-desktop is-size-6-mobile has-text-white">
            Terima Kasih sudah ikut berpartisipasi untuk mensukseskan Gerakan Berjuta Mimpi Indonesia, Dukunganmu sungguh sangat berarti bagi kami, ayo segera deklarasikan mimpimu dan kita saling mendukung untuk mewujudkannya.
          </p>
        </div>
      </div>
      <dream></dream>
    @endif
  </div>
</div>
