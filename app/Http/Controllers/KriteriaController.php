<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\kriteria;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['judul'] = 'SIALIM';
        $data['sub_judul'] = "Kriteria";
        $data['kriterias'] = kriteria::orderBy('singkatan', 'asc')->get();
        return view('main.kriteria', $data);
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
            'singkatan'=>'required|unique:kriterias',
            'nama_kriteria'=>'required',
            'deskripsi'=>'required',
        ]);

        kriteria::create($data);

        return redirect()->route('kriteria.index')->with(['success'=>'Berhasil menambahkan '.$data['nama_kriteria']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = kriteria::find($id);

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
            'singkatan'=>'required|unique:kriterias,singkatan,'.$id.',id',
            'nama_kriteria'=>'required',
            'deskripsi'=>'required',
        ]);

        $kriteria = kriteria::find($id);
        kriteria::find($id)->update($data);
        return redirect()->route('kriteria.index')->with(['success'=>'Berhasil mengubah '.$kriteria['nama_kriteria']." menjadi ".$data['nama_kriteria']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kriteria = kriteria::find($id);
        kriteria::find($id)->delete();

        return redirect()->route('kriteria.index')->with(['danger'=>'Berhasil menghapus '.$kriteria['nama_kriteria']]);
    }
}
