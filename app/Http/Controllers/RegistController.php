<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peserta;
use App\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RegistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('registrasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validasi form
        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'unique:srtf_peserta'
        ],[
            'foto.mimes' => 'Format Foto Harus JPG atau PNG',
            'foto.max' => 'Maksimal Ukuran Foto 2MB',
            'foto.image' => 'Hanya Upload foto',
            'email.unique' => 'Email Sudah terdaftar!!'
        ]);
        // simpan data peserta
        $data = new Peserta;
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;
        $data->email = $request->email;
        $data->pekerjaan = $request->pekerjaan;
        $data->instansi = $request->instansi;
        // handle upload Foto
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);
        if ($files = $request->file('foto')) {
            $destinationPath = 'uploads/foto/member/'.$dir_name; // upload path
            $file = $dir_name."_lampiran_foto_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->foto = $file;
        }
        $peserta = $data->save();
        $password = str_random(8);
        if ($peserta) {
            $user = new User;
            $user->username = strtolower($request->email);
            $user->email = strtolower($request->email);
            $user->password = Hash::make($password);
            $user->name = $request->nama;
            $user->role_id = 2;
            $user->is_active = 1;
        }
        return redirect('registrasi')->with('success', 'Registrasi berhasil, silahkan konfirmasi email');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
