@auth('students')

@php
    $title = 'E-Val-Update-Info';
    $array = ['title' => $title];
    $student_id = session('student_id');
    $pfp = session('pfp');
@endphp

@include('partials.header-student')


<body class="bg-gray-100">
    <img src="{{ asset('storage/images/dlc-logo1.png') }}" alt="logo" class="w-24 mx-auto mt-8">
    <div class="max-w-2xl mx-auto py-10 px-4">
        <form action="{{ route('student-side.update-profile-process', ['student_id' => $student_id]) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            <div class="flex justify-center">
                <div class="mb-4 flex justify-center items-center">
                    <label for="pfp" class="block text-gray-700 text-sm font-bold mb-2">Profile Picture</label>
                    <div class="relative">
                        <input type="file" id="pfp" name="pfp" accept="image/*" onchange="previewImage(event)" class="hidden">
                        <label for="pfp" class="cursor-pointer">
                            <img id="preview" class="ml-2 h-16 w-16 rounded-full object-cover" src="{{ asset('storage/images/pfp/'.$student->pfp) }}" alt="Preview">
                            <span class="absolute inset-x-0 bottom-0 px-3 py-2 text-white flex justify-center items-center">
                                <i class="far fa-image text-gray-500 cursor-pointer"></i>
                            </span>
                        </label>
                    </div>
                    @error('pfp')
                        <p id="pfp_error" class="text-red-500 text-sm text-end p-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:justify-between">
                <div class="mb-4 md:w-1/2 md:mr-2">
                    <label for="year" class="block text-gray-700 text-sm font-bold mb-2">Year</label>
                    <select id="year" name="year" required onfocus="clearError()"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('program')}}>
                        <option value="" disabled selected>Select year</option>
                        <option value="1" {{ $student->year == '1' ? 'selected' : '' }}>1st</option>
                        <option value="2" {{ $student->year == '2' ? 'selected' : '' }}>2nd</option>
                        <option value="3" {{ $student->year == '3' ? 'selected' : '' }}>3rd</option>
                        <option value="4" {{ $student->year == '4' ? 'selected' : '' }}>4th</option>
                        <!-- Add more options as needed -->
    
                    </select>
                        @error('year')
                            <p class="text-red-500 text-sm text-end p-1">
                                {{$message}}
                            </p>
                        @enderror
                </div>

                <div class="mb-4 md:w-1/2 md:mr-2">
                    <label for="section" class="block text-gray-700 text-sm font-bold mb-2">Section</label>
                    <select id="section" name="section" required onfocus="clearError()"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('program')}}>
                        <option value="" disabled selected>Select section</option>
                        <option value="A"{{ $student->section == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B"{{ $student->section == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C"{{ $student->section == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D"{{ $student->section == 'D' ? 'selected' : '' }}>D</option>
                        <!-- Add more options as needed -->
    
                    </select>
                        @error('section')
                            <p class="text-red-500 text-sm text-end p-1">
                                {{$message}}
                            </p>
                        @enderror
                </div>

                <div class="mb-4 md:w-1/2 md:ml-2">
                    <label for="number" class="block text-gray-700 text-sm font-bold mb-2">Contact</label>
                    <input type="number" id="contact" name="contact" required onfocus="clearError()"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{$student->contact}}>
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
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $student->firstname }}">
                        @error('firstname')
                           <p class="text-red-500 text-sm text-end p-1">
                               {{$message}}
                           </p>
                        @enderror
                </div>
    
                <div class="mb-4 md:w-1/3 md:mx-2">
                    <label for="middlename" class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label>
                    <input type="text" id="middlename" name="middlename" required onfocus="clearError()"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$student->middlename}}">
                        @error('middlename')
                           <p class="text-red-500 text-sm text-end p-1">
                               {{$message}}
                           </p>
                        @enderror
                </div>
    
                <div class="mb-4 md:w-1/3 md:ml-2">
                    <label for="lastname" class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                    <input type="text" id="lastname" name="lastname" required onfocus="clearError()"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$student->lastname}}">
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
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{$student->email}}>
                    @error('email')
                       <p class="text-red-500 text-sm text-end p-1">
                           {{$message}}
                       </p>
                   @enderror
            </div>
            <div class="mb-4">
                <label for="program" class="block text-gray-700 text-sm font-bold mb-2">Program</label>
                <select id="program" name="program" required onfocus="clearError()"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="" disabled>Select your program</option>
                    <option value="BSCE" {{ $student->program == 'BSCE' ? 'selected' : '' }}>Bachelor of Science in Civil Engineering</option>
                    <option value="BSBA" {{ $student->program == 'BSBA' ? 'selected' : '' }}>Bachelor of Science in Business Administration - Major In Marketing</option>
                    <option value="BSIT" {{ $student->program == 'BSIT' ? 'selected' : '' }}>Bachelor of Science in Information Technology</option>
                    <option value="BEED" {{ $student->program == 'BEED' ? 'selected' : '' }}>Bachelor of Elementary Education - Major In General Education</option>
                    <option value="BSE" {{ $student->program == 'BSE' ? 'selected' : '' }}>Bachelor of Science in Entrepreneurship</option>
                    <option value="BScPsych" {{ $student->program == 'BScPsych' ? 'selected' : '' }}>Bachelor of Science in Psychology</option>
                    <option value="BSTM" {{ $student->program == 'BSTM' ? 'selected' : '' }}>Bachelor of Science in Tourism Management</option>
                    <!-- Add more options as needed -->
                </select>
        
                    @error('program')
                        <p class="text-red-500 text-sm text-end p-1">
                            {{$message}}
                        </p>
                    @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-red-900 hover:bg-red-800 text-white font-bold py-2 px-4 mx-auto rounded focus:outline-none focus:shadow-outline w-full">
                    Update
                </button>
            </div>
            <a href="{{route('student.profile', ['student_id' => $student_id])}}">
                <div class="text-center mt-3 bg-blue-800 py-1.5 rounded hover:bg-blue-600 text-sm font-bold text-white">Cancel</div>
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

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = () => {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "storage/image/test-profile.png";
            }
        }
    </script>

</body>
@include('partials.footer')
@endauth
