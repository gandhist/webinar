<?php

namespace App\Http\Controllers;
use App\Seminar;
use App\Imports\ImportPeserta;
use Illuminate\Http\Request;
use Excel;

class ImportController extends Controller
{
    //
    public function index() {
        $seminar = Seminar::where('is_actived','1')->orderBy('tgl_awal', 'DESC')->get();
        return view('import.index')->with(compact('seminar'));
    }

    public function import(Request $request) {
        $request->validate([
            'seminar' => 'required',
            'file' => 'required|mimes:xlsx|max:2048'
        ]);
        if ($files = $request->file('file')) {
            Excel::import(new ImportPeserta($request->seminar), $files);
        }

        // try {

        // }
        // catch(\Throwable $e) {
        //     return redirect('/import')
        // ->with('pesan', 'Mohon gunakan file template import yang disediakan');
        // }

        return redirect('/pesertas')
        ->with('pesan', 'Import peserta berhasil');
    }
}
