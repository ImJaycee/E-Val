<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="storage/images/dlc-logo1.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite('resources/css/app.css')
     <link rel="icon" href="storage/image/dlc-logo1.png" type="image/png">
    <title>E-Val</title>
</head>

<body class="bg-gray-100">
    <x-messages/>
    <img src="{{ asset('storage/images/dlc-logo1.png') }}" alt="logo" class="w-24 mx-auto mt-10">
    <div class="max-w-md mx-auto py-10 px-4">
        <h1 class="text-xl text-center font-bold mb-4">Reset Password</h1>
        <form action="{{ route('instructor.resetPassword') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label for="instructor_id" class="block text-gray-700 text-sm font-bold mb-2">Instructor ID</label>
                <input type="number" id="instructor_id" name="instructor_id" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="password_reset_token" class="block text-gray-700 text-sm font-bold mb-2">Enter Reset Token</label>
                <input type="text" id="password_reset_token" name="password_reset_token" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('password_reset_token')
                       <p id="password_reset_token_error" class="text-red-500 text-sm text-end p-1">
                           {{ $message }}
                       </p>
                   @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i id="togglePassword" class="far fa-eye-slash text-gray-500 cursor-pointer"></i>
                    </span>
                    @error('password')
                        <p id="password_error" class="text-red-500 text-sm text-end p-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-red-900 hover:bg-red-800 text-white font-bold py-2 px-4 mx-auto rounded focus:outline-none focus:shadow-outline w-full">
                    Reset Password
                </button>
            </div>
            <div class="text-center"><a href="{{ route('view.index') }}" class="text-sm text-blue-500">Return</a></div>
        </form>
        
        
    </div>

{{-- script for show password --}}
<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.classList.remove('fa-eye-slash');
            togglePassword.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            togglePassword.classList.remove('fa-eye');
            togglePassword.classList.add('fa-eye-slash');
        }
    });
    
</script>


</body>
</html>