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
                    Upload Student Records
                </h3>
                <p class="text-md font-bold text-gray-500">
                    Use this feature to easily upload and manage student records. 
                    <i><b>E-val</b></i> simplifies the process, making it efficient and hassle-free.
                </p>
            </div>            
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg p-4 shadow-md my-4 h-auto md:h-4/5">
        <div class="overflow-x-auto overflow-y-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <!-- Upload Form -->
                <form action="{{ route('admin.uploadStudent') }}" method="POST" enctype="multipart/form-data" class="flex flex-row items-center space-x-2 md:space-x-4 w-full md:w-auto">
                    @csrf
                    <div class="flex flex-row items-center space-x-2 md:space-x-4 w-full md:w-auto">
                        <div class="flex flex-col items-start">
                            <label for="students_csv" class="text-gray-700 font-bold mb-1 text-sm md:text-base">Upload Students (.csv)</label>
                            <input type="file" name="students_csv" accept=".csv" class="w-full md:w-auto border-2 border-gray-300 rounded-md p-1 md:p-2" required>
                        </div>
                        <div>
                            <button type="submit" class="bg-green-800 text-white px-3 py-2 rounded-md text-sm font-bold md:text-base mt-6">
                                <i class="fas fa-upload"></i>
                                 Upload
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex flex-col items-center justify-center h-full mt-4">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Overall Student Evaluation Progress</h2>
                <div class="relative flex items-center justify-center">
                    <svg class="w-40 h-40">
                        <circle class="text-gray-300" stroke-width="5" stroke="currentColor" fill="transparent" r="60" cx="80" cy="80"/>
                        <circle id="progressCircle" class="text-green-800" stroke-width="5" stroke-dasharray="377" stroke-dashoffset="0" stroke-linecap="round" stroke="currentColor" fill="transparent" r="60" cx="80" cy="80"/>
                    </svg>
                    <div class="absolute flex flex-col items-center justify-center">
                        <span id="progressText" class="text-2xl font-bold text-green-800">0%</span>
                        <span class="text-sm font-semibold text-gray-600">Completed</span>
                        {{-- <span id="completionCount" class="text-sm font-semibold text-gray-600">0/0</span> --}}
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <p id="completionCount" class="text-lg font-semibold text-gray-700">0/0</p>
                </div>
                <div class="flex justify-center mt-4 mb-4">
                    @if(session('eval_status') == 'close')
                        <form action="{{route('admin.EvalControl')}}" method="POST" class="flex items-center">
                            @csrf
                            <input type="text" name="eval_status" class="hidden" value="open">
                            <button type="submit" class="bg-green-800 text-white px-4 py-2 rounded-lg">
                                <i class="fas fa-unlock"></i>
                                Start Evaluation
                            </button>
                        </form>
                    @elseif(session('eval_status') == 'open')
                        <form action="{{route('admin.EvalControl')}}" method="POST" class="flex items-center">
                            @csrf
                            <input type="text" name="eval_status" class="hidden" value="close">
                            <button type="submit" class="bg-green-800 text-white px-4 py-2 rounded-lg">
                                <i class="fas fa-lock"></i>
                                Close Evaluation
                            </button>
                        </form>
                    @else
                        <form action="#" method="POST" class="flex items-center">
                            @csrf
                            <button type="submit" class="bg-green-800 text-white px-4 py-2 rounded-lg" disabled>
                                <i class="fas fa-finish"></i>
                                Evaluation Closed
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    
</div>

{{-- Modal for add subject --}}

<script>
    let percentage = {{ $completionPercentage }}; // Assuming $completionPercentage is passed from the controller
    let completedCount = {{ $completedCount }}; // Assuming $completedCount is passed from the controller
    let totalCount = {{ $totalCount }}; // Assuming $totalCount is passed from the controller
    let circle = document.getElementById('progressCircle');
    let text = document.getElementById('progressText');
    let countText = document.getElementById('completionCount');
    let circumference = 2 * Math.PI * circle.getAttribute('r');
    let offset = circumference - (percentage / 100) * circumference;
    
    circle.style.strokeDashoffset = offset;
    text.textContent = percentage + '%';
    countText.textContent = completedCount + '/' + totalCount;
</script>
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
