<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>student dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
</head>

<body>
    @if (session('success'))
        <div class="flash-message fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    <h1>Welcome, {{ auth()->user()->name }}</h1>

    <div class="m-3">
        <button id="logout"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <a href="{{ route('logout') }}">Logout</a>
        </button>
    </div>

</body>

</html>
