<div class="container">
    <h1>Assignments</h1>
    <ul>
        @foreach ($subjects as $subject)
            <li>
                {{ $subject->name }} (Class: {{ $subject->class->name }}, Section: {{ $subject->section->name }})
                <a href="{{ route('assignments.create', $subject) }}">Create Assignment</a>
                @foreach ($subject->assignments as $assignment)
                    <div>
                        {{ $assignment->title }} (Due: {{ $assignment->due_date->format('Y-m-d') }})
                        <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="btn btn-secondary btn-sm">View PDF</a>
                        <a href="{{ route('assignments.submissions', $assignment) }}" class="btn btn-primary btn-sm">View Submissions</a>
                    </div>
                @endforeach
            </li>
        @endforeach
    </ul>
</div>
