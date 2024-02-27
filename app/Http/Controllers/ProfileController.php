<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class ProfileController extends Controller
{
    function index(){

    }

    function edit(Request $request){
        $data = $request->validate([
            'id'=>'required',
            'name'=>'required',
            'no_wa'=>'required',
            'email'=>'required|unique:users,email,'.$request->id.',id',
        ]);

        if($request['password'] == $request['konfirmasi_password']){
            $data['password'] = bcrypt($request->password);
            User::find($data['id'])->update($data);
            return redirect()->back()->with(['success'=>"Berhasil Mengubah Data Profile"]);
        } else {
            return redirect()->back()->with(['danger'=>"Password & Konfirmasi Password harus sama"]);
        }

        return redirect()->back()->with(['error'=>"Gagal Mengubah Data Profile"]);
    }
}
