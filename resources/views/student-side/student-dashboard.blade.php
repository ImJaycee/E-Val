@auth('students')

@php
    $title = 'E-Val-Dashboard';
    $array = ['title' => $title];
    $student_id = session('student_id');
    $firstname = session('firstname');

@endphp

@include('partials.header-student')


<body class="bg-gray-200">

<x-nav-student/> <!--Include nav and sidebar-->
<x-messages/>
<div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">
    <!-- Main Container -->
    <div class="lg:flex gap-4 items-stretch">
        <!-- Large Box -->
        <div class="bg-white md:p-2 p-6 rounded-lg border border-gray-200 mb-4 lg:mb-0 shadow-md lg:w-[25%]">
            <div class="flex justify-left items-right space-x-5 h-full">
                <div>
                    <p class="text-xl font-bold text-gray-700">Current Semester</p>
                    <h2 class="text-4xl font-bold text-gray-600">2nd <i class="fas fa-calendar-alt"></i></h2>
                    <h2 class="text-md text-gray-600" id="datetime"></h2>
                </div>
            </div>
        </div>

        <!-- White Box -->
        <div class="bg-white p-4 rounded-lg xs:mb-4 max-w-full shadow-md lg:w-[75%]">
            <!-- Small Boxes -->
            <div class="block justify-center h-full">
                <h3 class="text-xl font-bold text-gray-700">
                    Welcome back <i>{{$student->firstname}}</i>!
                </h3>
                <p class="text-md font-bold text-gray-500">
                    <i><b>E-val</b></i> is our evaluation tool designed to streamline and enhance 
                    your evaluation processes. Explore its features to simplify evaluations and improve efficiency.
                </p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg p-4 shadow-md my-4" style="height: 31.25rem;">
        <div class="overflow-y-auto" style="max-height: 440px;">
            <table class="table-auto w-full" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 25%;">
                            <h2 class="text-ml font-bold text-gray-700">Subject Enrolled</h2>
                        </th>
                        <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 25%;">
                            <h2 class="text-ml font-bold text-gray-700">Code</h2>
                        </th>
                        <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 25%;">
                            <h2 class="text-ml font-bold text-gray-700">Instructor</h2>
                        </th>
                        <th class="bg-white px-4 py-2 text-left border-b-2" style="width:25%;">
                            <h2 class="text-ml font-bold text-gray-700"></h2>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allSubjectsEnrolled as $subject)
                        <tr class="border-b">
                            <td class="px-4 py-3 text-left align-top font-bold text-sm text-gray-600">
                                <p>{{ $subject['description'] }}</p>
                            </td>
                            <td class="px-4 py-3 text-left font-bold text-sm text-gray-600">
                                <p><span>{{ $subject['subject_code'] }}</span></p>
                            </td>
                            <td class="px-4 py-3 text-left font-bold text-sm text-gray-600">
                                <p><span>{{ $subject['instructor_name'] ?? 'Not assigned' }}</span></p>
                            </td>
                            <td class="px-4 py-3 text-left font-semibold text-md text-gray-100 text-center">
                                <form action="#" method="POST" onsubmit="return confirm('Are you sure you want to delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 px-3 py-1 rounded">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    
                <tr class="">
                    <td colspan="6" class="text-center text-sm font-semibold py-1 rounded">
                        <button class="w-full md:w-60 py-1 bg-green-800 text-white border-2 border-green-900 rounded mt-2" id="addSubjectButton">
                            <i class="fas fa-add"></i> Add subject
                        </button>
                    </td>
                </tr>               
            </tbody>
        </table>
        </div>
    </div>
</div>

{{-- Modal for add subject --}}
<div class="fixed inset-0 overflow-y-auto hidden" id="addSubjectModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full md:max-w-md" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-bold text-gray-700">Add Subject</h3>
                <form action="{{ route('student.addSubject', ['student_id' => $student_id]) }}" method="POST" class="bg-white shadow-md rounded px-3 pt-5 pb-6 mb-1">
                    @csrf
                    <div class="mb-3">
                        <input type="number" id="student_id" name="student_id" class="hidden" value="{{$student->student_id}}">
                        <input type="text" id="program" name="program" class="hidden" value="{{$student->program}}">
                        <label for="subject_code" class="block text-gray-700 text-sm font-bold mb-2">Course Code</label>
                        {{-- <input type="text" class="form-control w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="subjectName"> --}}
                        <select id="subject_code" name="subject_code" required onfocus="clearError()"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('program')}}>
                            <option value="" disabled selected>Select Class Code</option>
                            <option value="IAS 323">IAS 323</option>
                            <option value="ITELEC 4">ITELEC 4</option>
                            <option value="HCI 323">HCI 323</option>
                            <option value="MS 323">MS 323</option>
                            <option value="CIS 323">CIS 323</option>
                            <option value="SIA 323">SIA 323</option>
                            <option value="CAP 323">CAP 323</option>
                            <!-- Add more options as needed -->
                        </select>  
                    </div>
                    <!-- Add more form fields as needed -->
                    <div class="mb-3">
                        <label for="year" class="block text-gray-700 text-sm font-bold mb-2">Year Level</label>
                        {{-- <input type="text" class="form-control w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="subjectName"> --}}
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
                        {{-- <input type="text" class="form-control w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="subjectName"> --}}
                        <select id="section" name="section" required onfocus="clearError()"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('program')}}>
                            <option value="" disabled selected>Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <!-- Add more options as needed -->
                        </select>  
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
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
        setInterval(updateDateTime, 1000);

        // Initial update
        updateDateTime();
    </script>
</body>

@include('partials.footer')
@endauth
