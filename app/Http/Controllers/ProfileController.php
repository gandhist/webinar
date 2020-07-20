<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seminar;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $seminar = Seminar::all();
        return view('profile.edit', ['user' => $request->user()])->with(compact('seminar'));
    }

    public function update(Request $request)
    {
        dd($request);
        $request->user()->update($request->all());

        return redirect()->route('profile.edit');
    }

    public function change(){
        return view('profile.change');
    }
}
