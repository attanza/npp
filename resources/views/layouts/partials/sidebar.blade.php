<aside class="menu">
  <p class="menu-label">
    Admin Dashboard
  </p>
  <ul class="menu-list">
    <li>
      <a @if (Request::is('/admin') || Request::is('admin/dashboard*')) class="is-active" @endif href="{{route('dashboard.index')}}">
        <span class="icon">
          <i class="fa fa-tachometer"></i>
        </span>
        Dashboard
      </a>
    </li>
    <li>
      <a @if (Request::is('admin/orders*')) class="is-active" @endif href="{{route('orders.index')}}">
        <span class="icon">
          <i class="fa fa-shopping-cart"></i>
        </span>
        Orders
      </a>
    </li>
  </ul>
  {{-- <p class="menu-label">
    Administration
  </p>
  <ul class="menu-list">
    <li><a>Team Settings</a></li>
    <li>
      <a class="is-active">Manage Your Team</a>
      <ul>
        <li><a>Members</a></li>
        <li><a>Plugins</a></li>
        <li><a>Add a member</a></li>
      </ul>
    </li>
    <li><a>Invitations</a></li>
    <li><a>Cloud Storage Environment Settings</a></li>
    <li><a>Authentication</a></li>
  </ul>
  <p class="menu-label">
    Transactions
  </p>
  <ul class="menu-list">
    <li><a>Payments</a></li>
    <li><a>Transfers</a></li>
    <li><a>Balance</a></li>
  </ul> --}}
</aside>
