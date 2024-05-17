<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- resources/views/attendance/index.blade.php -->
    <h1>Select Subject</h1>

    <ul>
        @foreach ($subjects as $subject)
            <li>
                <a href="{{ route('attendance.show', $subject->id) }}">{{ $subject->name }}</a>
            </li>
        @endforeach
    </ul>


</body>
</html>