<nav class="navbar has-shadow">
  <div class="container">
    <div class="navbar-brand">
      <a class="navbar-item" href="{{url('/')}}">
        <img src="{{asset('images/resource/npp_logo.png')}}" alt="Negeri Para Pemimpi Logo">
      </a>

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
        <a href="{{route('clear.db')}}" class="nav-item is-tab is-hidden-mobile">Clear DB</a>
      </div>

      <div class="navbar-end">
        @if (Auth::check())
          <unread-nots></unread-nots>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              <avatar-nav></avatar-nav><span class="m-l-10">{{Auth::user()->first_name}}</span>
            </a>

            <div class="navbar-dropdown is-right">
              <a href="{{route('profile', Auth::user()->username)}}" class="navbar-item">
                <span class="icon m-r-10">
                  <i class="fa fa-user"></i>
                </span> Profile
              </a>
              <a class="navbar-item" href="{{route('dream.show', Auth::user()->dream->slug)}}">
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
        @else
          <a href="{{url('/login')}}" class="nav-item is-tab is-hidden-mobile">Login / Register</a>
        @endif

      </div>

    </div>
  </div>
</nav>
