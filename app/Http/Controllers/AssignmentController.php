<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Subject;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::whereHas('teacher', function ($query) {
            $query->where('id', auth()->user()->id)
                ->where('role', 'TEACHER');
        })->get();


        return response()->view('assignments.index', compact('subjects'));
    }

    // app/Http/Controllers/AssignmentController.php

    public function downloadPdf(Assignment $assignment)
    {
        $this->authorize('view', $assignment);

        $filePath = storage_path('app/public/' . $assignment->file_path);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $assignment->title . '.pdf"',
        ]);
    }

    public function viewSubmissions(Assignment $assignment)
    {
        $submissions = Submission::where('assignment_id', $assignment->id)->with('user')->get();
        return view('assignments.submissions', compact('assignment', 'submissions'));
    }

    public function gradeSubmission(Request $request, Submission $submission)
    {
        $submission->score = $request->input('score');
        $submission->save();

        return redirect()->back()->with('success', 'Submission graded successfully.');
    }


    /**
     * Show the form for creating a new assignment.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function create(Subject $subject)
    {
        return response()->view('assignments.create', compact('subject'));
    }

    /**
     * Store a newly created assignment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'subject_id' => 'required|exists:subjects,id',
            'file_path' => 'required|file',
            'due_date' => 'required|date',
        ]);

        $subject = Subject::findOrFail($validatedData['subject_id']);

        $filePath = $request->file('file_path')->store('assignments', 'public');

        $assignment = Assignment::create([
            'title' => $validatedData['title'],
            'subject_id' => $subject->id,
            'class_id' => $subject->class_id,
            'section_id' => $subject->section_id,
            'teacher_id' => auth()->user()->id,
            'file_path' => $filePath,
            'due_date' => $validatedData['due_date'],
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
    }

    /**
     * Display the specified assignment.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function show(Assignment $assignment)
    {
        return Storage::disk('public')->download($assignment->file_path);
    }
}
