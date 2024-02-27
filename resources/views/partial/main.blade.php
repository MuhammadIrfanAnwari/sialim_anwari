<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{$judul}} | {{$sub_judul}}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  @stack('css')

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body>
  <div class="modal modal-centered fade" id="modal-profile" tabindex="-1" role="dialog" aria-labelledby="title-profile" aria-hidden="true" data-mdb-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title-profile">Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  id="profile-form" method="post" action="{{route('edit_profile')}}">
              @csrf
              <input type="hidden" name="id" id="id_profile" value="{{Auth::user()->id}}">
              <div class="text-center">
                <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle m-3" width="100px">
              </div>

              <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nama User" name="name" value="{{Auth::user()->name}}" required>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email User" name="email" value="{{Auth::user()->email}}" required>
                </div>
              </div>

              <div class="d-md-flex justify-content-between form-group m-0">
                      <input type="password" class="form-control col-md-5 col-12 mb-3" placeholder="Password" name="password" id="pasword">
                  
                      <input type="password" class="form-control col-md-5 col-12 mb-3" placeholder="Konfirmasi Password" name="konfirmasi_password" id="konfirmasi_pasword">
              </div>

              <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Level User" name="level" value="{{Auth::user()->level}}" disabled required>
                </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="profile-form">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  @if (Auth::user()->level == 'super_admin')
    <div class="modal modal-centered fade" id="modal-setting" tabindex="-1" role="dialog" aria-labelledby="title-setting" aria-hidden="true" data-mdb-backdrop="false">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="title-setting">Setting</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form  id="setting-form" method="post" action="{{route('initialization.update', App\Models\tampilan::orderBy('id', 'desc')->first()->id)}}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                      <label>Nama Perguruan Tinggi</label>
                      <input type="text" class="form-control" placeholder="Nama Perguruan Tinggi" name="nama_pt" value="{{App\Models\tampilan::orderBy('id', 'desc')->first()->nama_pt}}" required>
                </div>

                <div class="text-center">
                  <img src="{{asset('assets/img/logo/'.App\Models\tampilan::orderBy('id', 'desc')->first()->logo_sialim)}}" class="max-wh">
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <input type="file" class="custom-file-input" id="logo_sialim" tabindex="1" name="logo_sialim" autofocus>
                    <label class="custom-file-label" for="logo_sialim" aria-describedby="autofocus">Logo SIALIM</label>
                  </div>
                </div>

                <div class="mx-auto mb-3" style="width: 200px">
                  <img src="{{asset('assets/img/logo/'.App\Models\tampilan::first()->logo_kecil)}}" class="max-wh">
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <input type="file" class="custom-file-input" id="logo_kecil" tabindex="1" name="logo_kecil" autofocus>
                    <label class="custom-file-label" for="logo_kecil" aria-describedby="autofocus">Logo Kecil</label>
                  </div>
                </div>
                <div class="form-group">
                    <label class="form-lable">No WA Penanggung Jawab</label>
                    <input type="text" class="form-control" tabindex="1" name="no_wa" value="{{App\Models\tampilan::orderBy('id', 'desc')->first()->no_wa}}" autofocus>
                </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="setting-form">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  @endif


  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">{{Auth::user()->name}} {{\Request::ip()}}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in 5 min ago</div>
              <button class="dropdown-item has-icon"
                  type="button" 
                  data-toggle="modal" 
                  data-target="#modal-profile">
                <i class="far fa-user"></i> Profile
              </button>
              <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              @if (Auth::user()->level == 'super_admin')
              <button class="dropdown-item has-icon"
                  type="button" 
                  data-toggle="modal" 
                  data-target="#modal-setting">
                  <i class="fas fa-cog"></i> Settings
              </button>
              @endif
              <div class="dropdown-divider"></div>
              <a href="{{route('logout')}}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{route('dashboard')}}">
              <img src="{{asset('assets/img/logo/'.App\Models\tampilan::orderBy('id', 'desc')->first()->logo_sialim)}}" class="max-wh">
            </a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard')}}">
              <img src="{{asset('assets/img/logo/'.App\Models\tampilan::orderBy('id', 'desc')->first()->logo_kecil)}}" class="max-wh">
            </a>
          </div>
            @include("partial.menu")
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <!-- kontent -->
            @yield('kontent')
        <!-- akhir kontent -->
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2024 <div class="bullet"></div> Design By <a href="https://nauv.al/">Muhammad Irfan Anwari</a>
        </div>
        <div class="footer-right">
          V 0.0.0.1
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="assets/js/modalx.js"></script>

  <!-- Page Specific JS File -->
  @stack('js')
</body>
</html>
