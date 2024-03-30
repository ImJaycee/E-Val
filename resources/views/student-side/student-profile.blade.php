@auth('students')

@php
    $title = 'E-Val-Profile';
    $array = ['title' => $title];
    // $studentID = session('studentID');
@endphp

@include('partials.header-student')


<body class="bg-gray-200">

<x-nav-student/> <!--Include nav and sidebar-->

<div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">


    <!-- Main Container -->
    <div class="lg:flex gap-4 items-stretch">
        
        <div class="bg-white md:p-2 p-6 rounded-lg border border-gray-200 mb-4 lg:mb-0 shadow-md lg:w-[35%]">
          
            <div class="block justify-center h-full">
                <div class="max-w-md bg-white shadow-md rounded-lg overflow-hidden mx-auto">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-center">
                            <img class="h-16 w-16 rounded-full object-cover" src="storage/image/test-profile.png" alt="User profile picture">
                        </div>
                        <div class="text-center mt-2">
                            <p class="text-lg text-gray-800 font-medium">Jay Cee Cruz</p>
                            <p class="text-sm font-semibold text-gray-700">2021309990</p>
                            <p class="text-sm font-normal text-gray-700">Bachelor of Science in Information Technology</p>
                            <p class="text-sm font-normal text-gray-700">3rd Year</p>
                            <p class="text-sm font-normal text-gray-700">Section B</p>
                            <p class="text-sm font-normal text-gray-700">jc@gmail.com</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 flex justify-center">
                        <button class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded mr-2">Update Profile</button>
                        <button class="bg-red-700 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">Reset Password</button>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="bg-white p-4 rounded-lg xs:mb-4 max-w-full max-h-80 shadow-md lg:w-[75%]">
            <h3 class="text-xl font-bold text-gray-700">
                Evaluated Instructors<i> A.Y. 2023-2024</i>
            </h3>
            {{-- @if ($instructors->count() > 0) --}}
            <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 lg:grid-cols-8 gap-3 mt-4 max-h-64 overflow-y-auto">
                {{-- @foreach ($instructors as $instructor) --}}
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <img src="storage/image/test-profile.png" alt="picture" class="w-14 h-14 mb-2 rounded-full">
                    <p class="text-xs text-center text-gray-600">CAP323</p>
                </div>
                                                                                                                
                
                {{-- @endforeach --}}
            </div>
            {{-- @else
            <p class="text-md font-bold text-red-800">
                No instructors have been evaluated yet.
            </p>
            @endif --}}
        </div>
        

    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg p-4 shadow-md my-3" style="height: 300px;">
        <h3 class="text-xl font-bold text-gray-700 mb-2">
            Evaluation History
        </h3>
        <div class="overflow-x-auto mt-1 max-h-52 overflow-y-auto">
            <form action="#" method="GET" class="flex flex-col lg:flex-row justify-end mb-2">
                <label for="academic_year" class="mr-2">A.Y.</label>
                <select name="academic_year" id="academic_year" required class="border border-gray-300 rounded-md p-1 mb-2 lg:mb-0 lg:mr-1 text-sm">
                    <option value="" disabled selected class="text-sm">Select academic year</option>
                    <option value="2021-2022-1">2021-2022 - 1st sem</option>
                    <option value="2021-2022-2">2021-2022 - 2nd sem</option>
                    <option value="2022-2023-1">2022-2023 - 1st sem</option>
                    <option value="2022-2023-2">2022-2023 - 2nd sem</option>
                    <option value="2023-2024-1">2023-2024 - 1st sem</option>
                    <!-- Add more options as needed -->
                </select>
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold py-1 px-2 rounded"><i class="fas fa-search"></i></button>
            </form>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-sm font-medium text-gray-700 text-left">
                        <th class="px-4 py-2 bg-gray-200">Instructor</th>
                        <th class="px-4 py-2 bg-gray-200">Subject</th>
                        <th class="px-4 py-2 bg-gray-200">Status</th>
                    </tr>
                </thead>
                
                <tbody class="text-sm font-normal text-gray-700">
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-2">Mr. Davemm Salalila</td>
                        <td class="px-4 py-2">Web Development 2</td>
                        <td class="px-4 py-2">Completed</td>
                    </tr>
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-2">Mr. Davemm Salalila</td>
                        <td class="px-4 py-2">Web Development 2</td>
                        <td class="px-4 py-2">Completed</td>
                    </tr>
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-2">Mr. Davemm Salalila</td>
                        <td class="px-4 py-2">Web Development 2</td>
                        <td class="px-4 py-2">Completed</td>
                    </tr>
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-2">Mr. Davemm Salalila</td>
                        <td class="px-4 py-2">Web Development 2</td>
                        <td class="px-4 py-2">Completed</td>
                    </tr>
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-2">Mr. Davemm Salalila</td>
                        <td class="px-4 py-2">Web Development 2</td>
                        <td class="px-4 py-2">Completed</td>
                    </tr>
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-2">Mr. Davemm Salalila</td>
                        <td class="px-4 py-2">Web Development 2</td>
                        <td class="px-4 py-2">Completed</td>
                    </tr>
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-2">Mr. Davemm Salalila</td>
                        <td class="px-4 py-2">Web Development 2</td>
                        <td class="px-4 py-2">Completed</td>
                    </tr>
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-2">Mr. Davemm Salalila</td>
                        <td class="px-4 py-2">Web Development 2</td>
                        <td class="px-4 py-2">Completed</td>
                    </tr>
                    <!-- Add more table rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
    
    

    
    <script>

        const menuBtn = document.getElementById('menuBtn');
        const sideNav = document.getElementById('sideNav');

        menuBtn.addEventListener('click', () => {
            sideNav.classList.toggle('hidden');
        });
    </script>

</body>

@include('partials.footer')
@endauth
