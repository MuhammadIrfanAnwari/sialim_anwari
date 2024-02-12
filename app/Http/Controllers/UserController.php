<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
// use Location;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['judul'] = 'SIALIM';
        $data['sub_judul'] = "Akun";
        $data['akuns'] = User::orderBy('id', 'desc')->get();
        return view('main.user', $data);
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
        // dd(Location::get($request->getClientIp()));
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'level'=>'required',            
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('akun.index')->with(['success'=>'Berhasil menambahkan '.$data['name']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::find($id);

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
            'name'=>'required',
            'email'=>'required',
            'level'=>'required',            
        ]);

        if($request->password){
            $data['password'] = bcrypt($request['password']);
        }

        $user = User::find($id);
        User::find($id)->update($data);
        return redirect()->route('akun.index')->with(['success'=>'Berhasil mengubah '.$user['name']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        User::find($id)->delete();

        return redirect()->route('akun.index')->with(['danger'=>'Berhasil menghapus '.$user['name']]);
    }
}
