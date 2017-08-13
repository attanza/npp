@extends('layouts.app')

@section('content')
<section class="section" id="reset_password">
  <div class="container">
    <div class="columns">
      <div class="column is-half is-offset-one-quarter">
        <div class="card">
          <header class="card-header">
            <p class="card-header-title is-size-3">
              Reset Password
            </p>
          </header>
          <div class="card-content">
            <div class="content">
              @if (session('status'))
                <div class="notification is-primary" id="session_not">
                  <button class="delete" onClick="handleClose()"></button>
                    {{ session('status') }}
                </div>
              @endif
              <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                  <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left has-icons-right">
                      <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="email" name="email" id="email" placeholder="Alamat Email">
                      <span class="icon is-small is-left">
                        <i class="fa fa-envelope"></i>
                      </span>
                      @if ($errors->has('email'))
                        <span class="icon is-small is-right">
                          <i class="fa fa-warning"></i>
                        </span>
                      @endif
                    </div>
                    @if ($errors->has('email'))
                      <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @endif
                  </div>
                  <div class="field is-grouped is-grouped-right">
                    <p class="control">
                      <button type="submit" class="button is-primary">
                        Kirim link reset password
                      </button>
                    </p>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')
  <script>
    function handleClose(){
      document.getElementById("session_not").style.display = "none";
    }
  </script>
@endsection
@section('styles')
  <style>
    #reset_password {
      min-height: 65vh;
    }
  </style>
@endsection
