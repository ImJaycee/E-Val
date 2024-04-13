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
    <title>Create Account</title>
</head>
<body class="bg-gray-100">
    <img src="{{ asset('storage/images/dlc-logo1.png') }}" alt="logo" class="w-24 mx-auto mt-8">
    <div class="max-w-2xl mx-auto py-10 px-4">
        <form action="{{route('registerStudent')}}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="md:flex md:justify-between">
                <div class="mb-4 md:w-1/2 md:mr-2">
                    <label for="number" class="block text-gray-700 text-sm font-bold mb-2">Student ID</label>
                    <input type="number" id="student_id" name="student_id" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('student_id')}}>
                        @error('student_id')
                           <p class="text-red-500 text-sm text-end p-1">
                               {{$message}}
                           </p>
                       @enderror
                </div>

                <div class="mb-4 md:w-1/2 md:ml-2">
                    <label for="number" class="block text-gray-700 text-sm font-bold mb-2">Contact</label>
                    <input type="number" id="contact" name="contact" required onfocus="clearError()"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('contact')}}>
                    @error('contact')
                        <p class="text-red-500 text-sm text-end p-1">
                            {{$message}}
                        </p>
                    @enderror
                </div>

            </div>
    
            <div class="md:flex md:justify-between">
                <div class="mb-4 md:w-1/3 md:mr-2">
                    <label for="firstname" class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                    <input type="text" id="firstname" name="firstname" required onfocus="clearError()"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('first_name')}}>
                        @error('firstname')
                           <p class="text-red-500 text-sm text-end p-1">
                               {{$message}}
                           </p>
                        @enderror
                </div>
    
                <div class="mb-4 md:w-1/3 md:mx-2">
                    <label for="middlename" class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label>
                    <input type="text" id="middlename" name="middlename" required onfocus="clearError()"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('middle_name')}}>
                        @error('middlename')
                           <p class="text-red-500 text-sm text-end p-1">
                               {{$message}}
                           </p>
                        @enderror
                </div>
    
                <div class="mb-4 md:w-1/3 md:ml-2">
                    <label for="lastname" class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                    <input type="text" id="lastname" name="lastname" required onfocus="clearError()"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('last_name')}}>
                        @error('lastname')
                           <p class="text-red-500 text-sm text-end p-1">
                               {{$message}}
                           </p>
                        @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" required onfocus="clearError()"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('email')}}>
                    @error('email')
                       <p class="text-red-500 text-sm text-end p-1">
                           {{$message}}
                       </p>
                   @enderror
            </div>
            <div class="mb-4">
                <label for="program" class="block text-gray-700 text-sm font-bold mb-2">Program</label>
                <select id="program" name="program" required onfocus="clearError()"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('program')}}>
                    <option value="" disabled selected>Select your program</option>
                    <option value="Bachelor of Science in Civil Engineering">Bachelor of Science in Civil Engineering</option>
                    <option value="Bachelor of Science in Business Administration - Major In Marketing">Bachelor of Science in Business Administration - Major In Marketing</option>
                    <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                    <option value="Bachelor of Elementary Education - Major In General Education">Bachelor of Elementary Education - Major In General Education</option>
                    <option value="Bachelor of Science in Entrepreneurship">Bachelor of Science in Entrepreneurship</option>
                    <option value="Bachelor of Science in Psychology">Bachelor of Science in Psychology</option>
                    <option value="Bachelor of Science in Tourism Management">Bachelor of Science in Tourism Management</option>
                    <!-- Add more options as needed -->

                </select>
                    @error('program')
                        <p class="text-red-500 text-sm text-end p-1">
                            {{$message}}
                        </p>
                    @enderror
            </div>
    
            <div class="md:flex md:justify-between">
                <div class="mb-4 md:w-1/2 md:mr-2">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required onfocus="clearError()"
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
    
                <div class="mb-4 md:w-1/2 md:ml-2">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required onfocus="clearError()"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="togglepassword_confirmation" class="far fa-eye-slash text-gray-500 cursor-pointer"></i>
                        </span>
                        @error('password_confirmation')
                            <p id="password_confirmation_error" class="text-red-500 text-sm text-end p-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
    
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-red-900 hover:bg-red-800 text-white font-bold py-2 px-4 mx-auto rounded focus:outline-none focus:shadow-outline w-full">
                    Create Account
                </button>
            </div>
            <a href="{{route('view.index')}}">
                <div class="text-center mt-3 bg-blue-800 py-1.5 rounded hover:bg-blue-600 text-sm font-bold text-white">Login</div>
            </a>
         </form>
    </div>
    
{{-- script for show password --}}
    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const password_confirmationInput = document.getElementById('password_confirmation');
        const togglepassword_confirmation = document.getElementById('togglepassword_confirmation');
    
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
        togglepassword_confirmation.addEventListener('click', function() {
            if (password_confirmation.type === 'password') {
                password_confirmation.type = 'text';
                togglepassword_confirmation.classList.remove('fa-eye-slash');
                togglepassword_confirmation.classList.add('fa-eye');
            } else {
                password_confirmation.type = 'password';
                togglepassword_confirmation.classList.remove('fa-eye');
                togglepassword_confirmation.classList.add('fa-eye-slash');
            }
        });
    </script>
    {{-- script for show password END --}}
    <script>
        function clearError() {
            document.getElementById('contact').nextElementSibling.innerHTML = '';
            document.getElementById('contact').nextElementSibling.innerHTML = '';
            document.getElementById('first_name').nextElementSibling.innerHTML = '';
            document.getElementById('middle_name').nextElementSibling.innerHTML = '';
            document.getElementById('last_name').nextElementSibling.innerHTML = '';
            document.getElementById('email').nextElementSibling.innerHTML = '';
            document.getElementById('program').nextElementSibling.innerHTML = '';
        }
        document.getElementById('password').addEventListener('focus', function() {
        document.getElementById('password_error').innerHTML = '';
        document.getElementById('password_confirmation_error').innerHTML = '';
    });
    </script>

</body>
</html>