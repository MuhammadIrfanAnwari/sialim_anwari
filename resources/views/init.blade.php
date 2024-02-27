@extends('partial.master')

  <link rel="stylesheet" href="../node_modules/bootstrap-social/bootstrap-social.css">

    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Initialization App</h4></div>
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
                <form method="POST" action="{{route('initialization.store')}}" class="needs-validation" novalidate="Ulang" enctype="multipart/form-data">
                  @csrf
                  <h4><u>Perguruan Tinggi</u></h4>
                  <div class="form-group">
                    <label for="nama_pt">Nama</label>
                    <input id="nama_pt" type="text" class="form-control" name="nama_pt" tabindex="1" placeholder="Nama Applikasi" required autofocus>
                    <div class="invalid-feedback">
                      Tolong isi nama Perguruan Tinggi
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="logo_kecil">Logo</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="logo_kecil" name="logo_kecil" required>
                      <label class="custom-file-label" for="logo_kecil" aria-describedby="logo_kecil">Logo</label>
                    </div>
                    <div class="invalid-feedback">
                      Tolong upload Logo Perguruan Tinggi
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="logo_sialim">Logo Banner</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="logo_sialim" tabindex="1" name="logo_sialim" required autofocus>
                      <label class="custom-file-label" for="logo_sialim" aria-describedby="autofocus">Logo SIALIM</label>
                    </div>
                    <div class="invalid-feedback">
                      Tolong upload logo banner Perguruan Tinggi
                    </div>
                  </div>

                  <h4><u>Account</u></h4>

                  <div class="form-group">
                    <label for="email">Nama User</label>
                    <input type="text" class="form-control" placeholder="Nama User" name="name" id="name" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Tolong isi Nama User
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" placeholder="Email User" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Tolong isi email
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <div class="d-block">
                          <label for="password" class="control-label">Password</label>
                        </div>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" tabindex="2" required>
                        <div class="invalid-feedback">
                          Tolong isi password
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group">
                        <div class="d-block">
                          <label for="confirm-password" class="control-label">Confirm Password</label>
                        </div>
                        <input id="confirm-password" type="password" class="form-control" name="confirm-password" placeholder="Konfirmasi Password" tabindex="2" required>
                        <div class="invalid-feedback">
                          Tolong isi Konfirmasi password
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Create
                    </button>
                  </div>
                
            <div class="simple-footer">
              Copyright &copy; Muhammad Irfan Anwari
            </div>
          </div>
        </div>
      </div>
    </section>
