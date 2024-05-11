<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // app/Http/Controllers/AttendanceController.php

    public function index(Request $request, $subjectId)
    {
        $subject = Subject::findOrFail($subjectId);
        $students = $subject->class->students()->with('attendances', function ($query) use ($subjectId, $request) {
            $query->where('subject_id', $subjectId);
            if ($request->has('date')) {
                $query->where('date', $request->input('date'));
            }
        })->get();

        return view('attendance.index', compact('students', 'subject'));
    }


    public function store(Request $request, $subjectId)
    {
        $subject = Subject::findOrFail($subjectId);
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
