@extends('partial.main')

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('kontent')
<div class="modal modal-centered fade" id="modal-sub_kriteria" tabindex="-1" role="dialog" aria-labelledby="title-sub_kriteria" aria-hidden="true" data-mdb-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title-sub_kriteria">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  id="sub_kriteria-form" method="post" action="">
              @csrf
              <input type="hidden" name="id" id="id_sub_kriteria">
              <div class="form-group">
                <div class="input-group">
                    <select class="form-control select-kriteria" name="id_kriteria" id="select-kriteria"><option></option></select>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nama Sub Kriteria" name="nama_sub_kriteria" id="nama" required>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                    <textarea class="form-control" placeholder="Deskripsi Kriteria" name="deskripsi" id="deskripsi" required></textarea>
                </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="sub_kriteria-form">Save changes</button>
        </div>
      </div>
    </div>
  </div>

    <div class="card card-primary p-3">
        <div class="card-header">
            <h1>Sub Kriteria</h1> <hr>
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
          <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-sub_kriteria" id="addKriteria">
            <i class='fas fa-plus fa-9x' style='color:#ffffff'></i> Sub Kriteria
          </button>

          <div class="wrap-table">
            <table class="table table-striped table-hover" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Nama Sub Kriteria</th>
                  <th class="text-center">Deskripsi</th>
                  <th class="text-center">Kriteria</th>
                  <th class="text-center" width="85px"><i class="fas fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($sub_kriterias as $sub_kriteria => $row)
                  <tr>
                      <th class="text-center">#</th>
                      <td>{{$row['nama_sub_kriteria']}}</td>
                      <td>{{$row['deskripsi']}}</td>
                      <td>{{$row->kriteria->nama_kriteria}}</td>
                      <td>
                          <form action="{{route('sub_kriteria.destroy', $row['id'])}}" method="post">
                              @csrf
                              @method('delete')
                              <button type="button" 
                                    class="btn btn-primary editKriteria" 
                                    data-toggle="modal" 
                                    data-target="#modal-sub_kriteria"
                                    data-id="{{$row['id']}}" >
                                <i class='far fa-edit fa-9x' style='color:#fff'></i>
                              </button>
                              <button class="btn btn-danger" type="submit"><i class='far fa-trash-alt fa-9x' style='color:#fff'></i></button>
                          </form>
                      </td>
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
    $('.table').dataTable({scrollX:true})
    $(function(){
      const DataKriterias = {{Js::from(App\Models\kriteria::all())}}
      const DataKriteria = DataKriterias.map(({id, nama_kriteria}) => ({id:id, text:nama_kriteria}))
      
      $('.select-kriteria').select2({
        placeholder:"Pilih kriteria",
        dropdownParent: $("#modal-sub_kriteria"),
        data:DataKriteria
      })

      function inputSubKriteria(input){
        $('#nama').val(input.nama_sub_kriteria||'')
        $('#id_sub_kriteria').val(input.id||'')
        $('#deskripsi').val(input.deskripsi||'')
        $('.select-kriteria').val(input.id_kriteria||'').trigger('change')
      }

      function addPutKriteria(){
        $('#sub_kriteria-form').append('@method("PUT")')
      }

      function removePutkriteria(){
        $('[name="_method"][value="PUT"]').remove();
      }

      $('#addKriteria').click(function(){
        removePutkriteria()
        inputSubKriteria('')
        $('#sub_kriteria-form').attr('action', "{{route('sub_kriteria.store')}}")
        $('.modal-title').html('Tambah Sub Kriteria')
      })

      $('.editKriteria').click(function(){
        let data = $(this).data('id')
        $('#sub_kriteria-form').attr('action', "{{route('sub_kriteria.index')}}/"+data)
        $('.modal-title').html('Edit Sub Kriteria')

        removePutkriteria()
        addPutKriteria()

        $.ajax({
          type:"GET",
          url:"{{route('sub_kriteria.index')}}/"+data,
          data:"id"+data,
          results: sub_kriterias=>{
            const sub_kriteria = sub_kriterias.map(datasub_Kriteria=>{
              return {datasub_Kriteria}
            })

            results : sub_kriteria
          },

          success:function(sub_kriteria){
            inputSubKriteria(sub_kriteria)
            console.log(sub_kriteria)
          }
        })
      })
      
      
    })
  </script>
@endpush