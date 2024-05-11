<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance for {{ $subject->name }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Attendance for {{ $subject->name }}</h1>

        <form method="GET" action="{{ route('attendance.index', $subject->id) }}">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request()->input('date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <form method="POST" action="{{ route('attendance.store', $subject->id) }}">
            @csrf
            <input type="hidden" name="date" value="{{ request()->input('date') }}">
            <table class="table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}]" id="present-{{ $student->id }}" value="present" {{ $student->attendances->where('date', request()->input('date'))->first()->status ?? 'absent' == 'present' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="present-{{ $student->id }}">Present</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}]" id="absent-{{ $student->id }}" value="absent" {{ $student->attendances->where('date', request()->input('date'))->first()->status ?? 'absent' == 'absent' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="absent-{{ $student->id }}">Absent</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Save Attendance</button>
        </form>
    </div>
</body>
</html>
