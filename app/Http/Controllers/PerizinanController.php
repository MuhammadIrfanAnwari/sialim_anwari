<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\dokumen;
use App\Models\perizinan;
use Auth;
use Str;

class PerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['judul'] = 'SIALIM';
        $data['sub_judul'] = "Perizinan";
        $data['akuns'] = User::where('level', '=', 'tamu')->orderBy('id', 'desc')->get();
        $data['dokumen'] = Dokumen::select('dokumens.*', 'id_kriteria')->join('sub_kriterias', 'id_sub_kriteria', 'sub_kriterias.id')->orderBy('id_kriteria', 'asc')->get();
        return view('main.perizinan', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $perizinan = [];
        if(User::where("email",'=',$request->email)->where('level', '!=', 'tamu')->first()){
            return redirect()->route('perizinan.index')->with(['danger'=>'Email sudah dipakai sebagai user']);
        }
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users',
            'masa_berlaku'=>'required',            
        ]);

        $izin = $request->validate([
            'id_dokumen'=>'required',
        ]);

        $data['level'] = 'tamu';
        $data['id_bagian'] = 1;
        $data['password'] = bcrypt('tamu');
        $data['remember_token'] = Str::random(22).time();

        $user = User::create($data);

        for($i = 0; $i < count($izin['id_dokumen']); $i++){
            perizinan::create([
                'id_user'=>$user->id,
                'id_dokumen'=>$izin['id_dokumen'][$i],
            ]);
        }

        return redirect()->route('perizinan.index')->with(['success'=>'Berhasil menambahkan '.$data['name']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::with('perizinan')->find($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $perizinan = [];
        if(User::where("email",'=',$request->email)->where('level', '!=', 'tamu')->first()){
            return redirect()->route('perizinan.index')->with(['danger'=>'Email sudah dipakai sebagai user']);
        }

        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$id.',id',
            'masa_berlaku'=>'required',            
        ]);

        $izin = $request->validate([
            'id_dokumen'=>'required',
        ]);
        // dd($izin['id_dokumen'][0]);
        perizinan::where('id_user', '=', $id)->delete();

        $data['level'] = 'tamu';
        $data['id_bagian'] = 1;
        $data['password'] = bcrypt('tamu');
        $data['remember_token'] = Str::random(22).time();

        $user = User::find($id)->update($data);

        for($i = 0; $i < count($izin['id_dokumen']); $i++){
            perizinan::create([
                'id_user'=>$id,
                'id_dokumen'=>$izin['id_dokumen'][$i],
            ]);
        }

        return redirect()->route('perizinan.index')->with(['success'=>'Berhasil mengubah '.$data['name']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        User::find($id)->delete();
        return redirect()->route('perizinan.index')->with(['danger'=>'Berhasil menghapus '.$user->name]);
    }
}
