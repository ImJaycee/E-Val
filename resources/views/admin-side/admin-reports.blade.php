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
    <!-- Main Container -->
    <div class="lg:flex gap-4 items-stretch">
        <!-- White Box -->
        <div class="bg-white p-4 rounded-lg xs:mb-4 max-w-full shadow-md lg:w-[100%]">
            <!-- Small Boxes -->
            <div class="block justify-center h-full">
                <h3 class="text-xl font-bold text-gray-700">
                    <i>Instructor Rating and Ranking Summary</i>!
                </h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg p-4 shadow-md my-4">
        <!-- Header -->
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Evaluation Summary</h1>
    
        <!-- Responsive container for both tables -->
        <div class="flex flex-wrap -mx-2">
            <!-- Left side: Student Evaluation -->
            <div class="w-full lg:w-1/2 px-2 mb-4 lg:mb-0">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Student Evaluation</h2>
                <div class="overflow-x-auto" style="max-height: 445px">
                    <table id="studentEvalTable" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Academic year</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Sample Data -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2024-2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2nd</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    <form action="{{ route('view.summary') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="text" name="A_Y" id="A_Y" value="2024-2025" class="hidden">
                                        <input type="text" name="semester" id="semester" value="2nd" class="hidden">
                                        <button class="px-4 py-2 bg-green-500 text-white rounded">View Summary</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2024-2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">1st</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    <form action="{{ route('view.summary') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="text" name="A_Y" id="A_Y" value="2024-2025" class="hidden">
                                        <input type="text" name="semester" id="semester" value="1st" class="hidden">
                                        <button class="px-4 py-2 bg-green-500 text-white rounded">View Summary</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2023-2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2nd</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    <form action="{{ route('view.summary') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="text" name="A_Y" id="A_Y" value="2023-2024" class="hidden">
                                        <input type="text" name="semester" id="semester" value="2nd" class="hidden">
                                        <button class="px-4 py-2 bg-green-500 text-white rounded">View Summary</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2023-2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">1st</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    <form action="{{ route('view.summary') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="text" name="A_Y" id="A_Y" value="2023-2024" class="hidden">
                                        <input type="text" name="semester" id="semester" value="1st" class="hidden">
                                        <button class="px-4 py-2 bg-green-500 text-white rounded">View Summary</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- More rows can be added dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
    
            <!-- Right side: Peer Evaluation -->
            <div class="w-full lg:w-1/2 px-2">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Peer Evaluation</h2>
                <div class="overflow-x-auto" style="max-height: 445px">
                    <table id="peerEvalTable" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Academic year</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Sample Data -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2024-2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2nd</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    <form action="{{ route('view.peer_summary') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="text" name="A_Y" id="A_Y" value="2024-2025" class="hidden">
                                        <input type="text" name="semester" id="semester" value="2nd" class="hidden">
                                        <button class="px-4 py-2 bg-blue-500 text-white rounded">View Peer Summary</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2024-2025</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">1st</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    <form action="{{ route('view.peer_summary') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="text" name="A_Y" id="A_Y" value="2024-2025" class="hidden">
                                        <input type="text" name="semester" id="semester" value="1st" class="hidden">
                                        <button class="px-4 py-2 bg-blue-500 text-white rounded">View Peer Summary</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2023-2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2nd</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    <form action="{{ route('view.peer_summary') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="text" name="A_Y" id="A_Y" value="2023-2024" class="hidden">
                                        <input type="text" name="semester" id="semester" value="2nd" class="hidden">
                                        <button class="px-4 py-2 bg-blue-500 text-white rounded">View Peer Summary</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">2023-2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">1st</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    <form action="{{ route('view.peer_summary') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="text" name="A_Y" id="A_Y" value="2023-2024" class="hidden">
                                        <input type="text" name="semester" id="semester" value="1st" class="hidden">
                                        <button class="px-4 py-2 bg-blue-500 text-white rounded">View Peer Summary</button>
                                    </form>
                                </td>
                            </tr>
    
                            <!-- More rows can be added dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    

</div>
    

</body>

@include('partials.footer')
@endauth
