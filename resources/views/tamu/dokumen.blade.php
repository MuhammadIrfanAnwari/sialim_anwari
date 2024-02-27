<div class="modal modal-centered fade" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="title-kriteria" aria-hidden="true" data-mdb-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title-kriteria">Filter Dokumen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  id="filter-form" method="get">
              @csrf
              @foreach ($filter_bagian as $bagian => $row)
                <div class="form-group">
                    <input type="checkbox" id="bagian_{{$row->id}}" name="filter_bagian[]" value="{{$row->id}}" {{($row->id == 1 ? 'disabled checked' : '')}} {{(in_array($row->id, $data_bagian) ? 'checked' : '')}}> <label for="bagian_{{$row->id}}">{{$row->nama_bagian}}</label>   
                </div>   
            @endforeach
           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="filter-form">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<div class="container-fluid py-3 border border-1 shadow shadow-1 mt-2 d-flex flex-wrap">
    <div class="filter col-12">
        <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#modal-filter" id="addKriteria"><i class="fas fa-search"></i> Filter Dokumen</button>
        
    </div>
    @foreach ($dokumen as $kriteria => $row)
        <div class="card col-md-6">
            <div class="card-header d-flex">
                <h1 class="text-primary h1 mr-2"><i class="fas fa-folder-open"></i></h1>
                <div>
                    <p class="p-0 m-0"><b>{{$row['nama_kriteria']}}</b></p>
                    <p class="p-0 m-0">{{$row['deskripsi']}}</p>
                </div>
                <span class="text-danger position-absolute text-head-card">
                    <b>{{$row['singkatan']}}</b>
                </span>
            </div>
            <div class="card-body">
                <div class="dokument">
                    {{-- {{$row->sub_kriteria}} --}}
                    @foreach ($row->sub_kriteria as $sub_kriteria)
                        <div class="m-0 mb-2">
                            <p class="p-0 m-0"><b>{{$sub_kriteria->nama_sub_kriteria}}</b></p>
                            @foreach (App\Models\dokumen::where('id_sub_kriteria', '=', $sub_kriteria->id)->whereIn('id_bagian', $data_bagian)->get() as $dokumen)
                                @if ($dokumen->privasi == 'public')
                                    <p class="m-0 py-1">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{route('tamu.download', $dokumen->id)}}"><i class="far fa-file-alt"></i> {{$dokumen->judul}}</a>
                                    </p>
                                @else
                                    <p class="m-0 py-1">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="fas fa-lock text-danger"></i> {{$dokumen->judul}}
                                    </p>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>