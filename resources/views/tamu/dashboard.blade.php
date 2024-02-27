<div class="container-fluid py-3 border border-1 shadow shadow-1">
    <h1>Selamat datang di SIALIM </h1><hr>
    <p>System Akreditasi Online Mandiri | {{$init->nama_pt}}</p>
</div>

<div class="container-fluid py-3 border border-1 shadow mt-3">
    <div class="d-flex justify-content-around flex-wrap">
        <div class="col-lg-3 col-md-6 col-12 p-1">
            <div class="card bg-danger text-white p-0 min-card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Dokumen</p>
                    <p class="h3"><i class="far fa-file-alt"></i></p>
                </div>
                <div id="carouselExampleIndicators3" class="carousel slide p-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @php $i = 0 @endphp
                      @foreach ($dokumen_count as $data => $row)
                        <li data-target="#carouselExampleIndicators3" data-slide-to="{{$i}}" class="{{($i == 0 ? 'active' : '')}}"></li>
                        @php $i++ @endphp
                      @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @php 
                            $j = 0 
                        @endphp
                      @foreach ($dokumen_count as $data => $row)
                            <div class="carousel-item min-wh-100 {{($j == 0 ? 'active' : '')}}">
                                <div class="p-3">
                                    <div class="d-flex justify-content-between">
                                        <p>{{$row['nama_kriteria']}}</p>
                                        <p>{!!$row['singkatan']!!}</p>
                                    </div>
                                    <p class="h5">{{$row['jumlah']}} Dokumen</p>
                                </div>
                            </div>
                        @php 
                            $j++ 
                        @endphp
                      @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
            </div>
        </div>
    
        <div class="col-lg-3 col-md-6 col-12 p-1">
            <div class="card bg-primary text-white p-0 min-card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Pengunjung</p>
                    <p class="h3"><i class="fas fa-users"></i></p>
                </div>
                <div class="card-body">
                    <p class="h3">{{$pengunjung}} Orang</p>
                    <p class="">+{{$pengunjungToday}} orang hari ini</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 p-1">
            <div class="card bg-info text-white p-0 min-card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Total Download</p>
                    <p class="h3"><i class="fas fa-download"></i></p>
                </div>
                <div class="card-body">
                    <p class="h3">{{$downloaded}}X Downloaded</p>
                    <p class="">+{{$downloadedToday}}X Downloaded hari ini</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 p-1">
            <div class="card bg-warning text-white p-0 min-card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Dokumen Baru</p>
                    <p class="h3"><i class="fas fa-tags"></i></p>
                </div>
                <div class="card-body">
                    <p class="h3">+{{$dokumenMonth}} Dokumen</p>
                    <p class="h3">bulan ini</p>
                </div>
            </div>
        </div>
    </div>
</div>