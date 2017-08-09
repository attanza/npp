<nav class="navbar">
  <div class="container">
    <div class="navbar-brand">
      <a class="navbar-item" href="{{'/'}}">
        <img src="{{asset('images/resource/npp_logo.png')}}" alt="Negeri Para Pemimpi Logo">
      </a>
      <a class="navbar-item is-hidden-desktop is-pulled-right" href="https://github.com/jgthms/bulma" target="_blank">
      <span class="icon" style="color: #333;">
        <i class="fa fa-github"></i>
      </span>
    </a>
    </div>
    <div class="navbar-menu m-l-50">
      <div class="navbar-start">
        <a href="{{'/'}}" class="nav-item is-tab is-hidden-mobile m-l-20 @if(Request::is('/')) is-active @endif">
          Home
        </a>
        <a href="{{'/bmi'}}" class="nav-item is-tab is-hidden-mobile @if(Request::is('bmi*')) is-active @endif">BMI</a>
          <a href="{{'/about'}}" class="nav-item is-tab is-hidden-mobile @if(Request::is('about*')) is-active @endif">Tentang Kami</a>
        <a href="#" class="nav-item is-tab is-hidden-mobile">Buku</a>
        <a href="#" class="nav-item is-tab is-hidden-mobile">Kata Mereka</a>
        <a href="#" class="nav-item is-tab is-hidden-mobile">Kontak</a>
      </div>
    </div>
  </div>
</nav>
