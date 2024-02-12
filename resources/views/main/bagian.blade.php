@extends('partial.main')

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('kontent')
<div class="modal modal-centered fade" id="modal-bagian" tabindex="-1" role="dialog" aria-labelledby="title-bagian" aria-hidden="true" data-mdb-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title-bagian">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  id="bagian-form" method="post" action="">
              @csrf
              <input type="hidden" name="id" id="id_bagian">
              <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Kode Bagian" name="kode" id="kode" required>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nama Bagian" name="nama_bagian" id="nama" required>
                </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="bagian-form">Save changes</button>
        </div>
      </div>
    </div>
  </div>

    <div class="card card-primary p-3">
        <div class="card-header">
            <h1>Bagian</h1> <hr>
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
          <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-bagian" id="addBagian">
            <i class='fas fa-plus fa-9x' style='color:#ffffff'></i> Bagian
          </button>

          <div class="wrap-table">
            <table class="table table-striped table-hover" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Kode</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center" width="85px"><i class="fas fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($bagians as $bagian => $row)
                  <tr>
                      <th class="text-center">#</th>
                      <td>{{$row['kode']}}</td>
                      <td>{{$row['nama_bagian']}}</td>
                      <td>
                          <form action="{{route('bagian.destroy', $row['id'])}}" method="post">
                              @csrf
                              @method('delete')
                              <button type="button" 
                                    class="btn btn-primary editBagian" 
                                    data-toggle="modal" 
                                    data-target="#modal-bagian"
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
      function inputBagian(input){
        $('#nama').val(input.nama_bagian||'')
        $('#id_bagian').val(input.id||'')
        $('#kode').val(input.kode||'')
      }

      function addPutBagian(){
        $('#bagian-form').append('@method("PUT")')
      }

      function removePutBagian(){
        $('[name="_method"][value="PUT"]').remove();
      }

      $('#addBagian').click(function(){
        removePutBagian()
        inputBagian('')
        $('#bagian-form').attr('action', "{{route('bagian.store')}}")
        $('.modal-title').html('Tambah Bagian')
      })

      $('.editBagian').click(function(){
        let data = $(this).data('id')
        $('#bagian-form').attr('action', "{{route('bagian.index')}}/"+data)
        $('.modal-title').html('Edit Bagian')

        removePutBagian()
        addPutBagian()

        $.ajax({
          type:"GET",
          url:"{{route('bagian.index')}}/"+data,
          data:"id"+data,
          results: bagians=>{
            const bagian = bagians.map(databagian=>{
              return {databagian}
            })

            results : bagian
          },

          success:function(bagian){
            inputBagian(bagian)
            console.log(bagian)
          }
        })
      })
      
      
    })
  </script>
@endpush