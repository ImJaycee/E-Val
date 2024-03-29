@auth('students')

@php
    $title = 'E-Val-Dashboard';
    $array = ['title' => $title];
    // $studentID = session('studentID');
@endphp

@include('partials.header-student')


<body class="bg-gray-200">

<x-nav-student/> <!--Include nav and sidebar-->

<div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">


    <!-- Main Container -->
    <div class="lg:flex gap-4 items-stretch">
        <!-- Large Box -->
        <div class="bg-white md:p-2 p-6 rounded-lg border border-gray-200 mb-4 lg:mb-0 shadow-md lg:w-[25%]">
            <div class="flex justify-left items-right space-x-5 h-full">
                <div>
                    <p class="text-xl font-bold text-gray-700">Current Semester</p>
                    <h2 class="text-4xl font-bold text-gray-600">1st <i class="fas fa-calendar-alt"></i></h2>
                    <h2 class="text-md text-gray-600" id="datetime"></h2>
                </div>
                
            </div>
            
            
        </div>

        <!-- White Box -->
        <div class="bg-white p-4 rounded-lg xs:mb-4 max-w-full shadow-md lg:w-[75%]">
            <!-- Small Boxes -->
            <div class="block justify-center h-full">
            {{-- <div class="flex flex-wrap justify-between h-full"> --}}
                <h3 class="text-xl font-bold text-gray-700">
                    Welcome back <i>Jay Cee</i>!
                </h3>
                <p class="text-md font-bold text-gray-500">
                    <i><b>E-val</b></i> is our evaluation tool designed to streamline and enhance 
                    your evaluation processes. Explore its features to simplify evaluations and improve efficiency.
                </p>
              
                {{-- <!-- Small Box 1 -->
                <div class="flex-1 bg-gradient-to-r from-red-800 to-yellow-500 rounded-lg flex flex-col items-center justify-center p-4 space-y-2 border border-gray-200 m-2">
                    <i class="fas fa-user text-white text-4xl"></i>
                    <p class="text-gray-100">Top 1</p>
                </div>

                <!-- Small Box 2 -->
                <div class="flex-1 bg-gradient-to-r from-red-800 to-yellow-500 rounded-lg flex flex-col items-center justify-center p-4 space-y-2 border border-gray-200 m-2">
                    <i class="fas fa-user text-white text-4xl"></i>
                    <p class="text-gray-100">Top 2</p>
                </div>

                <!-- Small Box 3 -->
                <div class="flex-1 bg-gradient-to-r from-red-800 to-yellow-500 rounded-lg flex flex-col items-center justify-center p-4 space-y-2 border border-gray-200 m-2">
                    <i class="fas fa-user text-white text-4xl"></i>
                    <p class="text-gray-100">Top 3</p>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg p-4 shadow-md my-4">
        <table class="table-auto w-full" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b-2" style="width: 33.33%;">
                        <h2 class="text-ml font-bold text-gray-700">Subject Enrolled</h2>
                    </th>
                    <th class="px-4 py-2 text-left border-b-2" style="width: 33.33%;">
                        <h2 class="text-ml font-bold text-gray-700">Code</h2>
                    </th>
                    <th class="px-4 py-2 text-left border-b-2" style="width: 33.33%;">
                        <h2 class="text-ml font-bold text-gray-700">Instructor</h2>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="px-4 py-4 text-left align-top font-bold text-sm text-gray-600">
                        <p>Capstone 1</p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>CAP 323</span></p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>Davemm Salalila</span></p>
                    </td>
                </tr>    
                <tr class="border-b">
                    <td class="px-4 py-4 text-left align-top font-bold text-sm text-gray-600">
                        <p>Capstone 1</p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>CAP 323</span></p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>Davemm Salalila</span></p>
                    </td>
                </tr> 
                <tr class="border-b">
                    <td class="px-4 py-4 text-left align-top font-bold text-sm text-gray-600">
                        <p>Capstone 1</p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>CAP 323</span></p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>Davemm Salalila</span></p>
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-4 text-left align-top font-bold text-sm text-gray-600">
                        <p>Capstone 1</p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>CAP 323</span></p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>Davemm Salalila</span></p>
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-4 text-left align-top font-bold text-sm text-gray-600">
                        <p>Capstone 1</p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>CAP 323</span></p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>Davemm Salalila</span></p>
                    </td>
                </tr> 
                <tr class="border-b">
                    <td class="px-4 py-4 text-left align-top font-bold text-sm text-gray-600">
                        <p>Capstone 1</p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>CAP 323</span></p>
                    </td>
                    <td class="px-4 py-4 text-left font-bold text-sm text-gray-600">
                        <p><span>Davemm Salalila</span></p>
                    </td>
                </tr> 
                <tr class="border-b">
                    <td colspan="6" class="text-center bg-gray-800 hover:bg-gray-700 text-white py-1 rounded">
                        <button class="w-full" id="addSubjectButton">
                            <i class="fas fa-add"></i> Add subject
                        </button>
                    </td>
                </tr>               
            </tbody>
        </table>
        
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
                <form action="#" method="POST" class="bg-white shadow-md rounded px-3 pt-5 pb-6 mb-1">
                    @csrf
                    <div class="mb-3">
                        <label for="courseCode" class="block text-gray-700 text-sm font-bold mb-2">Course Code</label>
                        {{-- <input type="text" class="form-control w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="subjectName"> --}}
                        <select id="courseCode" name="courseCode" required onfocus="clearError()"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value={{old('program')}}>
                            <option value="" disabled selected>Select Class Code</option>
                            <option value="CAP323">CAP323</option>
                            <option value="CAP323">CAP323</option>
                            <option value="CAP323">CAP323</option>
                            <option value="CAP323">CAP323</option>
                            <option value="CAP323">CAP323</option>
                            <option value="CAP323">CAP323</option>
                            <option value="CAP323">CAP323</option>
                            <!-- Add more options as needed -->
                        </select>  
                    </div>
                    <!-- Add more form fields as needed -->
                    <div class="mb-3">
                        <label for="yearLevel" class="block text-gray-700 text-sm font-bold mb-2">Year Level</label>
                        {{-- <input type="text" class="form-control w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="subjectName"> --}}
                        <select id="yearLevel" name="yearLevel" required onfocus="clearError()"
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
                </form>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm" id="saveSubjectButton">
                    Save
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closeSubjectModal">
                    Close
                </button>
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
