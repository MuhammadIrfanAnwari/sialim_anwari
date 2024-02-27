@extends('partial.main')

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('kontent')
<div class="modal modal-centered fade" id="modal-unvalid" tabindex="-1" role="dialog" aria-labelledby="title-dokumen" aria-hidden="true" data-mdb-backdrop="false">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title-unvalid">Alasan Tidak Valid</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('validasi')}}" method="post" id="unvalid">
          @csrf
          <input type="hidden" name="id_dokumen" id="id_dokumen_unvalid">
          <input type="hidden" name="status" value="unvalid">
          <input type="text" name="alasan" class="form-control" placeholder="Alasan">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="unvalid">Save changes</button>
      </div>
    </div>
  </div>
</div>

<form action="" method="post" id="delete_dokumen">
  @csrf
  @method('delete')
</form>

<div class="modal modal-centered fade" id="modal-validasi" tabindex="-1" role="dialog" aria-labelledby="title-dokumen" aria-hidden="true" data-mdb-backdrop="false">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Validasi Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          @foreach ($dokumen_validasi as $dokumen => $row)
            <div class="card card-primary shadow-sm rounded">
              <div class="card-header">
                  <h4 class="{{($row->status == 'unvalid'?'text-danger':'')}}">{{$row['judul']}} | {{$row->user->name}}</h4>
                  <div class="card-header-action">
                      <form action="{{route('validasi')}}" method="post">
                           @csrf
                           <input type="hidden" name="id_dokumen" value="{{$row['id']}}">
                           <input type="hidden" name="status" value="valid">
                           @if(in_array(Auth::user()->level, ['admin', 'super_admin']))
                            @if ($row->status != 'unvalid')
                            <button type="submit" class="btn btn-success">
                              <i class="fas fa-plus-circle fa-9x" style="color: #fff"></i>
                            </button>
                            <button type="button" 
                            data-toggle="modal"
                            data-id="{{$row['id']}}" 
                            class="btn btn-danger unvalid"
                            data-target="#modal-unvalid"
                            >
                              <i class="fas fa-times-circle fa-9x" style="color: #fff"></i>
                            </button>
                            @endif
                           @endif
                           @if (Auth::user()->level == 'user' && $row->id_user == Auth::user()->id && $row->status == 'menunggu')
                            <button type="button" 
                            class="btn btn-primary editDokumen" 
                            data-toggle="modal" 
                            data-target="#modal-dokumen"
                            data-id="{{$row['id']}}" >
                              <i class='far fa-edit fa-9x' style='color:#fff'></i>
                            </button>
                            <button class="btn btn-danger DelDok" type="button" form="delete_dokumen" data-id="{{$row['id']}}"><i class='far fa-trash-alt fa-9x' style='color:#fff'></i></button>
                           @endif
                           <a data-collapse="#cekDokumen-{{$row['id']}}" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                      </form>

                  </div>
              </div>
              <div class="collapse" id="cekDokumen-{{$row['id']}}">
                <div class="card-body">
                  <div class="d-flex">
                    <p class="col-4">Judul</p>
                    <p class="fw-bold m-0 col-8">: <a href="{{route('buka_file', $row['id'])}}">{{$row->judul}}</a></p>
                  </div>
                  <div class="d-flex">
                    <p class="col-4">Sub Kriteria</p>
                    <p class="m-0 col-8">: {{$row->sub_kriteria->nama_sub_kriteria}}</p>
                  </div>
                  <div class="d-flex">
                    <p class="col-4">Bagian</p>
                    <p class="m-0 col-8"> : {{$row->bagian->nama_bagian}}</p>
                  </div>
                  <div class="d-flex">
                    <p class="col-4">Privasi</p>
                    <p class="m-0 col-8"> : {{$row->privasi}}</p>
                  </div>
                  
                  
                  
                </div>
              </div>
          </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <p>Validasi Data</p>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-centered fade" id="modal-dokumen" tabindex="-1" role="dialog" aria-labelledby="title-dokumen" aria-hidden="true" data-mdb-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title-dokumen">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  id="dokumen-form" method="post" action="" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="id" id="id_dokumen">
              <div class="form-group">
                <div class="input-group">
                    <select class="form-control select-bagian" name="id_bagian" id="select-bagian"><option></option></select>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                    <select class="form-control select-sub_kriteria" name="id_sub_kriteria" id="select-sub_kriteria"><option></option></select>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Judul Dokumen" name="judul" id="judul" required>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="customFile" name="dokumen">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <a class="mt-0" href="" id="dokumen"></a>
              </div>
              

              <div class="form-group">
                <div class="input-group">
                    <select class="form-control select-privasi" name="privasi" id="select-privasi"><option></option></select>
                </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="dokumen-form">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  

    <div class="card card-primary p-3">
        <div class="card-header">
            <h1>Dokumen</h1> <hr>
        </div>
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
        @elseif ($message = Session::get('warning'))
            <div class="alert alert-warning alert-dismissible show fade">
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
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-dokumen" id="addDokumen">
              <i class='fas fa-plus fa-9x' style='color:#ffffff'></i> Dokumen
            </button>
            <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#modal-validasi">
              <i class='fas fa-search fa-9x' style='color:#ffffff'></i> Dokumen
            </button>
          </div>
          
          <div class="wrap-table">
            <table class="table table-striped table-hover" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">judul</th>
                  <th>Kriteria</th>
                  <th class="text-center">Sub Kriteria</th>
                  <th class="text-center">bagian</th>
                  @if (in_array(Auth::user()->level, ['admin', 'super_admin']))
                    <th class="text-center" width="85px"><i class="fas fa-cog"></i></th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach ($dokumens as $dokumen => $row)
                  <tr>
                      <th class="text-center">{!!($row->privasi == 'private'?'<i class="fas fa-lock text-danger"></i>':'<i class="fas fa-lock-open text-success"></i>')!!}</th>
                      <td><a href="{{route('buka_file', $row['id'])}}">{{$row['judul']}}</a></td>
                      <td>{{$row->sub_kriteria->kriteria->nama_kriteria}}</td>
                      <td>{{$row->sub_kriteria->nama_sub_kriteria}}</td>
                      <td>{{$row->bagian->nama_bagian}}</td>
                      @if (in_array(Auth::user()->level, ['admin', 'super_admin']))
                        <td>
                            <form action="{{route('dokumen.destroy', $row['id'])}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="button" 
                                  class="btn btn-primary editDokumen" 
                                  data-toggle="modal" 
                                  data-target="#modal-dokumen"
                                  data-id="{{$row['id']}}" >
                                  <i class='far fa-edit fa-9x' style='color:#fff'></i>
                                </button>
                                <button class="btn btn-danger" type="submit"><i class='far fa-trash-alt fa-9x' style='color:#fff'></i></button>
                            </form>
                        </td>
                      @endif
                  </tr>
                 @endforeach
              </tbody>
            </table>
          </div>
        </div>
    </div>
@endsection

@push('js')
  <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(function(){
      var groupColumn = 4;
      var table = $('.table').DataTable({
          columnDefs: [{ visible: false, targets: groupColumn }],
          order: [[groupColumn, 'asc']],
          displayLength: 25,
          drawCallback: function (settings) {
              var api = this.api();
              var rows = api.rows({ page: 'current' }).nodes();
              var last = null;
      
              api.column(groupColumn, { page: 'current' })
                  .data()
                  .each(function (group, i) {
                      if (last !== group) {
                          $(rows)
                              .eq(i)
                              .before(
                                  '<tr class="group"><td colspan="5">' +
                                      group +
                                      '</td></tr>'
                              );
      
                          last = group;
                      }
                  });
          },
          scrollX:true
      });

      // Order by the grouping
      $('.table tbody').on('click', 'tr.group', function () {
          var currentOrder = table.order()[0];
          if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
              table.order([groupColumn, 'desc']).draw();
          }
          else {
              table.order([groupColumn, 'asc']).draw();
          }
      });
      const DataSubKriterias = {{Js::from(App\Models\sub_kriteria::all())}}
      const DataSubKriteria = DataSubKriterias.map(({id, nama_sub_kriteria}) => ({id:id, text:nama_sub_kriteria}))
      @if (in_array(Auth::user()->level, ['super_admin', 'admin']))
        const DataBagians = {{Js::from(App\Models\bagian::all())}}
      @else
        const DataBagians = {{Js::from(App\Models\bagian::where('id', '=', Auth::user()->id_bagian)->get())}}
      @endif
      const DataBagian = DataBagians.map(({id, nama_bagian}) => ({id:id, text:nama_bagian}))
      const privasi = ['public', 'private']
      
      $('.select-sub_kriteria').select2({
        placeholder:"Pilih Sub kriteria",
        dropdownParent: $("#modal-dokumen"),
        data:DataSubKriteria
      })

      $('.select-bagian').select2({
        placeholder:"Pilih Bagian",
        dropdownParent: $("#modal-dokumen"),
        data:DataBagian
      })

      $('.select-privasi').select2({
        placeholder:"Pilih Privasi",
        dropdownParent: $("#modal-dokumen"),
        tags:privasi
      })

      function inputDokumen(input){
        $('#id_dokumen').val(input.id||'')
        $('#judul').val(input.judul||'')
        $('#dokumen').html(input.judul||'')
        $('#dokumen').attr('href', "{{route('buka_file', '')}}/"+input.id)
        $('.select-bagian').val(input.id_bagian||'').trigger('change')
        $('.select-privasi').val(input.privasi||'').trigger('change')
        $('.select-sub_kriteria').val(input.id_sub_kriteria||'').trigger('change')
      }

      function addPutDokumen(){
        $('#dokumen-form').append('@method("PUT")')
      }

      function removePutDokumen(){
        $('[name="_method"][value="PUT"]').remove();
      }

      $('.DelDok').click(function(){
        let data = $(this).data('id')
        $('#delete_dokumen').attr('action', "{{route('dokumen.index', '')}}/"+data)
        $('#delete_dokumen').submit()
      })

      $('.unvalid').click(function(){
        let data = $(this).data('id')
        $('#unvalid').attr('action', "{{route('validasi')}}")
        $('#title-unvalid').html('Alasan Unvalid')

        $('#id_dokumen_unvalid').val(data||'')
        $('#modal-validasi').modal('hide')
      })

      $('.editDokumen').click(function(){
        $('#modal-validasi').modal('hide')
      })

      $('#addDokumen').click(function(){
        removePutDokumen()
        inputDokumen('')
        $('#dokumen-form').attr('action', "{{route('dokumen.store')}}")
        $('#title-dokumen').html('Tambah Dokumen')
      })

      $('.editDokumen').click(function(){
        let data = $(this).data('id')
        $('#dokumen-form').attr('action', "{{route('dokumen.index')}}/"+data)
        $('#title-dokumen').html('Edit Dokumen')

        removePutDokumen()
        addPutDokumen()

        $.ajax({
          type:"GET",
          url:"{{route('dokumen.index')}}/"+data,
          data:"id"+data,
          results: dokumens=>{
            const dokumen = dokumens.map(datadokumen=>{
              return {datadokumen}
            })

            results : dokumen
          },

          success:function(dokumen){
            inputDokumen(dokumen)
            console.log(dokumen.dokumen)
          }
        })
      })
      
      
    })
  </script>
@endpush