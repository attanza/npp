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
              <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">

                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">

                  <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left has-icons-right">
                      <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="email" name="email" id="email" placeholder="Alamat Email" value="{{ $email or old('email') }}">
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

                  <div class="field">
                    <label class="label">Password</label>
                    <div class="control has-icons-left has-icons-right">
                      <input class="input {{ $errors->has('password') ? ' is-danger' : '' }}" type="password" name="password" id="password" placeholder="Password">
                      <span class="icon is-small is-left">
                        <i class="fa fa-key"></i>
                      </span>
                      @if ($errors->has('password'))
                        <span class="icon is-small is-right">
                          <i class="fa fa-warning"></i>
                        </span>
                      @endif
                    </div>
                    @if ($errors->has('password'))
                      <p class="help is-danger">{{ $errors->first('password') }}</p>
                    @endif
                  </div>

                  <div class="field">
                    <label class="label">Password Konfirmasi</label>
                    <div class="control has-icons-left has-icons-right">
                      <input class="input {{ $errors->has('password_confirmation') ? ' is-danger' : '' }}" type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password">
                      <span class="icon is-small is-left">
                        <i class="fa fa-key"></i>
                      </span>
                      @if ($errors->has('password_confirmation'))
                        <span class="icon is-small is-right">
                          <i class="fa fa-warning"></i>
                        </span>
                      @endif
                    </div>
                    @if ($errors->has('password_confirmation'))
                      <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                  </div>


                  <div class="field is-grouped is-grouped-right">
                    <p class="control">
                      <button type="submit" class="button is-primary">
                        Reset Password
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
