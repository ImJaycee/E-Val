@auth('instructors')

@php
    $title = 'E-Val-Dashboard';
    $array = ['title' => $title];
    $instructor_id = session('instructor_id');
    $firstname = session('firstname');

@endphp

@include('partials.header-instructor')


<body class="bg-gray-200">

<x-nav-instructor/> <!--Include nav and sidebar-->
<x-messages/>
<div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">
    <!-- Main Container -->
    <div class="lg:flex gap-4 items-stretch">
        <!-- Large Box -->
        <div class="bg-white md:p-2 p-6 rounded-lg border border-gray-200 mb-4 lg:mb-0 shadow-md lg:w-[25%]">
            <div class="flex justify-left items-right space-x-5 h-full">
                <div>
                    @include('partials.semester')
                    <p class="text-md font-bold text-gray-700">Current Semester</p>
                    <h2 class="text-3xl font-bold text-gray-600">{{ getCurrentSemester() }} <i class="fas fa-calendar-alt"></i></h2>
                    <h2 class="text-md font-bold text-gray-600"> <span>A.Y </span>{{ getCurrentAcademicYear() }} </h2>
                    <h2 class="text-sm text-gray-600" id="datetime"></h2>
                </div>
            </div>
        </div>

        <!-- White Box -->
        <div class="bg-white p-4 rounded-lg xs:mb-4 max-w-full shadow-md lg:w-[75%]">
            <!-- Small Boxes -->
            <div class="block justify-center h-full">
                <h3 class="text-xl font-bold text-gray-700">
                    Welcome back <i>{{$instructor->firstname}}</i>!
                </h3>
                <p class="text-md font-bold text-gray-500">
                    <i><b>E-val</b></i> is our evaluation tool designed to streamline and enhance 
                    your evaluation processes. Explore its features to simplify evaluations and improve efficiency.
                </p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="relative bg-cover bg-center bg-no-repeat rounded-lg p-4 shadow-md my-4" style="height: 31.25rem;">
        <!-- Blurred Background Image -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('storage/images/index-bg.jpg'); filter: blur(8px);"></div>
            <div class="absolute inset-0 bg-black bg-opacity-10"></div>
        </div>
    
        <div class="relative overflow-y-auto" style="max-height: 440px;">
            <!-- Background Image -->
            {{-- <div class="absolute inset-0 bg-cover bg-center opacity-50" style="background-image: url('storage/images/index-bg.jpg');"></div> --}}
        
            <!-- Content Overlay -->
            <div class="relative grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-5 p-4 z-0">
                @php
                    // Define an array of background colors
                    $colors = [
                        'bg-blue-500',
                        'bg-green-500',
                        'bg-red-500',
                        'bg-yellow-500',
                        'bg-purple-500',
                        'bg-orange-500',
                        'bg-pink-500',
                        'bg-teal-500',
                        'bg-indigo-500',
                        'bg-gray-500'
                    ];
                @endphp

                @foreach($allSubjectsAssigned as $index => $subject)
                    <div class="relative bg-cover bg-center shadow-md rounded p-3 opacity-85 {{ $colors[$index % count($colors)] }}">
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded"></div>
                        <div class="relative z-10">
                            <div class="mb-2">
                                <h2 class="text-sm font-bold text-gray-100"></h2>
                                <p class="font-bold text-xs text-gray-200">{{ $subject['description'] }}</p>
                            </div>
                            <div class="mb-2">
                                <h2 class="text-sm font-bold text-gray-100"></h2>
                                <p class="font-bold text-xs text-gray-200">{{ $subject['subject_code'] }}</p>
                            </div>
                            <div class="mb-2">
                                <h2 class="text-sm font-bold text-gray-100"></h2>
                                <p class="font-bold text-xs text-gray-200">{{ $subject['section'] }}</p>
                            </div>
                            <div class="text-center">
                                <form action="{{ route('instructor.removeSubject', ['instructor_id' => $instructor->instructor_id, 'subject_code' => $subject['subject_code'] ]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-700 px-2 py-1 font-semibold rounded text-white text-xs w-1/2">                   
                                        Remove <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

        
                <div class="col-span-1 sm:col-span-3 md:col-span-4 text-center">
                    <button class="w-full md:w-60 py-1 bg-gray-700 text-white  border-gray-600 rounded mt-2" id="addSubjectButton">
                        <i class="fas fa-plus"></i> Add Subject
                    </button>
                </div>
            </div>
        </div>
        
        <a href="{{ route('instructor.feedback') }}" 
            class="fixed bottom-4 right-4 sm:text-sm text-yellow-500 bg-gray-100 border-2 border-gray-200 text-white p-3 rounded-full shadow-lg hover:bg-red-700 hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <i class="fas fa-star"></i>
        </a>
        
    </div>
</div>

{{-- Modal for add subject --}}
<div class="fixed inset-0 overflow-y-auto hidden z-50" id="addSubjectModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full md:max-w-md" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-bold text-gray-700">Add Subject</h3>
                <form action="{{ route('instructor.addSubject', ['instructor_id' => $instructor_id]) }}" method="POST" class="bg-white shadow-md rounded px-3 pt-5 pb-6 mb-1">
                    @csrf
                    <input type="number" id="instructor_id" name="instructor_id" class="hidden" value="{{$instructor->instructor_id}}">
                    <div class="mb-3">
                        <label for="subject_code" class="block text-gray-700 text-sm font-bold mb-2">Course Code</label>
                        <select id="subject_code" name="subject_code" required onfocus="clearError()"
                            class="shadow appearance-none border rounded w-full text-sm py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('program')}}>
                            <option value="" disabled selected>Select Subject</option>
                            @foreach($AllSubjectCodes as $subjectcodes) {{-- Loop through all subject codes --}}
                                <option value="{{$subjectcodes->subject_code}}">{{$subjectcodes->subject_code}}</option>
                            @endforeach
                            <!-- Add more options as needed -->
                        </select>  
                    </div>
                    <!-- Add more form fields as needed -->
                    <div class="mb-3">
                        <label for="program" class="block text-gray-700 text-sm font-bold mb-2">Program</label>
                        <select id="program" name="program" required onfocus="clearError()"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('program')}}>
                            <option value="" disabled selected>Select your program</option>
                            <option value="BSCE">Bachelor of Science in Civil Engineering</option>
                            <option value="BSBA">Bachelor of Science in Business Administration - Major In Marketing</option>
                            <option value="BSIT">Bachelor of Science in Information Technology</option>
                            <option value="BEED">Bachelor of Elementary Education - Major In General Education</option>
                            <option value="BSE">Bachelor of Science in Entrepreneurship</option>
                            <option value="BScPsych">Bachelor of Science in Psychology</option>
                            <option value="BSTM">Bachelor of Science in Tourism Management</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="block text-gray-700 text-sm font-bold mb-2">Year Level</label>
                        <select id="year" name="year" required onfocus="clearError()"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('program')}}>
                            <option value="" disabled selected>Year Level</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <!-- Add more options as needed -->
                        </select>  
                    </div>
                    <div class="mb-3">
                        <label for="section" class="block text-gray-700 text-sm font-bold mb-2">Section</label>
                        <div id="section" name="section" required onfocus="clearError()"
                             class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div>
                                <input type="checkbox" name="sections[]" value="A">
                                <label for="sectionA">A</label>
                            </div>
                            <div>
                                <input type="checkbox" name="sections[]" value="B">
                                <label for="sectionB">B</label>
                            </div>
                            <div>
                                <input type="checkbox" name="sections[]" value="C">
                                <label for="sectionC">C</label>
                            </div>
                            <!-- Add more checkboxes as needed -->
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm" id="saveSubjectButton">
                            Save
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closeSubjectModal">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







    <!-- Script  -->
    <script>
        const addSubjectButton = document.getElementById('addSubjectButton');
        const addSubjectModal = document.getElementById('addSubjectModal');
        const closeSubjectModal = document.getElementById('closeSubjectModal');
    
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

    {{-- Date and time script --}}
    <script>
        function updateDateTime() {
            const now = new Date();
            const date = now.toDateString();
            const time = now.toLocaleTimeString();
            document.getElementById('datetime').textContent = `${date} ${time}`;
        }

        // Update date and time every second
        setInterval(updateDateTime, 100
        0);

        // Initial update
        updateDateTime();
    </script>
</body>

@include('partials.footer')
@endauth
