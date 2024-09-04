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

    <!-- Include nav and sidebar -->
    <x-nav-admin/> 

    <!-- Main Container -->
    <div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">
        <x-messages/>
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
                <div class="block justify-center h-full">
                    <h3 class="text-xl font-bold text-gray-700">
                        Upload Instructor Records
                    </h3>
                    <p class="text-md font-bold text-gray-500">
                        Use this feature to easily upload instructor records. 
                        <i><b>E-val</b></i> simplifies the process, making it efficient and hassle-free.
                    </p>
                </div>            
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg p-4 shadow-md my-4 h-auto md:h-4/5">
            <div class="overflow-x-auto overflow-y-auto">
                <div class="bg-gray-100 shadow-md p-2 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0 rounded">
                    <!-- Upload Form -->
                    <form action="{{route('admin.uploadInstructor') }}" method="POST" enctype="multipart/form-data" class="flex flex-row items-center space-x-2 md:space-x-4 w-full md:w-auto">
                        @csrf
                        <div class="flex flex-row items-center space-x-2 md:space-x-4 w-full md:w-auto">
                            <div class="flex flex-col items-start">
                                <label for="instructors_csv" class="text-gray-700 font-bold mb-1 text-sm md:text-base">Upload Instructors (.csv)</label>
                                <input type="file" name="instructors_csv" accept=".csv" class="w-full md:w-auto border-2 border-gray-300 rounded-md p-1 md:p-2" required>
                                @error('instructors_csv')
                                    <p class="text-red-500 text-sm text-end p-1">
                                        {{$message}}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                @if(session('eval_status_p2p') == 'close')
                                    <button type="submit" class="bg-green-800 text-white px-3 py-2 rounded-md text-sm font-bold md:text-base mt-6">
                                        <i class="fas fa-upload"></i>
                                        Upload
                                    </button>
                                @else
                                    <button type="submit" class="bg-green-800 text-white px-3 py-2 rounded-md text-sm font-bold md:text-base mt-6" disabled>
                                        <i class="fas fa-upload"></i>
                                        Upload
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
            
                    <!-- Peer-to-Peer Assignment Button -->
                    <div class="flex flex-row items-center space-x-2 md:space-x-4 w-full md:w-auto mt-6 md:mt-0">
                        <a href="#" class="bg-green-700 p-2 rounded text-white font-semibold" id="RemovePeerButton">
                            <i class="fas fa-trash"></i>
                            Clear Assignment
                        </a>
                        @if($totalEvaluations <= 0)
                            <form action="{{route('admin.assignPeerToPeer')}}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-800 text-white px-3 py-2 rounded-md text-sm font-bold md:text-base">
                                    <i class="fas fa-users"></i>
                                    P2P Assignment
                                </button>
                            </form>
                        @else
                            <form action="#">
                                @csrf
                                <button type="submit" class="bg-red-800 text-white px-3 py-2 rounded-md text-sm font-bold md:text-base" disabled>
                                    <i class="fas fa-users"></i>
                                    P2P Assigned
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            
                <div class="flex flex-col items-center justify-center h-full mt-4">
                    <h2 class="text-xl font-bold text-gray-700 mb-4">Peer Evaluation Progress</h2>
                    <div class="relative flex items-center justify-center">
                        <svg class="w-40 h-40">
                            <circle class="text-gray-300" stroke-width="5" stroke="currentColor" fill="transparent" r="60" cx="80" cy="80"/>
                            <circle id="progressCircle" class="text-green-800" stroke-width="5" stroke-dasharray="377" stroke-dashoffset="0" stroke-linecap="round" stroke="currentColor" fill="transparent" r="60" cx="80" cy="80"/>
                        </svg>
                        <div class="absolute flex flex-col items-center justify-center">
                            <span id="progressText" class="text-2xl font-bold text-green-800">0%</span>
                            <span class="text-sm font-semibold text-gray-600">Completed</span>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p id="completionCount" class="text-lg font-semibold text-gray-700">0/0</p>
                    </div>
                    <div class="flex justify-center mt-4 mb-4">
                        @if(session('eval_status_p2p') == 'close')
                            @if($totalEvaluations > 0)
                                <form action="{{route('admin.EvalControl_PTP')}}" method="POST" class="flex items-center">
                                    @csrf
                                    <input type="text" name="eval_status_p2p" class="hidden" value="open">
                                    <button type="submit" class="bg-green-800 text-white px-4 py-2 rounded-lg">
                                        <i class="fas fa-unlock"></i>
                                        Start Evaluation
                                    </button>
                                </form>

                            @else
                                <h3 class="">
                                    Assign Instructor Evaluations to Start Peer Evaluation
                                </h3>
                            @endif
                        @elseif(session('eval_status_p2p') == 'open')
                            <form action="{{route('admin.EvalControl_PTP')}}" method="POST" class="flex items-center">
                                @csrf
                                <input type="text" name="eval_status_p2p" class="hidden" value="close">
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


    {{-- Update profile --}}
    <div class="fixed inset-0 overflow-y-auto hidden" id="ClearPeerModal">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <span class="text-red-600 text-2xl font-bold">
                                !
                            </span>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Remove Peer Assignment?
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to remove all peer assignments? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="{{route('admin.clearPeerToPeer')}}" method="POST">
                        @csrf
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Clear
                        </button>
                    </form>
                    <button id="CancelModalButton" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let percentage = {{ $completionPercentage }}; // Assuming $completionPercentage is passed from the controller
        let completedCount = {{ $completedCount }}; // Assuming $completedCount is passed from the controller
        let totalEvaluations = {{ $totalEvaluations }}; // Assuming $totalEvaluations is passed from the controller
        let circle = document.getElementById('progressCircle');
        let text = document.getElementById('progressText');
        let countText = document.getElementById('completionCount');
        let circumference = 2 * Math.PI * circle.getAttribute('r');
        let offset = circumference - (percentage / 100) * circumference;
        
        circle.style.strokeDashoffset = offset;
        text.textContent = percentage + '%';
        countText.textContent = completedCount + '/' + totalEvaluations;
    </script>
        
    
        <script>
    
            const menuBtn = document.getElementById('menuBtn');
            const sideNav = document.getElementById('sideNav');
    
            menuBtn.addEventListener('click', () => {
                sideNav.classList.toggle('hidden');
            });
        </script>

    <!-- Include your scripts -->
    <script src="https://kit.fontawesome.com/ecd4bb53a4.js" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add the new script for date and time update -->
    <script>
        // Function to update date and time
        function updateDateTime() {
            var now = new Date();
            var options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true
            };
            var datetimeString = now.toLocaleString('en-US', options);
            document.getElementById('datetime').textContent = datetimeString;
        }

        // Update date and time every second
        setInterval(updateDateTime, 1000);

        // Modal script
        document.addEventListener('DOMContentLoaded', function() {
            const removePeerButton = document.getElementById('RemovePeerButton');
            const clearPeerModal = document.getElementById('ClearPeerModal');
            const cancelModalButton = document.getElementById('CancelModalButton');

            removePeerButton.addEventListener('click', function() {
                clearPeerModal.classList.remove('hidden');
            });

            cancelModalButton.addEventListener('click', function() {
                clearPeerModal.classList.add('hidden');
            });
        });
    </script>
</body>

@include('partials.footer')
@endauth
