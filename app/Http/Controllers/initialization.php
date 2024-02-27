<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use App\models\tampilan;
use App\models\bagian;

use Auth;

class initialization extends Controller
{
    public function index(){
        if(User::all()->count()>0){
            return redirect()->route('login')->with(['error'=>'Tidak bisa melakukan initialization kembali! Silahkan Hubungi Admin']);
        }
        return view('init');
    }

    public function store(Request $request){
        if(User::all()->count()>0){
            return redirect()->route('login')->with(['error'=>'Tidak bisa melakukan initialization kembali! Silahkan Hubungi Admin']);
        }
        $app = $request->validate([
            'nama_pt' => 'required',
            'no_wa'=>'required',
            'logo_kecil' => 'required|image|mimes:png,jpg,jpeg',
            'logo_sialim' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        

        $akun = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm-password' => 'required|same:password'
        ]);
        
        $logo_kecil = time().'.'.$request->logo_kecil->extension();
        $logo_sialim = time().'1'.'.'.$request->logo_sialim->extension();    
         
        $request->logo_kecil->move(public_path('assets/img/logo'), $logo_kecil);
        $request->logo_sialim->move(public_path('assets/img/logo'), $logo_sialim);
        
        $app['logo_sialim'] = $logo_sialim;
        $app['logo_kecil'] = $logo_kecil;

        tampilan::create($app);

        if(bagian::where('kode','=','LPM')->get()->count() == 0){
            bagian::insert([
                'kode'=>'LPM',
                'nama_bagian'=>'Lembaga Penjaminan Mutu',
                'id'=>1
            ]);
        }

        $akun['password'] = bcrypt($request['password']);
        $akun['level'] = 'super_admin';
        $akun['is_super'] = 1;
        $akun['id_bagian'] = 1;

        User::create($akun);

        return redirect()->route('login')->with(['success'=>'Berhasil melakukan Initialization!']);
    }

    public function update(Request $request, $id){
        // dd($request->all());
        if (Auth::user()->level != 'super_admin') {
            return redirect()->back()->with(['danger'=>'Anda Tidak Memiliki hak akses mengubah tampilan!']);
        }
        $app = $request->validate([
            'nama_pt' => 'required',
            'no_wa'=>'required',
            'logo_kecil' => 'nullable|image|mimes:png,jpg,jpeg',
            'logo_sialim' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);
        

        $tampilan = tampilan::orderBy('id', 'desc')->first();
        // dd($tampilan);
        $app['logo_kecil'] = $tampilan->logo_kecil;
        $app['logo_sialim'] = $tampilan->logo_sialim;

        if($request['logo_kecil']){
            $logo_kecil = time().'.'.$request->logo_kecil->extension();
            $request->logo_kecil->move(public_path('assets/img/logo'), $logo_kecil);
            $app['logo_kecil'] = $logo_kecil;
        }

        if($request['logo_sialim']){
            $logo_sialim = time().'1'.'.'.$request->logo_sialim->extension();   
            $request->logo_sialim->move(public_path('assets/img/logo'), $logo_sialim);
            $app['logo_sialim'] = $logo_sialim;
        }

        tampilan::create($app);
        return redirect()->back()->with(['success'=>'Berhasil merubah tampilan!']);
    }

    public function destroy(){
        
    }
}
