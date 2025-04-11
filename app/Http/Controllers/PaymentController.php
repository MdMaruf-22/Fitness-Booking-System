<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Notifications\BookingConfirmed;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Models\FitnessClass;

class PaymentController extends Controller
{
    public function showPaymentForm(FitnessClass $class)
    {
        return view('payments.form', compact('class'));
    }

    public function confirmPayment(Request $request, FitnessClass $class)
    {
        if ($class->isFull()) {
            return back()->with('error', 'Class is already full.');
        }

        $exists = Booking::where('user_id', auth()->id())
            ->where('fitness_class_id', $class->id)
            ->where('is_paid', true)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already booked this class.');
        }

        $price = $class->price;

        $request->validate([
            'payment_method' => 'required|in:card,bkash,rocket,nagad',
            'amount_paid' => 'required|numeric|min:' . $price . '|max:' . $price,
        ]);

        if ($request->amount_paid != $price) {
            return redirect()->back()->withErrors(['amount_paid' => 'The amount entered does not match the class price.']);
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'fitness_class_id' => $class->id,
            'is_paid' => true,
        ]);
        $booking->is_paid = true;
        $booking->payment_method = $request->payment_method;
        $booking->amount_paid = $request->amount_paid;
        $booking->save();
        $user = $booking->user;

        $pdf = Pdf::loadView('payments.invoice', [
            'user' => $user,
            'class' => $class,
            'booking' => $booking
        ]);

        Mail::send('emails.payment-confirmation', compact('user', 'class'), function ($message) use ($user, $pdf) {
            $message->to($user->email)
                ->subject('Your Booking Invoice')
                ->attachData($pdf->output(), 'invoice.pdf');
        });

        $user->notify(new BookingConfirmed($class));

        return redirect('/my-bookings')->with('success', 'Payment confirmed and invoice sent to your email!');
    }
}
