<div class="columns">
  <div class="column m-t-20 animated fadeIn">
    <div class="tile is-parent is-vertical">
      <figure class="tile is-child">
        <center>
          <img src="{{asset('images/resource/bmi_atas.png')}}" alt="Berjuta Mimpi Indonesia" width="80%">
        </center>
      </figure>
      <article class="tile is-child">
        <a href="{{route('bmi.index')}}">
          <h2 class="title is-2 has-text-centered has-text-warning m-b-10">Total mimpi:</h2>
        </a>
        <dream-counter></dream-counter>
      </article>
    </div>
  </div>
  <div class="column animated fadeIn" style="padding: 20px;">
    @if (Auth::guest())
      <login></login>
      <register></register>
    @else
      <div class="card bg-yellow-opacity m-l-20 m-r-20 m-t-30">
        <div class="card-content">
          <h1 class="title is-1-desktop">Hallo, {{Auth::user()->first_name}}</h1>
          <dream-welcome></dream-welcome>
        </div>
      </div>
      <dream></dream>
    @endif
  </div>
</div>
