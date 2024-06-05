<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="storage/images/dlc-logo1.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
     <link rel="icon" href="storage/image/dlc-logo1.png" type="image/png">
    <title>E-Val</title>
</head>
<style>
    body {
        position: relative; /* Required for the ::before pseudo-element */
        overflow: hidden; /* Prevents scrollbars when the blur is applied */
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-image: url('storage/images/index-bg.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        filter: blur(8px); /* Adjust the blur amount as needed */
        z-index: -1; /* Ensures the pseudo-element is behind all other content */
        opacity: 0.5; /* Adjust the background image opacity as needed */
    }
    form {
    background-color: rgba(255, 255, 255, 0.5); /* Adjust the opacity by changing the last parameter */
}

</style>
<body class="">
    <x-messages/>
    <img src="{{ asset('storage/images/dlc-logo1.png') }}" alt="logo" class="w-24 mx-auto mt-10">
    <div class="max-w-md mx-auto py-10 px-4">
        <h1 class="text-xl text-center font-bold mb-4">Send Reset Token</h1>
        <form action="{{ route('instructor.sendResetLink') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label for="instructor_id" class="block text-gray-700 text-sm font-bold mb-2">Enter Instructor ID</label>
                <input type="number" id="instructor_id" name="instructor_id" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-red-900 hover:bg-red-800 text-white font-bold py-2 px-4 mx-auto rounded focus:outline-none focus:shadow-outline w-full">
                    Send Reset Link
                </button>
            </div>
            <div class="text-center"><a href="{{ route('view.index') }}" class="text-sm text-blue-500">Return</a></div>
        </form>
        
        
    </div>
</body>
</html>