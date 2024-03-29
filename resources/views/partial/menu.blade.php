<ul class="sidebar-menu">
    <li class="{{($sub_judul == 'Dashboard'?'active':'')}}">
      <a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
    </li>
    <li class="nav-item dropdown {{($sub_judul == 'Kriteria'||$sub_judul=='Sub Kriteria'?'active':'')}}">
      <a href="#" class="nav-link has-dropdown"><i class="far fa-folder-open"></i><span>Perkriteria</span></a>
      <ul class="dropdown-menu">
        <li class="{{($sub_judul == 'Kriteria'?'active':'')}}"><a class="nav-link" href="{{route('kriteria.index')}}">Kriteria</a></li>
        <li class="{{($sub_judul == 'Sub Kriteria'?'active':'')}}"><a class="nav-link" href="{{route('sub_kriteria.index')}}">Sub Kriteria</a></li>
      </ul>
    </li>
    <li class="{{($sub_judul == 'Bagian'?'active':'')}}">
      <a class="nav-link" href="{{route('bagian.index')}}"><i class="fas fa-book"></i> <span>Bagian</span></a>
    </li>
    <li class="{{($sub_judul == 'Dokumen'?'active':'')}}">
      <a class="nav-link" href="{{route('dokumen.index')}}">
        <i class="far fa-file-alt"></i> <span>Dokumen</span> 
        @if(\App\Models\dokumen::where('status', '=', 'menunggu')->count() > 0)
          <i class="fas fa-circle text-danger"></i>{{\App\Models\dokumen::where('status', '=', 'menunggu')->get()->count()}}
        @endif
      </a>
    </li>
    @if (in_array(Auth::user()->level, ['admin', 'super_admin']))
      <li class="{{($sub_judul == 'Akun'?'active':'')}}">
        <a class="nav-link" href="{{route('akun.index')}}"><i class="fas fa-user-alt"></i> <span>User</span></a>
      </li>
      <li class="{{($sub_judul == 'Perizinan'?'active':'')}}">
        <a class="nav-link" href="{{route('perizinan.index')}}"><i class="fas fa-user-check"></i> <span>Perizinan</span></a>
      </li>
    @endif
    
    
  </ul>

  <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="{{route('logout')}}" class="btn btn-danger btn-lg btn-block btn-icon-split text-white">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>
