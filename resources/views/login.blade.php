@extends('partial.master')

@pushOnce('css')
    <link rel="stylesheet" href="../node_modules/bootstrap-social/bootstrap-social.css">
@endPushOnce

@section('login')
<section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
          <div class="login-brand">
            @if ($init == 1)
              <img src="{{asset('assets/img/logo/'.$logo)}}" alt="logo" width="100">
            @else
              <img src="{{asset('assets/img/stisla-fill.svg')}}" alt="logo" width="100" class="shadow-light rounded-circle">
            @endif
          </div>

          <div class="card card-primary">
            <div class="card-header"><h4>Login</h4></div>
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible show fade mx-3">
                <div class="alert-body">
                  <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                  </button>
                  {{$message}}
                </div>
              </div>
            @elseif ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible show fade mx-3">
                <div class="alert-body">
                  <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                  </button>
                  {{$message}}
                </div>
              </div>
            @endif
            <div class="card-body">
              <form method="POST" action="{{route('post_login')}}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                  <label for="email">Email</label>
                  <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                  <div class="invalid-feedback">
                    Please fill in your email
                  </div>
                </div>

                <div class="form-group">
                  <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                  </div>
                  <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                  <div class="invalid-feedback">
                    please fill in your password
                  </div>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Login
                  </button>

                  <a href="{{route('tamu.index')}}" class="btn btn-dark btn-lg btn-block">Tamu SIALIM</a>
                </div>
              </form>

            </div>
          </div>
          <div class="simple-footer">
            Copyright &copy; Kelompok 2 2023.
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
