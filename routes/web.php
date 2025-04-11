<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FitnessClassController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user();

    return redirect()->to(match ($user->role) {
        'admin' => '/admin/dashboard',
        'receptionist' => '/reception/dashboard',
        'instructor' => '/instructor/dashboard',
        'member' => '/member/dashboard',
        default => '/',
    });
})->name('dashboard');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'showAllUsers'])->name('admin.users');
    // Show all classes
Route::get('/admin/classes', [AdminController::class, 'allClasses'])->name('admin.classes');

// Show all bookings
Route::get('/admin/bookings', [AdminController::class, 'allBookings'])->name('admin.bookings');

    Route::get('/admin/export/users-pdf', [AdminController::class, 'exportUsersPdf'])->name('admin.export.users_pdf');
    Route::get('/admin/export/bookings-pdf', [AdminController::class, 'exportBookingsPdf'])->name('admin.export.bookings_pdf');
    Route::get('/admin/export/classes-pdf', [AdminController::class, 'exportClassesPdf'])->name('admin.export.classes_pdf');
});

Route::middleware(['auth', 'role:receptionist'])->group(function () {
    Route::get('/reception/dashboard', [ReceptionistController::class, 'index']);
    Route::get('/all-bookings', [BookingController::class, 'allBookings'])->name('receptionist.bookings');
});

Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'index']);
    Route::get('/class/{id}/attendance', [BookingController::class, 'classBookings'])->name('class.bookings');
    Route::post('/booking/{id}/attend', [BookingController::class, 'markAttended'])->name('booking.attend');
});

Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', [MemberController::class, 'index']);
});
Route::middleware(['auth', 'role:receptionist,instructor'])->group(function () {
    Route::get('/classes', [FitnessClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/create', [FitnessClassController::class, 'create'])->name('classes.create');
    Route::post('/classes', [FitnessClassController::class, 'store'])->name('classes.store');
    Route::get('/classes/{id}/edit', [FitnessClassController::class, 'edit'])->name('classes.edit');
    Route::put('/classes/{fitnessClass}', [FitnessClassController::class, 'update'])->name('classes.update');
    Route::delete('/classes/{fitnessClass}', [FitnessClassController::class, 'destroy'])->name('classes.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/available-classes', function () {
        $classes = App\Models\FitnessClass::with(['instructor', 'bookings'])->orderBy('start_time')->get();
        return view('bookings.available', compact('classes'));
    })->name('bookings.available');

    Route::post('/bookings/{classId}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/payment/{class}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payments/{class}/confirm', [PaymentController::class, 'confirmPayment'])->name('payments.confirm');
});
require __DIR__ . '/auth.php';
