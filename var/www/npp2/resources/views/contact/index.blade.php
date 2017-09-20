@extends('layouts.app')
@section('content')
<div class="body-bg-black">
  <div class="body-bg-home-image">
    <section class="section">
      <div class="columns is-centered ">
        <div class="column is-one-third is-narrow">
          <center>
            <img src="{{asset('images/resource/npp_logo_small_wide.jpg')}}" alt="Npp Logo Small Wide" width="60%">
          </center>
        </div>
      </div>
    </section>
    <section class="section animated fadeInUp">
      <div class="container bg-black" style="padding: 50px; color: #fff;">
        <div class="columns is-centered">
          <div class="column is-half is-narrow">
            <form action="{{route('contact.store')}}" method="POST">
              {{csrf_field()}}
              <div class="field">
                <label class="label">Nama Anda</label>
                <div class="control has-icons-left has-icons-right">
                  <input class="input @if($errors->has('name')) is-danger @endif" type="text" name="name" value="{{old('name')}}">
                  <span class="icon is-small is-left">
                    <i class="fa fa-user"></i>
                  </span>
                  @if ($errors->has('name'))
                    <span class="icon is-small is-right">
                      <i class="fa fa-warning"></i>
                    </span>
                  @endif
                </div>
                @if ($errors->has('name'))
                  <p class="help is-danger">{{$errors->first('name')}}</p>
                @endif
              </div>

              <div class="field">
                <label class="label">Alamat Email</label>
                <div class="control has-icons-left has-icons-right">
                  <input class="input @if($errors->has('email')) is-danger @endif" type="email" name="email" value="{{old('email')}}">
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
                  <p class="help is-danger">{{$errors->first('email')}}</p>
                @endif
              </div>

              <div class="field">
                <label class="label">Telepon</label>
                <div class="control has-icons-left has-icons-right">
                  <input class="input @if($errors->has('phone')) is-danger @endif" type="phone" name="phone" value="{{old('phone')}}">
                  <span class="icon is-small is-left">
                    <i class="fa fa-phone"></i>
                  </span>
                  @if ($errors->has('phone'))
                    <span class="icon is-small is-right">
                      <i class="fa fa-warning"></i>
                    </span>
                  @endif
                </div>
                @if ($errors->has('phone'))
                  <p class="help is-danger">{{$errors->first('phone')}}</p>
                @endif
              </div>

              <div class="field">
                <label class="label">Subjek</label>
                <div class="control has-icons-left has-icons-right">
                  <input class="input @if($errors->has('subject')) is-danger @endif" type="subject" name="subject" value="{{old('subject')}}">
                  <span class="icon is-small is-left">
                    <i class="fa fa-pencil"></i>
                  </span>
                  @if ($errors->has('subject'))
                    <span class="icon is-small is-right">
                      <i class="fa fa-warning"></i>
                    </span>
                  @endif
                </div>
                @if ($errors->has('subject'))
                  <p class="help is-danger">{{$errors->first('subject')}}</p>
                @endif
              </div>

              <div class="field">
                <label class="label">Pesan</label>
                <div class="control has-icons-left has-icons-right">
                  <textarea class="textarea @if($errors->has('message')) is-danger @endif" name="message" rows="4">{{old('message')}}</textarea>
                  <span class="icon is-small is-left">
                    <i class="fa fa-pencil"></i>
                  </span>
                  @if ($errors->has('message'))
                    <span class="icon is-small is-right">
                      <i class="fa fa-warning"></i>
                    </span>
                  @endif
                </div>
                @if ($errors->has('message'))
                  <p class="help is-danger">{{$errors->first('message')}}</p>
                @endif
              </div>

              <div class="field is-grouped is-grouped-right">
                <p class="control">
                  <button type="submit" class="button is-warning">
                    <span class="icon">
                      <i class="fa fa-paper-plane"></i>
                    </span>
                    <span>Kirim</span>
                  </button>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>

</div>
@endsection
@section('styles')
  <link rel="stylesheet" href="{{asset('css/homePage.css')}}">
  <style>
  .label {
    color: #fff;
  }
  </style>
@endsection
