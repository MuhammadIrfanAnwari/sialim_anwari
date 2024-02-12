<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\bagian;

class BagianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['judul'] = 'SIALIM';
        $data['sub_judul'] = "Bagian";
        $data['bagians'] = bagian::orderBy('kode', 'asc')->get();
        return view('main.bagian', $data);
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
            'kode'=>'required|unique:bagians',
            'nama_bagian'=>'required',
        ]);

        bagian::create($data);

        return redirect()->route('bagian.index')->with(['success'=>'Berhasil menambahkan '.$data['nama_bagian']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = bagian::find($id);

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
            'kode'=>'required|unique:bagians,kode,'.$id.',id',
            'nama_bagian'=>'required',
        ]);

        $bagian = bagian::find($id);
        bagian::find($id)->update($data);
        return redirect()->route('bagian.index')->with(['success'=>'Berhasil mengubah '.$bagian['nama_bagian']." menjadi ".$data['nama_bagian']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bagian = bagian::find($id);
        bagian::find($id)->delete();

        return redirect()->route('bagian.index')->with(['danger'=>'Berhasil menghapus '.$bagian['nama_bagian']]);
    }
}
