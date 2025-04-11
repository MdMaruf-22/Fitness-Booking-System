<?php

namespace App\Http\Controllers;

use App\Models\FitnessClass;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Notifications\ClassUpdated;
use Illuminate\Support\Facades\Auth;

class FitnessClassController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'instructor') {
            $classes = FitnessClass::where('instructor_id', $user->id)->latest()->get();
        } else {
            $classes = FitnessClass::with('instructor')->latest()->get();
        }
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        if (auth()->user()->role === 'instructor') {
            $instructors = collect([auth()->user()]);
        } else {
            $instructors = User::where('role', 'instructor')->get();
        }

        return view('classes.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'instructor_id' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:15',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);
        $start = Carbon::parse($validated['start_time']);
        $end = $start->copy()->addMinutes($validated['duration']);
        $class = FitnessClass::create($validated);
        try {
            $googleEvent = Event::create([
                'name' => $class->title,
                'startDateTime' => $start,
                'endDateTime' => $end,
                'description' => $class->description,
            ]);

            $class->google_event_id = $googleEvent->id;
            $class->save();
        } catch (\Exception $e) {
            Log::error('Google Calendar Error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['google_calendar' => 'Google Calendar error: ' . $e->getMessage()]);
        }
        if (auth()->user()->role === 'instructor' && auth()->id() != $validated['instructor_id']) {
            return redirect()->back()->withErrors(['instructor_id' => 'Instructors can only assign classes to themselves.']);
        }
        return redirect()->route('dashboard')->with('success', 'Class created & added to Google Calendar.');
    }

    public function edit($id)
    {
        $class = FitnessClass::findOrFail($id);
        if (auth()->user()->role === 'instructor') {
            $instructors = collect([auth()->user()]);
        } else {
            $instructors = User::where('role', 'instructor')->get();
        }
        return view('classes.edit', compact('class', 'instructors'));
    }

    public function update(Request $request, FitnessClass $fitnessClass)
    {
        $validated = $request->validate([
            'title' => 'required',
            'instructor_id' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:15',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $start = Carbon::parse($validated['start_time']);
        $end = $start->copy()->addMinutes($validated['duration']);

        $fitnessClass->update($validated);

        try {
            if ($fitnessClass->google_event_id) {
                $event = Event::find($fitnessClass->google_event_id);
                $event->name = $validated['title'];
                $event->startDateTime = $start;
                $event->endDateTime = $end;
                $event->description = $validated['description'] ?? '';
                $event->save();
            }
        } catch (\Exception $e) {
            Log::error('Google Calendar Update Error: ' . $e->getMessage());
        }
        foreach ($fitnessClass->bookings as $booking) {
            $booking->user->notify(new ClassUpdated($fitnessClass));
        }
        if (auth()->user()->role === 'instructor' && auth()->id() != $validated['instructor_id']) {
            return redirect()->back()->withErrors(['instructor_id' => 'Instructors can only assign classes to themselves.']);
        }
        return redirect()->route('dashboard')->with('success', 'Class updated successfully.');
    }



    public function destroy(FitnessClass $fitnessClass)
    {
        try {
            if ($fitnessClass->google_event_id) {
                $event = Event::find($fitnessClass->google_event_id);
                if ($event) {
                    $event->delete();
                }
            }
        } catch (\Exception $e) {
            Log::error('Google Calendar Deletion Error: ' . $e->getMessage());
        }

        $fitnessClass->delete();

        return redirect()->route('dashboard')->with('success', 'Class deleted successfully.');
    }
}
