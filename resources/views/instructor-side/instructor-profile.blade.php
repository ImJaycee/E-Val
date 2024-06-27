@auth('instructors')

@php
    $title = 'E-Val-Profile';
    $array = ['title' => $title];
    $instructor_id = session('instructor_id');
    $pfp = session('pfp');
@endphp

@if(session('reload'))
    <script>
        location.reload();
    </script>
@endif

{{-- @dd($student); --}}

@include('partials.header-instructor')


<body class="bg-gray-200">

<x-nav-instructor/> <!--Include nav and sidebar-->

<x-messages/>

<div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">


    <!-- Main Container -->
    <div class="lg:flex gap-4 items-stretch">
        
        <div class="bg-white md:p-2 p-6 rounded-lg border border-gray-200 mb-4 lg:mb-0 shadow-md lg:w-[35%]">
          
            <div class="block justify-center h-full">
                <div class="max-w-md bg-white shadow-md rounded-lg overflow-hidden mx-auto">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-center">
                          
                            @if ($instructor->pfp)
                                <img src="{{ asset('storage/images/pfp/'.$instructor->pfp) }}" alt="{{ $instructor->pfp }}" class="h-16 w-16 rounded-full object-cover" >
                            @else
                                <img class="h-16 w-16 rounded-full object-cover" src="{{ asset('storage/images/test-profile.png') }}" alt="">
                            @endif
                        </div>
                        <div class="text-center mt-2">
                            <p class="text-lg text-gray-800 font-medium">{{ $instructor->firstname}} {{ $instructor->middlename}} {{ $instructor->lastname}}</p>
                            <p class="text-sm font-semibold text-gray-700">{{$instructor_id}}</p>
                            <p class="text-sm font-normal text-gray-700">{{$instructor->department}}</p>
                            <p class="text-sm font-normal text-gray-700">{{$instructor->email}}</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 flex justify-center">
                        <a href="{{ route('instructor-side.update-profile-form', ['instructor_id' => $instructor_id]) }}" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded mr-2">Update Profile</a>
                        <button class="bg-red-700 hover:bg-red-800 text-white font-bold py-2 px-4 rounded" id="changePasswordButton">Change Password</button>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="bg-white p-4 rounded-lg xs:mb-4 max-w-full max-h-80 shadow-md lg:w-[75%]">
            <h3 class="text-xl font-bold text-gray-700">
                Assigned Instructors<i> A.Y. 2023-2024</i>
            </h3>
            @if (!empty($AllPeers)) 
                <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 lg:grid-cols-5 gap-3 mt-4 max-h-64 overflow-y-auto">
                    @foreach ($AllPeers as $peer)
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                            @if ($peer['pfp'] == null)
                                <img src="{{ asset('storage/images/test-profile.png') }}" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                            @else
                                <img src="{{ asset('storage/images/pfp/'.$peer['pfp']) }}" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                            @endif
                            <p class="text-xs text-center text-gray-600">{{$peer['peerName']}}</p>
                        </div>
                    @endforeach
                </div>
             @else
                <p class="text-md font-bold text-red-800">
                    No instructors have been evaluated yet.
                </p>
            @endif
        </div>
        

    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg p-4 shadow-md my-3 lg:h-full">
        <h3 class="text-xl font-bold text-gray-700 mb-2">
            Evaluation History
        </h3>
        <div class="overflow-x-auto mt-1 max-h-80 lg:max-h-56 overflow-y-auto">
            <form action="{{ route('instructor.profile', ['instructor_id' => $instructor->instructor_id]) }}" method="GET" class="flex flex-col lg:flex-row justify-end mb-2">
                <label for="academic_year" class="mr-2">A.Y.</label>
                <select name="academic_year" id="academic_year" required class="border border-gray-300 rounded-md p-1 mb-2 lg:mb-0 lg:mr-1 text-sm">
                    <option value="" disabled selected class="text-sm">Select academic year</option>
                    <option value="2023-2024" {{ $selectedAcademicYear == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                    <option value="2024-2025" {{ $selectedAcademicYear == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                    <option value="2025-2026" {{ $selectedAcademicYear == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                    <!-- Add more options as needed -->
                </select>
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold py-1 px-2 rounded"><i class="fas fa-search"></i></button>
            </form>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-sm font-medium text-gray-700 text-left">
                        <th class="px-4 py-2 bg-gray-200">Instructor</th>
                        <th class="px-4 py-2 bg-gray-200">Semester</th>
                        <th class="px-4 py-2 bg-gray-200">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-normal text-gray-700">
                    @if ($previousEvaluations->isEmpty())
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center text-gray-500">No previous evaluation</td>
                        </tr>
                    @else
                        @foreach ($previousEvaluations as $evaluation)
                            <tr class="hover:bg-gray-100 border-b border-gray-200">
                                <td class="px-4 py-2">{{ $evaluation->instructor->instructor_name }}</td>
                                <td class="px-4 py-2">{{ $evaluation->semester }}</td>
                                <td class="px-4 py-2">{{ $evaluation->status }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            
        </div>
        
    </div>


    {{-- Modal change password --}}
<div class="fixed inset-0 overflow-y-auto hidden" id="changePasswordModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full md:max-w-md" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-bold text-gray-700">Change Password</h3>
                <form action="{{ route('instructor-side.change-password', ['instructor_id' => $instructor->instructor_id]) }}" method="POST" class="bg-white shadow-md rounded px-3 pt-5 pb-6 mb-1">
                    @csrf
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="oldpassword" class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                        <div class="relative">
                            <input type="password" id="oldpassword" name="oldpassword" required onfocus="clearError()"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="togglePassword_Old" class="far fa-eye-slash text-gray-500 cursor-pointer"></i>
                            </span>
                            @error('oldpassword')
                                <p id="oldpassword_error" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="newpassword" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                        <div class="relative">
                            <input type="password" id="newpassword" name="newpassword" required onfocus="clearError()"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="togglePassword_New" class="far fa-eye-slash text-gray-500 cursor-pointer"></i>
                            </span>
                            @error('newpassword')
                                <p id="newpassword_error" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="con_pass" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                        <div class="relative">
                            <input type="password" id="con_pass" name="con_pass" required onfocus="clearError()"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="togglePassword_Con" class="far fa-eye-slash text-gray-500 cursor-pointer"></i>
                            </span>
                            @error('con_pass')
                                <p id="con_pass" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm" >
                        Save
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closePasswordModal">
                        Close
                    </button>
                </form>

            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">       
                
            </div>
        </div>
    </div>
</div>

{{-- script for show password --}}
<script>
        const oldpassword = document.getElementById('oldpassword');
        const togglePassword_Old = document.getElementById('togglePassword_Old');
        const newpassword = document.getElementById('newpassword');
        const togglePassword_New = document.getElementById('togglePassword_New');
        const con_pass = document.getElementById('con_pass');
        const togglePassword_Con = document.getElementById('togglePassword_Con');

        togglePassword_Old.addEventListener('click', function() {
            if (oldpassword.type === 'password') {
                oldpassword.type = 'text';
                togglePassword_Old.classList.remove('fa-eye-slash');
                togglePassword_Old.classList.add('fa-eye');
            } else {
                oldpassword.type = 'password';
                togglePassword_Old.classList.remove('fa-eye');
                togglePassword_Old.classList.add('fa-eye-slash');
            }
        });
        togglePassword_New.addEventListener('click', function() {
            if (newpassword.type === 'password') {
                newpassword.type = 'text';
                togglePassword_New.classList.remove('fa-eye-slash');
                togglePassword_New.classList.add('fa-eye');
            } else {
                newpassword.type = 'password';
                togglePassword_New.classList.remove('fa-eye');
                togglePassword_New.classList.add('fa-eye-slash');
            }
        });
        togglePassword_Con.addEventListener('click', function() {
            if (con_pass.type === 'password') {
                con_pass.type = 'text';
                togglePassword_Con.classList.remove('fa-eye-slash');
                togglePassword_Con.classList.add('fa-eye');
            } else {
                con_pass.type = 'password';
                togglePassword_Con.classList.remove('fa-eye');
                togglePassword_Con.classList.add('fa-eye-slash');
            }
        });

</script>
{{-- script for show password END --}}

<!-- Script for change password modal -->
<script>
    const addSubjectButton = document.getElementById('changePasswordButton');
    const addSubjectModal = document.getElementById('changePasswordModal');
    const closeSubjectModal = document.getElementById('closePasswordModal');

    addSubjectButton.addEventListener('click', () => {
        addSubjectModal.classList.remove('hidden');
    });

    closeSubjectModal.addEventListener('click', () => {
        addSubjectModal.classList.add('hidden');
    });
</script>
    
    

    
    <script>

        const menuBtn = document.getElementById('menuBtn');
        const sideNav = document.getElementById('sideNav');

        menuBtn.addEventListener('click', () => {
            sideNav.classList.toggle('hidden');
        });
    </script>

{{-- Script for previewing image --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#pfp').change(function() {
            var input = this;
            var image = $('#previewImage')[0];

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    image.src = e.target.result;
                    image.classList.remove('hidden');
                };

                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>

</body>

@include('partials.footer')
@endauth
