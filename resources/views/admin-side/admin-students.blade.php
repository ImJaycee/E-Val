@auth('admins')

@php
    $title = 'E-Val-Admin';
    $array = ['title' => $title];
    $admin_id = session('admin_id');
    $firstname = session('firstname');
    $lastname = session('lastname');

@endphp

@include('partials.header-admin')


<body class="bg-gray-200">

<x-nav-admin/> <!--Include nav and sidebar-->

<div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">
    <x-messages/>
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
                    Welcome back <i>{{$admin->firstname}}</i>!
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
                        <th colspan="4" class="bg-white px-2 py-2 text-left">
                            <form action="{{ route('admin.uploadStudent') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <div class="items-center">
                                        <label for="students_csv" class="text-gray-700 font-bold mb-2">Upload Students (.csv)</label>
                                        <input type="file" name="students_csv" accept=".csv" class="w-full border-2 border-gray-300 rounded-lg p-2" required>
                                    </div>
                                    <div class="mt-5">
                                        <button type="submit" class="bg-green-800 text-white px-4 py-2 rounded-lg">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </th>
                    </tr>
                    
                    
                        <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 25%;">
                            <h2 class="text-ml font-bold text-gray-700">Name</h2>
                        </th>
                        <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 25%;">
                            <h2 class="text-ml font-bold text-gray-700">Section</h2>
                        </th>
                        <th class="bg-white px-4 py-2 text-left border-b-2 text-center" style="width: 25%;">
                            <h2 class="text-ml font-bold text-gray-700">Program</h2>
                        </th>
                        <th class="bg-white px-4 py-2 text-center border-b-2" style="width: 25%;">
                            <h2 class="text-ml font-bold text-gray-700">Status</h2>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr class="border-b">
                        <td class="px-4 py-3 text-left align-top font-bold text-sm text-gray-600">
                            <p>Jay Cee Cruz</p>
                        </td>
                        <td class="px-4 py-3 text-left font-bold text-sm text-gray-600">
                            <p><span>3B</span></p>
                        </td>
                        <td class="px-4 py-3 text-left font-bold text-sm text-gray-600 text-center">
                            <p><span>BSIT</span></p>
                        </td>
                        <td class="px-4 py-3 text-left font-bold text-sm text-gray-600 text-center">
                            <p><span>Pending</span></p>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-3 text-left align-top font-bold text-sm text-gray-600">
                            <p>Jay Cee Cruz</p>
                        </td>
                        <td class="px-4 py-3 text-left font-bold text-sm text-gray-600">
                            <p><span>3B</span></p>
                        </td>
                        <td class="px-4 py-3 text-left font-bold text-sm text-gray-600 text-center">
                            <p><span>BSIT</span></p>
                        </td>
                        <td class="px-4 py-3 text-left font-bold text-sm text-gray-600 text-center">
                            <p><span>Pending</span></p>
                        </td>
                    </tr>
                    <tr class="">
                        <td colspan="4" class="text-center text-sm font-semibold py-1 rounded">
                            <button class="w-full md:w-60 py-1 bg-green-800 text-white border-2 border-green-900 rounded mt-2" id="addSubjectButton">
                                <i class="fas fa-file-alt"></i> Open Evaluation
                            </button>
                        </td>
                    </tr>                   
                
                    {{-- @foreach($allInstructorsData as $instructors)
                    <tr class="border-b">
                        <td class="px-4 py-3 text-left align-top font-bold text-sm text-gray-600">
                            <p>{{ $instructors['name'] }}</p>
                        </td>
                        <td class="px-4 py-3 text-left font-bold text-sm text-gray-600">
                            <p><span>{{ $instructors['department'] }}</span></p>
                        </td>
                        <td class="px-4 py-3 text-left font-bold text-sm text-gray-600 text-center">
                            <p><span>{{ $instructors['total_evaluators'] }}</span></p>
                        </td>
                        <td class="px-4 py-3 text-left font-bold text-sm text-gray-600 text-center">
                            <p><span>{{ $instructors['completed_evaluations'] }}</span></p>
                        </td>
                    </tr>
                @endforeach --}}
                
                {{-- <tr class="">
                    <td colspan="6" class="text-center text-sm font-semibold py-1 rounded">
                        <button class="w-full md:w-60 py-1 bg-green-800 text-white border-2 border-green-900 rounded mt-2" id="addSubjectButton">
                            <i class="fas fa-file-alt"></i> Open Evaluation
                        </button>
                    </td>
                </tr>                --}}
            </tbody>
        </table>
        </div>
    </div>
</div>

{{-- Modal for add subject --}}


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
