<div class="container">
        <h1>Create Assignment</h1>
        <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div>
                <label for="file_path">File:</label>
                <input type="file" name="file_path" id="file_path" required>
            </div>
            <div>
                <label for="due_date">Due Date:</label>
                <input type="date" name="due_date" id="due_date" required>
            </div>
            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
            <button type="submit">Create Assignment</button>
        </form>
    </div>
