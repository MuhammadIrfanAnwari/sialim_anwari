<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\dokumen;
use App\Models\validasi;
use App\Models\downloaded;

use Auth;
use Storage;
use File;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['judul'] = 'SIALIM';
        $data['sub_judul'] = "Dokumen";
        $data['dokumens'] = dokumen::where('status', '=', 'valid')->orderBy('id', 'desc')->get();
        $data['dokumen_validasi'] = dokumen::where('status', '=', 'menunggu')->orWhere('status', '=', 'unvalid')->orderBy('status', 'asc')->orderBy('id', 'desc')->get();
        return view('main.dokumen', $data);
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
        $data = $request->validate([
            'id_bagian'=>'required',
            'id_sub_kriteria'=>'required',
            'judul'=>'required',
            'dokumen'=>'required|mimes:pdf,xlsx',
            'privasi'=>'required'
        ]);

        $data['dokumen'] = time().".".$data['dokumen']->extension();
        $request->file('dokumen')->storeAs('', $data['dokumen'], ['disk'=>'private']);
        $data['status'] = 'menunggu';
        $data['id_user'] = Auth::user()->id;
        if(in_array(Auth::user()->level, ['super_admin', 'admin'])){
            $data['status'] = 'valid';
        }
        $dok = dokumen::create($data);

        if($data['status'] == 'valid'){
            $validasi['id_user'] = Auth::user()->id;
            $validasi['status'] = $dok['status'];
            $validasi['id_dokumen'] = $dok['id'];
            $validasi['alasan'] = "Diinput oleh admin";
            validasi::create($validasi);
        }
        

        return redirect()->route('dokumen.index')->with(['success'=>'Berhasil menambahkan'.$data['judul']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = dokumen::find($id);

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
        $data = $request->validate([
            'id_bagian'=>'required',
            'id_sub_kriteria'=>'required',
            'judul'=>'required',
            'dokumen'=>'nullable|mimes:pdf,xlsx',
            'privasi'=>'required'
        ]);

        $dokumenOld = dokumen::find($id);

        if($request->dokumen){
            \Storage::delete('private/'.$dokumenOld->dokumen);
            $data['dokumen'] = time().".".$data['dokumen']->extension();
            $request->file('dokumen')->storeAs('', $data['dokumen'], ['disk'=>'private']);
        }

        $data['status'] = 'menunggu';
        $data['id_user'] = Auth::user()->id;
        if(in_array(Auth::user()->level, ['super_admin', 'admin'])){
            $data['status'] = 'valid';
        }
        $dokumenOld->update($data);

        return redirect()->route('dokumen.index')->with(['success'=>'Berhasil mengubah dokumen '.$dokumenOld->judul]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen = dokumen::find($id);
        if($dokumen->privasi == 'valid'){
            dokumen::find($id)->delete();
        } else {
            validasi::where('id_dokumen', '=', $id)->delete();
            downloaded::where('id_dokumen', '=', $id)->delete();
            Storage::delete('private/'.$dokumen->dokumen);
            dokumen::find($id)->forceDelete();
        }
        return redirect()->route('dokumen.index')->with(['danger'=>'Berhasil menghapus dokumen '.$dokumen->judul]);
    }

    public function buka_file(String $id){
        $dokumen = dokumen::find($id);
        if ($dokumen['privasi'] == 'public') {
            $downloaded['ip'] = \Request::ip();
            $downloaded['id_dokumen'] = $id;
            $downloaded['tanggal'] = date('Y-m-d');
            downloaded::create($downloaded);

            return Storage::download('private/'.$dokumen['dokumen']);
        } elseif($dokumen['privasi'] == 'private'){
            if (in_array(Auth::user()->level, ['admin', 'super_admin']) || $dokumen['id_user'] == Auth::user()->id) {
                $downloaded['ip'] = \Request::ip();
                $downloaded['id_dokumen'] = $id;
                $downloaded['tanggal'] = date('Y-m-d');
                downloaded::create($downloaded);
                return Storage::download('private/'.$dokumen['dokumen']);
            } else {
                return redirect()->route('dokumen.index')->with(['danger'=>'Anda tidak diizinkan membuka file '.$dokumen['judul']]);
            }
        }
        return redirect()->route('dokumen.index')->with(['danger'=>'Gagal mendownload file '.$dokumen['judul']]);
    }

    public function validasi(Request $request){
        $data = $request->validate([
            'id_dokumen'=>'required',
            'alasan'=>'nullable',
            'status'=>'required',
        ]);
        $dokumen = dokumen::find($data['id_dokumen']);

        if(in_array(Auth::user()->level, ['admin', 'super_admin'])){
            $data['id_user'] = Auth::user()->id;
            validasi::create($data);
            $dokumen->update(['status'=>$data['status']]);
            if($data['status']=='unvalid'){
                return redirect()->route('dokumen.index')->with(['warning'=>'Berhasil meng-unvalidasi '.$dokumen['judul']]);
            } else {
                return redirect()->route('dokumen.index')->with(['success'=>'Berhasil memvalidasi '.$dokumen['judul']]);
            }
        }
        return redirect()->route('dokumen.index')->with(['danger'=>'Gagal memvalidasi '.$dokumen['judul']]);
    }
}
