<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceptionistController extends Controller
{
    public function index() {
        return view('receptionist.dashboard');
    }
}
