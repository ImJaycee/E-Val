<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
     <link rel="icon" href="storage/image/dlc-logo1.png" type="image/png">
    <title>E-Val</title>
</head>
<body class="bg-gray-100">
    <x-messages/>
    <img src="{{ asset('storage/image/dlc-logo1.png') }}" alt="logo" class="w-24 mx-auto mt-10">
    <div class="max-w-md mx-auto py-10 px-4">
        <h1 class="text-xl text-center font-bold mb-4">Login as Student</h1>
        <form action="{{ route('Student_loginprocess')}}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label for="number" class="block text-gray-700 text-sm font-bold mb-2">Student ID</label>
                <input type="number" id="student_id" name="student_id" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
    
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
    
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-red-900 hover:bg-red-800 text-white font-bold py-2 px-4 mx-auto rounded focus:outline-none focus:shadow-outline w-full">
                    Login
                </button>
            </div>
            <div class="text-center"><a href="{{route('register.student')}}" class="text-sm text-blue-500">Sign Up</a></div>
        <div class="text-center"><a href="#" class="text-sm text-blue-500">Forgot Password?</a></div>
        </form>
        
    </div>
</body>
</html>