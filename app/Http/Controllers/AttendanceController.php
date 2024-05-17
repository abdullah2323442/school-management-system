<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isTeacher()) {
            $subjects = $user->subjects;
            return view('attendance.index', compact('subjects'));
        }

        return redirect()->back()->with('error', 'You are not authorized to access this page.');
    }

    public function show(Request $request, $subjectId)
    {
        $user = Auth::user();
        $subject = Subject::findOrFail($subjectId);

        if ($subject->teacher_id !== $user->id) {
            return redirect()->back()->with('error', 'You are not authorized to access this subject.');
        }

        $students = $subject->class->students()->with('attendances', function ($query) use ($subjectId, $request) {
            $query->where('subject_id', $subjectId);
            if ($request->has('date')) {
                $query->where('date', $request->input('date'));
            }
        })->get();

        return view('attendance.show', compact('students', 'subject'));
    }

    public function store(Request $request, $subjectId)
    {
        $user = Auth::user();
        $subject = Subject::findOrFail($subjectId);

        if ($subject->teacher_id !== $user->id) {
            return redirect()->back()->with('error', 'You are not authorized to access this subject.');
        }

        $students = $subject->class->students;

        foreach ($students as $student) {
            $attendance = Attendance::firstOrNew([
                'user_id' => $student->id,
                'subject_id' => $subjectId,
                'class_id' => $subject->class_id,
                'section_id' => $subject->section_id,
                'date' => $request->input('date'),
            ]);

            $attendance->status = $request->input('attendance.' . $student->id, 'absent');
            $attendance->save();
        }

        return redirect()->back()->with('success', 'Attendance recorded successfully.');
    }
}
