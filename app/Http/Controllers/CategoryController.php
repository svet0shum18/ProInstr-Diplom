<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function benzo() {
        return view('mobil.benzo');
    }

    public function climat() {
        return view('mobil.climat');
    }

    public function pump() {
        return view('mobil.pumps');
    }

    public function hands() {
        return view('mobil.hands');
    }

    public function welding() {
        return view('mobil.welding');
    }

    public function electro() {
        return view('mobil.electro');
    }
}
