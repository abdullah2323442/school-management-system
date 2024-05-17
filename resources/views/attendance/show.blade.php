<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- resources/views/attendance/show.blade.php -->

    <h1>{{ $subject->name }} Attendance</h1>

    <form method="POST" action="{{ route('attendance.store', $subject->id) }}">
        @csrf

        <div>
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" value="{{ request()->input('date') ?? date('Y-m-d') }}" required>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>
                            <input type="radio" name="attendance[{{ $student->id }}]" value="present" {{ $student->attendances->where('date', request()->input('date'))->where('subject_id', $subject->id)->first()->status ?? 'absent' === 'present' ? 'checked' : '' }}>Present
                            <input type="radio" name="attendance[{{ $student->id }}]" value="absent" {{ $student->attendances->where('date', request()->input('date'))->where('subject_id', $subject->id)->first()->status ?? 'absent' === 'absent' ? 'checked' : '' }}>Absent
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Save Attendance</button>
    </form>


</body>

</html>
