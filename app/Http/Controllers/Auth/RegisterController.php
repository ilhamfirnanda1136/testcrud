<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,pegawai};
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration data.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
       
    }

    protected static function validasi(array $data)
    {
        $messages=[
            'required'=> ':attribute Wajib Diisi Semua!!!',
            'min'     => ':attribute ini Minimal 5 karakter',
          ];
          $validator = Validator::make($data, [
               'nra'           => 'required',
               'nama'           => 'required',
               'email'             => 'required|unique:users',
               'password'           => 'required',
               'jabatan_id'           => 'required',
               'tanggal_lahir'           => 'required',
               'province_id'           => 'required',
               'regencies_id'             => 'required',
               'district_id'           => 'required',
               'villages_id'           => 'required',
               'alamat'             => 'required',
               'no_telp'            => 'required',
               'dispos_id'          => 'required'
           ],$messages);
           return $validator;
    }

    public function customRegister(Request $request)
    {
        $validator=$this->validasi($request->all());
        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            DB::beginTransaction();
            try {
                if ($request->has('fotos')) {
                    $file=$request->file('fotos');
                    $nama_file='pegawai-'.date('Y').'-'.substr(md5(rand()),0,6).$file->getClientOriginalName();
                    $request->file('fotos')->move('img/pegawai/',$nama_file);
                    $request->merge(['foto' => $nama_file]);
                }
                $pegawai = pegawai::create($request->all());
                $user = new User();
                $user->name = $pegawai->nama;
                $user->email = $request->email;
                $user->pegawai_id = $pegawai->id;
                $user->password = Hash::make($request->password);
                $user->foto = $request->has('foto') ? $request->foto : '';
                $user->level = 2;
                $user->is_verif = 1;
                $user->save();
                Auth::login($user);
                DB::commit(); 
                Mail::to($request->email)->send(new registerMail($emaildata));
                return Redirect('/home');
            } catch (\Throwable $th) {
                DB::rollback();
                abort(500);
            }
        }
    }

    public function showRegistrationForm()
    {
        $provinsi = DB::table('provinces')->get();
        return view('auth.register', compact('provinsi'));
    }
}
