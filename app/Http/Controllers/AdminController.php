<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\FitnessClass;
use Illuminate\Http\Request;
use PDF;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $usersByRole = User::selectRaw('role, COUNT(*) as count')->groupBy('role')->pluck('count', 'role');
        $totalClasses = FitnessClass::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('is_paid', true)->sum('amount_paid');
        $recentBookings = Booking::with('user', 'fitnessClass')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        $users = User::all();

        return view('admin.dashboard', compact(
            'totalUsers',
            'usersByRole',
            'totalClasses',
            'totalBookings',
            'totalRevenue',
            'recentBookings',
            'recentUsers',
            'users'
        ));
    }
    public function showAllUsers()
    {
        $users = User::all(); 
        return view('admin.users', compact('users'));
    }
    public function exportUsersPdf(){
        $users = User::all();
        $pdf = PDF::loadView('admin.exports.users_pdf', compact('users'));
        return $pdf->download('users.pdf');
    }
    public function exportBookingsPdf()
    {
        $bookings = Booking::with('user', 'fitnessClass')->get();

        $pdf = PDF::loadView('admin.exports.bookings_pdf', compact('bookings'));
        return $pdf->download('bookings.pdf');
    }

    public function exportClassesPdf()
    {
        $classes = FitnessClass::all();

        $pdf = PDF::loadView('admin.exports.classes_pdf', compact('classes'));
        return $pdf->download('classes.pdf');
    }
    public function allClasses() {
        $classes = FitnessClass::all();
        return view('admin.classes', compact('classes'));
    }
    
    public function allBookings() {
        $bookings = Booking::with(['user', 'fitnessClass'])->get(); 
        return view('admin.bookings', compact('bookings'));
    }
    
}
