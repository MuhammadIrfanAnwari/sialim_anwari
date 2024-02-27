@extends('partial.main')

@push('css')
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('kontent')
  <section class="section">
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
                {{$error}}
                </div>
              </div>
            @endforeach
        @endif
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
          <div class="card-stats">
            <div class="card-stats-title">
              <div class="form-group">
                <a href="javascript:;" class="btn btn-primary daterange-btn icon-left btn-icon" id="dates"><i class="fas fa-calendar"></i> Pilih Tanggal
                </a>
              </div>
            </div>
            <div class="card-stats-items">
              <div class="card-stats-item">
                <div class="card-stats-item-count">{{$jml_menunggu}}</div>
                <div class="card-stats-item-label">Menunggu</div>
              </div>
              <div class="card-stats-item">
                <div class="card-stats-item-count">{{$jml_unvalid}}</div>
                <div class="card-stats-item-label">Unvalid</div>
              </div>
              <div class="card-stats-item">
                <div class="card-stats-item-count">{{$jml_valid}}</div>
                <div class="card-stats-item-label">Valid</div>
              </div>
            </div>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="far fa-file-alt"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Dokumen</h4>
            </div>
            <div class="card-body">
              {{$jml_dokumen}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
          <div class="card-chart">
            <canvas id="cp" height="80"></canvas>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Pengunjung</h4>
            </div>
            <div class="card-body">
              <p id="total_pengunjung" class="m-0"></p><p id="pengunjung_today" class="h6 text-success m-0"></p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
          <div class="card-chart">
            <canvas id="cd" height="80"></canvas>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="fas fa-download"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Download</h4>
            </div>
            <div class="card-body" >
              <p id="total_downloaded" class="m-0"></p><p id="downloaded_today" class="h6 text-success m-0"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-6">
        <div class="card gradient-bottom">
          <div class="card-header">
            <h4>Top 5 Downloaded Dokumen</h4>
          </div>
          <div class="card-body" id="top-5-scroll">
            <ul class="list-unstyled list-unstyled-border">
              @foreach ($top_dok as $top => $row)
                <li class="media">
                  <div class="mr-3 rounded shadow text-primary p-3 d-inline card-icon" width="100">
                    <i class="far fa-file-alt fa-3x" style="font-size: 5rem"></i>
                  </div>
                  <div class="media-body">
                    <div class="float-right"><div class="font-weight-600 text-muted text-small">{{$row->total}}x Download</div></div>
                    <div class="media-title">{{$row->dokumen->judul}}</div>
                    <div class="mt-1"><p class="h-4">Privasi : {{$row->dokumen->privasi}}</p></div>
                    <div class="mt-1"><p class="h-4">publisher : {{$row->dokumen->user->name}}</p></div>
                  </div>
                </li>
              @endforeach
              
            </ul>
          </div>
          <div class="card-footer pt-3 d-flex justify-content-center">
            <p>Top 5 Downloaded Dokumen</p>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card gradient-bottom">
          <div class="card-header">
            <h4>Dokumen Ditolak</h4>
          </div>
          <div class="card-body" id="list-10-scroll">
            <ul class="list-unstyled list-unstyled-border">
              @foreach ($dokumen_ditolak as $rejected => $row)
                <li class="media">
                  <div class="mr-3 rounded shadow text-primary p-3 d-inline card-icon" width="100">
                    <i class="far fa-file-alt fa-3x" style="font-size: 5rem"></i>
                  </div>
                  <div class="media-body">
                    <div class="float-right">
                      <form action="{{route('dokumen.destroy', $row->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" type="submit"><i class='far fa-trash-alt fa-9x' style='color:#fff'></i></button>
                      </form>
                    </div>
                    <div class="media-title">{{$row->judul}}</div>
                    <div class="m-0"><p class="h-4 m-0">Privasi : {{$row->privasi}}</p></div>
                    {{-- @dd($row->validasi) --}}
                    <div class="m-0"><p class="h-4 m-0">Alasan : {{$row->validasi[0]->alasan}}</p></div>
                    <div class="m-0"><p class="h-4 m-0">Publisher : {{$row->user->name}}</p></div>
                  </div>
                </li>
              @endforeach
              
            </ul>
          </div>
          <div class="card-footer pt-3 d-flex justify-content-center">
            <p>Dokumen Ditolak</p>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('js')
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script>
    $(function(){
      const hari_pengunjungs = {{Js::from(App\Models\pengunjung::select('tanggal')->distinct()->orderBy('tanggal', 'asc')->get())}}
      const total_pengunjungs = {{Js::from(App\Models\pengunjung::selectRaw('count(id) as total, tanggal')->groupBy('tanggal')->orderBy('tanggal', 'asc')->get())}}

      const hari_downloadeds = {{Js::from(App\Models\downloaded::select('tanggal')->distinct()->orderBy('tanggal', 'asc')->get())}}
      const total_downloadeds = {{Js::from(App\Models\downloaded::selectRaw('count(id) as total, tanggal')->groupBy('tanggal')->orderBy('tanggal', 'asc')->get())}}

      let total_pengunjung = []
      let hari_pengunjung = []
      let pengunjung_today = []
      let total_downloaded = []
      let hari_downloaded = []
      let downloaded_today = []

      let jml_download = 0;

      let tgl_data = new Date()
      tgl_data.setHours(0,0,0,0)
      let tgl_besok = new Date(tgl_data.getFullYear(),(tgl_data.getMonth()+1),tgl_data.getDate()+1)
      let tgl_mulai = new Date(tgl_data.getFullYear(),(tgl_data.getMonth()),1)
      let tgl_akhir = new Date(tgl_data.getFullYear(),(tgl_data.getMonth()+1),0)

      $('#dates').daterangepicker({
        opens: 'left'
      }, function(start, end, label) {
        tgl_mulai = new Date(start.format('YYYY-MM-DD'))
        tgl_akhir = new Date(end.format('YYYY-MM-DD'))
        tgl_data = new Date()
        
        chart_data(hari_pengunjungs, total_pengunjungs, hari_pengunjung, total_pengunjung, pengunjung_today, hari_downloadeds, total_downloadeds, hari_downloaded, total_downloaded, downloaded_today, tgl_data, tgl_mulai, tgl_akhir, tgl_besok)
        chart_pengunjung.update()
        chart_downloaded.update()
      });

      chart_data(hari_pengunjungs, total_pengunjungs, hari_pengunjung, total_pengunjung, pengunjung_today, hari_downloadeds, total_downloadeds, hari_downloaded, total_downloaded, downloaded_today, tgl_data, tgl_mulai, tgl_akhir, tgl_besok)

      let chart_pengunjung = new Chart(cp, {
          type: 'line',
          data: {
            labels: hari_pengunjung,
            datasets: [{
              label:"Pengunjung",
              lineTension:0.5,
              data: data_pengunjung,
              borderWidth: 2,
              fill:true
            }]
          },
          options: {
            scales:{
              x:{display:false},
              y:{display:false}
            },
            plugins: {legend: {display: false}}
          }
      });

      let chart_downloaded = new Chart(cd, {
          type: 'line',
          data: {
            labels: hari_downloaded,
            datasets: [{
              label:"Didownload",
              lineTension:0.5,
              data: data_downloaded,
              borderWidth: 2,
              fill:true
            }]
          },
          options: {
            scales:{
              x:{display:false},
              y:{display:false}
            },
            plugins: {legend: {display: false}}
          }
      });

      function push_hari(data, data2, tgl_mulai, tgl_akhir){
        while(data2.length > 0){
          data2.pop()
        }

        for (let i = 0; i < data.length; i++) {
          tgl_data = new Date(data[i].tanggal)
          
          if(get_tgl(tgl_data, tgl_mulai, tgl_akhir)){
            data2.push(get_tgl(tgl_data, tgl_mulai, tgl_akhir))
          }
        } 

        return data2
      }

      function get_tgl(tgl_data, tgl_mulai,tgl_akhir){
        if(Date.parse(tgl_mulai) <= Date.parse(tgl_data)){
          if(Date.parse(tgl_akhir) >= Date.parse(tgl_data)){
            if(tgl_data.getDate() < 10){
              hari = "0"+tgl_data.getDate()
            } else {
              hari = tgl_data.getDate()
            }

            if(tgl_data.getMonth() < 10){
              bulan = "0"+(tgl_data.getMonth()+1)
            } else {
              bulan = (tgl_data.getMonth()+1)
            }
            return tgl_data.getFullYear()+'-'+bulan+'-'+hari
          }
        }
      }

      function push_total(data, data2, tgl_mulai, tgl_akhir){
        while(data2.length > 0){
          data2.pop()
        }

        for (let i = 0; i < data.length; i++) {
          tgl_data = new Date(data[i].tanggal)
          
          if(get_tgl(tgl_data, tgl_mulai, tgl_akhir)){
            data2.push(get_data(tgl_data, tgl_mulai, tgl_akhir, data[i].total))
          }
        } 

        return data2
      }

      function get_data(tgl_data, tgl_mulai, tgl_akhir, total){
        if(Date.parse(tgl_mulai) <= Date.parse(tgl_data)){
          if(Date.parse(tgl_akhir) >= Date.parse(tgl_data)){
            return total
          }
        }
      }

      function get_total(total_downloaded){
        let i = 0;
        let total = 0
        while(i<total_downloaded.length){
          total += total_downloaded[i]
          i++
        }
        i = 0
        return total
      }

      function chart_data(hari_pengunjungs, total_pengunjungs, hari_pengunjung, total_pengunjung, pengunjung_today, hari_downloadeds, total_downloadeds, hari_downloaded, total_downloaded, downloaded_today, tgl_data, tgl_mulai, tgl_akhir, tgl_besok){
        
        hari_pengunjung = push_hari(hari_pengunjungs, hari_pengunjung, tgl_mulai, tgl_akhir)
        data_pengunjung = push_total(total_pengunjungs, total_pengunjung, tgl_mulai, tgl_akhir)
        pengunjung_today = push_total(total_pengunjungs, pengunjung_today, tgl_data, tgl_besok)
        total_pengunjung = get_total(data_pengunjung)
        pengunjung_today = get_total(pengunjung_today)
        $('#total_pengunjung').html(total_pengunjung+"x")
        $('#pengunjung_today').html("(hari ini +"+pengunjung_today+")")

        hari_downloaded = push_hari(hari_downloadeds, hari_downloaded, tgl_mulai, tgl_akhir)
        data_downloaded = push_total(total_downloadeds, total_downloaded, tgl_mulai, tgl_akhir)
        downloaded_today = push_total(total_downloadeds, downloaded_today, tgl_data, tgl_besok)
        downloaded_today = get_total(downloaded_today)
        total_downloaded = get_total(data_downloaded)
        $('#total_downloaded').html(total_downloaded+"x")
        $('#downloaded_today').html("(hari ini +"+downloaded_today+")")
      }
    })
  </script>
@endpush