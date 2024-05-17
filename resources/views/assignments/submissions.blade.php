<div class="container">
        <h1>{{ $assignment->title }} Submissions</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Submission</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submissions as $submission)
                    <tr>
                        <td>{{ $submission->user->name }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank">View Submission</a>
                        </td>
                        <td>
                            <form action="{{ route('submissions.grade', $submission->id) }}" method="POST">
                                @csrf
                                <input type="number" name="score" value="{{ $submission->score ?? '' }}" step="0.01" min="0" max="100" class="form-control" style="width: 100px; display: inline-block;">
                                <button type="submit" class="btn btn-primary btn-sm">Grade</button>
                            </form>
                        </td>
                        <td>
                            <!-- Add any additional actions here -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>