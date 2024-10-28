<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Validator,Auth;

class userController extends Controller
{
    public function profile()
    {
        return view('user.profile');
    }

    protected function validasi(array $data)
    {
        $messages=[
         'required'=> ':attribute Wajib Diisi Semua!!!',
         'min'     => ':attribute ini Minimal 5 karakter',
       ];
       $validator = Validator::make($data, [
            'alamat'            => 'required|min:5',
            'no_telp'           => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string','max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ],$messages);
        return $validator;
    }

    public function profileUpdate(Request $request)
    {
        $validator=$this->validasi($request->all());
        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            if ($request->has('foto')) {
                $file=$request->file('foto');
                $nama_file='user-'.date('Y').'-'.substr(md5(rand()),0,6).$file->getClientOriginalName();
                $request->file('foto')->move('img/user/',$nama_file);
            }
            User::updateOrCreate(['id' => $request->id],$request->merge(['foto' => $nama_file]));
            return Redirect('/profil')->with('sukses','Terima kasih data profil telah diubah');
        }
    }

    public function gantiPassword()
    {
        return view('user.password');
    }

    public function gantiPasswordSave(Request $request)
    {
        $this->validate($request,[
            'oldpassword'=>'required',
            'password'=>'required|confirmed|min:5'
          ],['required'=>'Form ini harus diisi','confirmed'=>'konfirmasi password harus sama dengan password baru']);
          $hashedPassword=Auth::user()->password;
          if (Hash::check($request->oldpassword,$hashedPassword)) {
            $user=user::find(Auth::user()->id);
            $user->password=Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route('login')->with('successMSG','Password Telah diubah');
          }
          else{
            return redirect()->back()->with('errorMSG','Password tidak sama dengan password lama');
          }
    }

}
