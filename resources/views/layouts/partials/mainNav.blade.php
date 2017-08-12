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
        <a href="{{route('bmi.index')}}" class="nav-item is-tab is-hidden-mobile
          @if(Request::is('berjuta-mimpi-indonesia*')) is-active @endif">
          Berjuta Mimpi Indonesia
        </a>
          <a href="{{route('about.index')}}" class="nav-item is-tab is-hidden-mobile
            @if(Request::is('tentang-negeri-para-pemimmpi*')) is-active @endif">
            Tentang Kami
          </a>
        <a href="#" class="nav-item is-tab is-hidden-mobile">Kontak</a>
      </div>
      <div class="navbar-end">
        @if (Auth::check())
          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              <avatar-nav></avatar-nav><span class="m-l-5">{{Auth::user()->first_name}}</span>
            </a>
            <div class="navbar-dropdown is-right">
              <a href="{{route('profile', Auth::user()->username)}}" class="navbar-item">
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
