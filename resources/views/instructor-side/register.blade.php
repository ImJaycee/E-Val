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
<style>
    body {
       position: relative; /* Required for the ::before pseudo-element */
       overflow-x: hidden; /* Prevents horizontal scrollbars */
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
       background-color: rgba(255, 255, 255, 0.7); /* Adjust the opacity by changing the last parameter */
    }
</style>

<body>
    <div class="max-w-2xl mx-auto my-auto py-10 px-4">
        <img src="{{ asset('storage/images/dlc-logo1.png') }}" alt="logo" class="w-24 mx-auto mb-2 rounded-full">
        <form action="{{route('registerInstructor')}}" method="POST" class="shadow-md rounded px-8 pt-6 pb-8 mb-4 bg-white">
            @csrf
            <div class="space-y-4">
                <!-- Instructor ID -->
                <div class="flex flex-col">
                    <label for="instructor_id" class="block text-gray-700 text-sm font-bold mb-2">Instructor ID</label>
                    <input type="number" id="instructor_id" name="instructor_id" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('instructor_id') }}">
                    @error('instructor_id')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Contact -->
                <div class="flex flex-col">
                    <label for="contact" class="block text-gray-700 text-sm font-bold mb-2">Contact</label>
                    <input type="number" id="contact" name="contact" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('contact') }}">
                    @error('contact')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Names -->
                <div class="md:flex md:space-x-4">
                    <div class="flex-1">
                        <label for="firstname" class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                        <input type="text" id="firstname" name="firstname" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('firstname') }}">
                        @error('firstname')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex-1">
                        <label for="middlename" class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label>
                        <input type="text" id="middlename" name="middlename" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('middlename') }}">
                        @error('middlename')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex-1">
                        <label for="lastname" class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                        <input type="text" id="lastname" name="lastname" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('lastname') }}">
                        @error('lastname')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="flex flex-col">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Sex -->
                <div class="flex flex-col">
                    <label for="sex" class="block text-gray-700 text-sm font-bold mb-2">Sex</label>
                    <select id="sex" name="sex" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" disabled selected>Select Gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                    @error('sex')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Department -->
                <div class="flex flex-col">
                    <label for="department" class="block text-gray-700 text-sm font-bold mb-2">Department</label>
                    <select id="department" name="department" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" disabled selected>Select your Department</option>
                        <option value="College of Engineering and Architecture">College of Engineering and Architecture</option>
                        <option value="College of Business Administration">College of Business Administration</option>
                        <option value="College of Computing Studies">College of Computing Studies</option>
                        <option value="College of Education">College of Education</option>
                        <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                        <option value="College of Hospitality and Tourism Management">College of Hospitality and Tourism Management</option>
                        <!-- Add more options as needed -->
                    </select>
                    @error('department')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="md:flex md:space-x-4">
                    <div class="flex-1 relative">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center mt-6">
                            <i id="togglePassword" class="far fa-eye-slash text-gray-500 cursor-pointer"></i>
                        </span>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex-1 relative">
                        <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center mt-6">
                            <i id="togglepassword_confirmation" class="far fa-eye-slash text-gray-500 cursor-pointer"></i>
                        </span>
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Submit and Cancel -->
                <div class="flex flex-col md:flex-row md:space-x-4">
                    <button type="submit" class="bg-red-900 hover:bg-red-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full md:w-auto">
                        Create Account
                    </button>
                    <a href="{{route('view.index')}}" class="bg-gray-500 hover:bg-gray-400 text-white font-bold py-2 px-4 rounded w-full md:w-auto text-center mt-2 md:mt-0 block">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
    
{{-- script for show password --}}
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    document.getElementById('togglepassword_confirmation').addEventListener('click', function() {
        const passwordInput = document.getElementById('password_confirmation');
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
    {{-- script for show password END --}}
    <script>
        function clearError() {
            document.getElementById('instructor_id').nextElementSibling.innerHTML = '';
            document.getElementById('contact').nextElementSibling.innerHTML = '';
            document.getElementById('first_name').nextElementSibling.innerHTML = '';
            document.getElementById('middle_name').nextElementSibling.innerHTML = '';
            document.getElementById('last_name').nextElementSibling.innerHTML = '';
            document.getElementById('email').nextElementSibling.innerHTML = '';
            document.getElementById('department').nextElementSibling.innerHTML = '';
        }
        document.getElementById('password').addEventListener('focus', function() {
        document.getElementById('password_error').innerHTML = '';
        document.getElementById('password_confirmation_error').innerHTML = '';
    });
    </script>

</body>
</html>