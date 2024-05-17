<div class="container">
    <h1>Submit Assignment</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Assignment Details</h2>
            <p><strong>Title:</strong> {{ $assignment->title }}</p>
            <p><strong>Subject:</strong> {{ $assignment->subject->name }}</p>
            <p><strong>Due Date:</strong> {{ $assignment->due_date->format('Y-m-d') }}</p>
            <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="btn btn-primary">View PDF</a>
        </div>
        <div class="col-md-6">
            <h2>Submit Your Answer</h2>
            <form action="{{ route('submissions.store', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="file">Answer File</label>
                    <input type="file" name="file" id="file" class="form-control-file" required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
