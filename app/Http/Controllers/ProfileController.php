<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seminar;
use App\Peserta;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function edit(Request $request)
    {
        $peserta = Peserta::all();
        $seminar = Seminar::all();
        return view('profile.edit', ['user' => $request->user()])->with(compact('seminar','peserta'));
    }

    public function update(Request $request)
    {
        // $request->user()->update($request->all());
        $data['nama'] = $request->nama;
        $data['no_hp'] = $request->no_hp;
        $data['email'] = $request->email;
        $data['pekerjaan'] = $request->pekerjaan;
        $data['instansi'] = $request->instansi;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);
        if ($files = $request->file('foto')) {
            $destinationPath = 'uploads/peserta/'.$dir_name; // upload path
            $file = "foto_".$dir_name.Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data['foto'] = $dir_name."/".$file;
        }
              
        Peserta::select('id')->where('user_id','=',Auth::id())->update($data);

        return redirect()->route('profile.edit')->with('success', 'Profile berhasil diubah');
    }

    public function changePassword(Request $request)
    {
        return view('profile.change');
    }

    public function savePassword(Request $request)
    {
        $request->validate([
            'oldpassword' => ['required', new MatchOldPassword],
            'newpassword' => ['required'],
            'confirmpassword' => ['same:newpassword'],
        ]);
   
        User::find(Auth::id())->update(['password'=> Hash::make($request->newpassword)]);
   
        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah');;
    }

}
