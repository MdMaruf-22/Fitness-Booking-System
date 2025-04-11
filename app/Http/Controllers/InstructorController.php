<?php

namespace App\Http\Controllers;
use App\Models\FitnessClass;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    //
    public function index() {
        $classes = FitnessClass::withCount('bookings')
        ->where('instructor_id', auth()->id())
        ->orderBy('start_time', 'asc')
        ->get();

    return view('instructor.dashboard', compact('classes'));
    }
}
