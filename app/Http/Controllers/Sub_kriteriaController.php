<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\sub_kriteria;

class Sub_kriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['judul'] = 'SIALIM';
        $data['sub_judul'] = "Sub Kriteria";
        $data['sub_kriterias'] = sub_kriteria::orderBy('nama_sub_kriteria', 'asc')->get();
        return view('main.sub_kriteria', $data);
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
            'id_kriteria'=>'required',
            'nama_sub_kriteria'=>'required',
            'deskripsi'=>'required',
        ]);

        sub_kriteria::create($data);

        return redirect()->route('sub_kriteria.index')->with(['success'=>'Berhasil menambahkan '.$data['nama_sub_kriteria']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = sub_kriteria::find($id);

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
            'id_kriteria'=>'required',
            'nama_sub_kriteria'=>'required',
            'deskripsi'=>'required',
        ]);

        $sub_kriteria = sub_kriteria::find($id);
        sub_kriteria::find($id)->update($data);
        return redirect()->route('sub_kriteria.index')->with(['success'=>'Berhasil mengubah '.$sub_kriteria['nama_sub_kriteria']." menjadi ".$data['nama_sub_kriteria']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sub_kriteria = sub_kriteria::find($id);
        sub_kriteria::find($id)->delete();

        return redirect()->route('sub_kriteria.index')->with(['danger'=>'Berhasil menghapus '.$sub_kriteria['nama_sub_kriteria']]);
    }
}
