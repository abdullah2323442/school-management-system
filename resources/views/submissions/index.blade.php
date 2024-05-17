<div class="container">
    <h1>Submissions</h1>

    @if ($dueAssignments->count() > 0)
        <div class="alert alert-warning">
            <h2>Due Assignments</h2>
            <ul>
                @foreach ($dueAssignments as $assignment)
                    <li>
                        {{ $assignment->title }} (Due: {{ $assignment->due_date->format('Y-m-d') }})
                        <a href="{{ route('submissions.submit', $assignment->id) }}" class="btn btn-primary">Submit</a>
                        <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="btn btn-secondary">View PDF</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>My Submissions</h2>
    <ul>
        @foreach ($submissions as $submission)
            <li>
                <h3>{{ $submission->assignment->title }}</h3>
                <p>Subject: {{ $submission->assignment->subject->name }}</p>
                <p>Submitted: {{ $submission->created_at->format('Y-m-d') }}</p>
                <p>Score: {{ $submission->score ?? 'Not graded yet' }}</p>
                <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank">View Submission</a>
                <form action="{{ route('submissions.destroy', $submission->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this submission?')">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
