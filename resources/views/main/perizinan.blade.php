@extends('partial.main')

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
@endpush

@section('kontent')
<div class="modal modal-centered fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="title-user" aria-hidden="true" data-mdb-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title-user">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  id="user-form" method="post" action="">
              @csrf
              <input type="hidden" name="id" id="id_user">
              
              <div class="form-group">
                <label for="name" class="form-lable">Name Tamu</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nama User" name="name" id="name" required>
                </div>
              </div>

              <div class="form-group">
                <label for="email_user" class="form-lable">Email Tamu</label>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email User" name="email" id="email_user" required>
                </div>
              </div>

              <div class="form-group">
                <label for="masa_berlaku" class="form-lable">Masa Berlaku</label>
                <div class="input-group">
                    
                    <input type="date" class="form-control" placeholder="Batas Waktu" name="masa_berlaku" id="masa_berlaku" required>
                </div>
              </div>

            <div class="wrap-table">
                <table class="table table-striped table-hover" id="table-izin" style="width:100%">
                    <thead style="width: 100%">
                        <tr>
                            <th width="20px">#</th>
                            <th>Nama</th>
                            <th>bagian</th>
                            <th>kriteria</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach ($dokumen as $dok => $row)
                            <tr>
                                <td><input type="checkbox" value="{{$row->id}}" id="cb-{{$row->id}}" name="id_dokumen[]"></td>
                                <td>{{$row->judul}}</td>
                                <td>{{$row->bagian->nama_bagian}}</td>
                                <td>{{$row->sub_kriteria->kriteria->nama_kriteria}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="user-form">Save changes</button>
        </div>
      </div>
    </div>
  </div>

    <div class="card card-primary p-3">
        <div class="card-header">
            <h1>Perizinan</h1> <hr>
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
          <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-user" id="addUser">
            <i class='fas fa-plus fa-9x' style='color:#ffffff'></i> User
          </button>

          <div class="wrap-table">
            <table class="table table-striped table-hover" id="table-user" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Nama User</th>
                  <th class="text-center">email</th>
                  <th class="text-center">level</th>
                  <th class="text-center" width="150px"><i class="fas fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($akuns as $akun => $row)
                  <tr>
                      <th class="text-center">#</th>
                      <td>{{$row['name']}}</td>
                      <td>{{$row['email']}}</td>
                      <td>{{$row['level']}}</td>
                      <td>
                          <input type="hidden" value="Berikut adalah token hak akses : {{$row->remember_token}}" id="text-copy-{{$row->id}}">
                          <form action="{{route('perizinan.destroy', $row['id'])}}" method="post">
                              @csrf
                              @method('delete')
                              
                              <button class="btn btn-info" type="button" id="button-copy-{{$row->id}}"><i class="fas fa-share-alt-square"></i></button>
                              <button type="button" 
                                    class="btn btn-primary editUser" 
                                    data-toggle="modal" 
                                    data-target="#modal-user"
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
    
    $(function(){
    $('#table-user').dataTable({scrollX:true})

    var groupColumn = 2;
    var table = $('#table-izin').DataTable({
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
    $('#table-izin tbody').on('click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
            table.order([groupColumn, 'desc']).draw();
        }
        else {
            table.order([groupColumn, 'asc']).draw();
        }
    });

      @if(Auth::user()->level == 'super_admin')
        const level = ['super_admin', 'admin', 'user', 'tamu'];
      @else
        const level = ['admin', 'user', 'tamu'];
      @endif
      const bagians = {{Js::from(App\Models\Bagian::all())}}
      const bagian = bagians.map(({id, nama_bagian})=>({id:id, text:nama_bagian}))
      console.log(bagian)
      
      $('.select-level').select2({
        placeholder:"Pilih Level",
        dropdownParent: $("#modal-user"),
        tags:level
      })

      $('.select-bagian').select2({
        placeholder:"Pilih Bagian",
        dropdownParent: $("#modal-user"),
        data:bagian
      })

      function uncheck(){
        $('input:checkbox').prop('checked', false)
      }

      function inputUser(input){
        uncheck()
        $('#name').val(input.name||'')
        $('#id_user').val(input.id||'')
        $('#email_user').val(input.email||'')
        $('#masa_berlaku').val(input.masa_berlaku||'')
        for(var i = 0; i < input.perizinan.length; i++){
          $('#cb-'+input.perizinan[i].id_dokumen).prop('checked', true)
        }
        
      }

      function addPutUser(){
        $('#user-form').append('@method("PUT")')
      }

      function removePutUser(){
        $('[name="_method"][value="PUT"]').remove();
      }

      for(var i = 0; i < $('[id*=button-copy-]').length; i++){
        var id_btn = $('[id*=button-copy-]')[i].id.split('-')[2]
        $('#button-copy-'+id_btn).click(function(){
          var id_text = this.id.split('-')[2]
          console.log(id_text)
          $('#text-copy-'+id_text).select();
          navigator.clipboard.writeText($('#text-copy-'+id_text).val());
          alert($('#text-copy-'+id_text).val())
        })
      }

      $('#addUser').click(function(){
        removePutUser()
        inputUser('')
        $('#user-form').attr('action', "{{route('perizinan.store')}}")
        $('.modal-title').html('Tambah User')
      })

      $('.editUser').click(function(){
        let data = $(this).data('id')
        $('#user-form').attr('action', "{{route('perizinan.index')}}/"+data)
        $('.modal-title').html('Edit User')

        removePutUser()
        addPutUser()

        $.ajax({
          type:"GET",
          url:"{{route('perizinan.index')}}/"+data,
          data:"id"+data,
          results: users=>{
            const user = users.map(datauser=>{
              return {datauser}
            })

            results : user
          },

          success:function(user){
            inputUser(user)
            console.log(user)
          }
        })
      })
      
      
    })
  </script>
@endpush