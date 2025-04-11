<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\FitnessClass;
use App\Notifications\BookingConfirmed;
use App\Notifications\BookingCancelled;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->join('fitness_classes', 'bookings.fitness_class_id', '=', 'fitness_classes.id')
            ->with('fitnessClass')
            ->orderBy('fitness_classes.start_time', 'asc')
            ->select('bookings.*')
            ->get();

        return view('bookings.index', compact('bookings'));
    }



    public function store(Request $request, $classId)
    {
        $class = FitnessClass::withCount('bookings')->findOrFail($classId);

        if ($class->isFull()) {
            return back()->with('error', 'Class is already full.');
        }

        $exists = Booking::where('user_id', auth()->id())
            ->where('fitness_class_id', $classId)
            ->where('is_paid', true)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already booked this class.');
        }

        return redirect()->route('payment.form', $classId);
    }


    public function destroy($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $class = $booking->fitnessClass;
        $booking->delete();
        auth()->user()->notify(new BookingCancelled($class));
        return back()->with('success', 'Booking canceled.');
    }

    public function classBookings($classId)
    {
        $class = FitnessClass::with('bookings.user')->findOrFail($classId);
        if (auth()->id() !== $class->instructor_id) {
            abort(403, 'Unauthorized access to this class.');
        }
        return view('instructor.class-bookings', compact('class'));
    }

    public function markAttended($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->fitnessClass->instructor_id) {
            abort(403, 'Unauthorized action.');
        }
        $booking->attended = true;
        $booking->save();

        return back()->with('success', 'Marked as attended.');
    }

    public function allBookings()
    {
        $bookings = Booking::with(['user', 'fitnessClass'])->latest()->get();
        return view('receptionist.all-bookings', compact('bookings'));
    }
    public function showPaymentForm($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('payments.form', compact('booking'));
    }
}
