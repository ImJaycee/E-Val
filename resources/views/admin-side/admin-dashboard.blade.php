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
                    Welcome back <i>{{$admin->firstname}}</i>!
                </h3>
                <p class="text-md font-bold text-gray-500">
                    <i><b>E-val</b></i> is our evaluation tool designed to streamline and enhance 
                    your evaluation processes. Explore its features to simplify evaluations and improve efficiency.
                </p>
            </div>
        </div>
    </div>
    
    {{-- Instructors --}}
    <div class="container mx-auto mt-1">
        <div class="relative bg-cover bg-center bg-no-repeat rounded-lg p-4 shadow-md my-4" style="height: 29rem;">
            <!-- Blurred Background Image -->
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('storage/images/index-bg.jpg'); filter: blur(8px);"></div>
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
            </div>
            <div class="relative overflow-y-auto overflow-x-auto" style="max-height: 380px;">
                <div class="relative grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5 p-4 z-0">

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

                    @foreach($allInstructorsData as $index => $instructors)
                    <div class="relative bg-cover bg-center shadow-md rounded p-3 opacity-85 {{ $colors[$index % count($colors)] }}">
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded"></div>
                        <div class="relative z-10">
                            <div class="mb-2">
                                <h2 class="text-sm font-bold text-gray-100"></h2>
                                <p class="font-bold text-xs text-gray-200">{{ $instructors['name'] }}</p>
                            </div>
                            <div class="mb-2">
                                <h2 class="text-sm font-bold text-gray-100"></h2>
                                <p class="font-bold text-xs text-gray-200">{{ $instructors['department'] }}</p>
                            </div>
                            <div class="mb-2">
                                <h2 class="text-xs font-semibold text-gray-100">Evaluation Progress</h2>
                                <p class="font-bold text-xs text-gray-200">{{ $instructors['completed_evaluations'] }}/{{ $instructors['total_evaluators'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
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
