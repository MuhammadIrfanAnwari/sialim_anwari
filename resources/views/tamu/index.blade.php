@extends('partial.tamu')

@section('tamu')
    <div class="container-fluid mt-3">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                  <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                  </button>
                  {{$message}}
                </div>
              </div>
        @elseif ($message = Session::get('danger'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                {{$message}}
                </div>
            </div>
        @elseif($errors->any())
            @foreach($errors->all() as $error)
              <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                {!!$error!!}
                </div>
              </div>
            @endforeach
        @endif
        <div class="card-body border border-1 shadow">
            <ul class="nav nav-pills" id="myTab3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#semua_dokumen" role="tab" aria-controls="profile" aria-selected="false">Semua Dokumen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#tentang" role="tab" aria-controls="contact" aria-selected="false">Tentang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#token" role="tab" aria-controls="contact" aria-selected="false">Token</a>
            </li>
            </ul>
            <div class="tab-content" id="myTabContent2">
            <div class="tab-pane fade show active mt-3" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                @include('tamu.dashboard')
            </div>
            <div class="tab-pane fade" id="semua_dokumen" role="tabpanel" aria-labelledby="profile-tab3">
                @include('tamu.dokumen')
            </div>
            <div class="tab-pane fade" id="tentang" role="tabpanel" aria-labelledby="contact-tab3">
                @include('tamu.tentang')
            </div>
            <div class="tab-pane fade" id="token" role="tabpanel" aria-labelledby="contact-tab4">
                @include('tamu.token')
            </div>
            </div>
        </div>
    </div>
@endsection