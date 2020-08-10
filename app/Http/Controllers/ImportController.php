<?php

namespace App\Http\Controllers;
use App\Seminar;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    //
    public function index() {
        $seminar = Seminar::where('is_actived','1')->get();
        return view('import.index')->with(compact('seminar'));
    }

    public function import(Request $request) {
        $request->validate([
            'seminar' => 'required',
            'file' => 'required|mimes:xlsx|max:2048'
        ]);
    }
}
