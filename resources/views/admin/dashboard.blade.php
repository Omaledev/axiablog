<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>admin dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @if (session('success'))
        <div class="flash-message fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @endif
    
    <h1>Welcome, {{ auth()->user()->name }}</h1>

    <div>
        <h2>Register a student</h2>
        {{-- <span><a href="{{ route('create') }}"></a></span> --}}

    </div>

</body>

</html>
