@extends('partial.main')

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('kontent')
<div class="modal modal-centered fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="title-user" aria-hidden="true" data-mdb-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
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
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nama User" name="name" id="name" required>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email User" name="email" id="email_user" required>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                    <input type="password" class="form-control" placeholder="Password User" name="password">
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                    <select class="form-control select-level" name="level" id="select-level"><option></option></select>
                </div>
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
            <h1>User</h1> <hr>
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
            <table class="table table-striped table-hover" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Nama User</th>
                  <th class="text-center">email</th>
                  <th class="text-center">level</th>
                  <th class="text-center" width="85px"><i class="fas fa-cog"></i></th>
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
                          <form action="{{route('akun.destroy', $row['id'])}}" method="post">
                              @csrf
                              @method('delete')
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
    $('.table').dataTable({scrollX:true})
    $(function(){
      level = ['super_admin', 'admin', 'user', 'tamu'];
    // console.log(level)
      
      $('.select-level').select2({
        placeholder:"Pilih Level",
        dropdownParent: $("#modal-user"),
        tags:level
      })

      function inputUser(input){
        $('#name').val(input.name||'')
        $('#id_user').val(input.id||'')
        $('#email_user').val(input.email||'')
        $('.select-level').val(input.level||'').trigger('change')
      }

      function addPutUser(){
        $('#user-form').append('@method("PUT")')
      }

      function removePutUser(){
        $('[name="_method"][value="PUT"]').remove();
      }

      $('#addUser').click(function(){
        removePutUser()
        inputUser('')
        $('#user-form').attr('action', "{{route('akun.store')}}")
        $('.modal-title').html('Tambah User')
      })

      $('.editUser').click(function(){
        let data = $(this).data('id')
        $('#user-form').attr('action', "{{route('akun.index')}}/"+data)
        $('.modal-title').html('Edit User')

        removePutUser()
        addPutUser()

        $.ajax({
          type:"GET",
          url:"{{route('akun.index')}}/"+data,
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