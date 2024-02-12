<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\pengunjung;
use App\Models\dokumen;
use App\Models\downloaded;
use App\Models\validasi;

use Auth;

class DashboardController extends Controller
{
    function index(){
        $data['judul'] = "SIALIM";
        $data['sub_judul'] = "Dashboard";
        $data['jml_dokumen'] = dokumen::all()->count();
        $data['top_dok'] = downloaded::selectRaw("count(*) as total, id_dokumen")->groupBy('id_dokumen')->orderBy('total', 'desc')->get();
        // dd($data['top_dok']);
        
        if(in_array(Auth::user()->level, ['admin', 'super_admin'])){
            $data['jml_valid'] = dokumen::where('status', '=', 'valid')->count();
            $data['jml_unvalid'] = dokumen::where('status', '=', 'unvalid')->count();
            $data['jml_menunggu'] = dokumen::where('status', '=', 'menunggu')->count();
            $data['jml_dokumen'] = dokumen::all()->count();
            $data['dokumen_ditolak'] = dokumen::where('status', '=', 'unvalid')->get();
        } else {
            $data['jml_valid'] = dokumen::where('status', '=', 'valid')->where('id_user', Auth::user()->id)->count();
            $data['jml_unvalid'] = dokumen::where('status', '=', 'unvalid')->where('id_user', Auth::user()->id)->count();
            $data['jml_menunggu'] = dokumen::where('status', '=', 'menunggu')->where('id_user', Auth::user()->id)->count();
            $data['jml_dokumen'] = dokumen::where('id_user', Auth::user()->id)->count();
            $data['dokumen_ditolak'] = dokumen::where('status', '=', 'unvalid')->where('id_user', Auth::user()->id)->get();
        }

        return view('main.dashboard', $data);
    }
}
