<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Auth;
use Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['judul'] = 'SIALIM';
        $data['sub_judul'] = "Akun";
        $data['akuns'] = User::where('level', '!=', 'super_admin')->where('level', '!=', 'tamu')->orderBy('id', 'desc')->get();
        if(Auth::user()->level == 'super_admin'){
            $data['akuns'] = User::orderBy('id', 'desc')->where('level', '!=', 'tamu')->get();
        }
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
        if(User::where("email",'=',$request->email)->where('level', '=', 'tamu')->first()){
            return redirect()->route('akun.index')->with(['danger'=>'Email sudah ada sebagai Tamu']);
        }
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required',
            'level'=>'required',  
            'id_bagian'=>'required',            
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['remember_token'] = Str::random(32);

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
        if(User::where("email",'=',$request->email)->where('level', '=', 'tamu')->first()){
            return redirect()->route('akun.index')->with(['danger'=>'Email sudah ada sebagai Tamu']);
        }
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$id.',id',
            'level'=>'required',
            'id_bagian'=>'required',           
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
