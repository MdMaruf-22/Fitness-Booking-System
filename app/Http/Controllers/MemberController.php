<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    //
    public function index()
{
    $user = Auth::user();
    $bookings = $user->bookings; 

    return view('member.dashboard', compact('bookings'));
}

}
