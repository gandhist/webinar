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
        $seminar = Seminar::where('is_actived','1')->get();
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

        return redirect('/pesertas')
        ->with('pesan', 'Import peserta berhasil diubah');
    }
}
