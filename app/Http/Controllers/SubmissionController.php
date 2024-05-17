<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index()
    {       
        $user = Auth::user();
        $submissions = Submission::where('user_id', $user->id)->with('assignment')->get();
        $dueAssignments = Assignment::whereHas('class', function ($query) use ($user) {
            $query->whereHas('students', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        })->whereHas('section', function ($query) use ($user) {
            $query->whereHas('students', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        })->whereHas('subject', function ($query) use ($user) {
            $query->whereHas('class', function ($query) use ($user) {
                $query->whereHas('students', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                });
            });
        })->get();

        return view('submissions.index', compact('submissions', 'dueAssignments'));
    }

    public function submit($assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        return view('submissions.submit', compact('assignment'));
    }

    public function store(Request $request, $assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        $file = $request->file('file');
        $filePath = $file->store('submissions', 'public');

        $submission = new Submission([
            'assignment_id' => $assignment->id,
            'user_id' => Auth::id(),
            'file_path' => $filePath,
            'subject_id' => $assignment->subject_id,
            'section_id' => $assignment->section_id,
            'class_id' => $assignment->class_id,
        ]);
        $submission->save();

        return redirect()->route('submissions.index')->with('success', 'Submission uploaded successfully.');
    }

    public function destroy($submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        
        // Delete the file from storage
        Storage::disk('public')->delete($submission->file_path);

        $submission->delete();

        return redirect()->route('submissions.index')->with('success', 'Submission deleted successfully.');
    }
}
