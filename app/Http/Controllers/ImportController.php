<?php

namespace App\Http\Controllers;
use App\Seminar;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    //
    public function index() {
        $seminar = Seminar::all();
        dd($seminar);
    }

    public function import(Request $request) {

    }
}
