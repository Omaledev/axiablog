<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>register students</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="flex w-full h-screen items-center bg-no-repeat bg-cover bg-center"
        style="background-image:url('{{ url('storage/images/axia1.jpg') }}');">
        <div class="mx-auto bg-white w-1/3 rounded-lg shadow-md">
            <form method="post" action="">
                @csrf
                <div>
                    <img src="{{ url('storage/images/axialogo.jpg') }}" alt="" class="max-w-48 mx-auto">
                </div>
                <div class="flex items-center justify-center m-4">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-3 text-gray-600 font-medium">Register a student</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>
                <div class="m-4">
                    <div class="mb-5">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name of Student</label>
                        <input type="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="company position" required />
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Address</label>
                        <input type="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="email address" required />
                    </div>
                    <div class="mb-4">
                        <label for="course"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course</label>
                        <input type="course" id="course"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="course" required />
                    </div>
                    <div class="mb-4">
                        <label for="duration"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course Duration</label>
                        <input type="duration" id="duration"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="duration" required />
                    </div>
                    <div class="mb-4">
                        <label for="amount"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount paid</label>
                        <input type="amount" id="amount"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="&#8358" required />
                    </div>
                    <div>
                        <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
