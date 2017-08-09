<nav class="navbar">
  <div class="container">
    <div class="navbar-brand">
      <a class="navbar-item" href="{{'/'}}">
        <img src="{{asset('images/resource/npp_logo.png')}}" alt="Negeri Para Pemimpi Logo">
      </a>
    </div>
    <div class="navbar-menu">
      <div class="navbar-start">
        <a href="{{'/'}}" class="nav-item is-tab is-hidden-mobile m-l-20 @if(Request::is('/')) is-active @endif">
          Home
        </a>
        <a href="{{'/bmi'}}" class="nav-item is-tab is-hidden-mobile @if(Request::is('bmi*')) is-active @endif">Berjuta Mimpi Indonesia</a>
          <a href="{{'/about'}}" class="nav-item is-tab is-hidden-mobile @if(Request::is('about*')) is-active @endif">Tentang Kami</a>
        <a href="#" class="nav-item is-tab is-hidden-mobile">Kontak</a>
      </div>
      <div class="navbar-end">
        @if (Auth::check())
          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              <img src="{{asset('images/resource/user.jpg')}}" alt="{{Auth::user()->first_name}}">
              {{Auth::user()->first_name}}
            </a>
            <div class="navbar-dropdown is-right">
              <a href="#" class="navbar-item">
                <span class="icon m-r-10">
                  <i class="fa fa-user"></i>
                </span> Profile
              </a>
              <a class="navbar-item">
                <span class="icon m-r-10">
                  <i class="fa fa-cloud"></i>
                </span> Mimpiku
              </a>
              <hr class="navbar-divider">
              <a href="{{route('logout')}}" class="navbar-item" onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                <span class="icon m-r-10">
                  <i class="fa fa-sign-out"></i>
                </span> Logout
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
              </a>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</nav>
