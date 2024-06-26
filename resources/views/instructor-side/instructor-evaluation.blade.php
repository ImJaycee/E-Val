@auth('instructors')

@php
    $title = 'E-Val-Evaluation';
    $array = ['title' => $title];
    $instructor_id = session('instructor_id');
@endphp

@include('partials.header-instructor')
@include('partials.semester')

<body class="bg-gray-200">

<x-nav-instructor/> <!--Include nav and sidebar-->
<x-messages/>
<div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">
    <!-- Main Container -->
 
    <div class="lg:flex gap-4 items-stretch">
        <!-- White Box -->
        <div class="bg-white p-4 rounded-lg xs:mb-4 max-w-full shadow-md lg:w-[100%]">
            <!-- Small Boxes -->
            <div class="block justify-center h-full">
                <h3 class="text-xl font-bold text-gray-700">
                    Evaluate the Instructors!
                </h3>
                <p class="text-md font-bold text-gray-600">
                    <p class="text-gray-600">
                        <i>DATA PRIVACY NOTICE</i>: <br>
                        I express my consent for the DHVSU - Lubao Campus to collect, record, organize, update or modify, retrieve, 
                        consult, use, consolidate, block, erase or destruct my personal data as part of my information.<br>
                        
                        I hereby affirm my right to be informed, object to processing, access and rectify, suspend or withdraw 
                        my personal data, and be indemnified in case of damages pursuant to the provisions of the Republic 
                        Act No. 10173 of the Philippines, Data Privacy Act of 2012 and its corresponding Implementing Rules 
                        and Regulations.
                    </p> <br>  
                    <i class="font-normal text-gray-600">
                        Based on your evaluation, we can improve the quality of teaching. Thank you for your input!
                    </i> <br>               
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg p-4 shadow-md my-4">
       
        <div class="grid lg:grid-cols-3 grid-cols-2 gap-4">
         
            @foreach ($AllPeers as $peer)
                <div class="bg-gray-200 p-2 rounded-lg flex flex-col items-center justify-center">
                    <img src="storage/images/test-profile.png" alt="Instructor 1" class="w-16 h-16 rounded-full mb-1">
                    <p class="text-xs font-semibold text-gray-600"></p>
                    <p class="text-sm font-semibold text-gray-700">{{$peer['peerName']}}</p>
                    @if ($peer['status'] == 'Not submitted')
                            @if(session('eval_status_p2p') == 'open')
                                <button class="bg-green-700 hover:bg-green-600 text-white px-2 py-1 rounded-md mt-1 evaluate-button" onclick="openModal('{{ $peer['peerID'] }}')">Evaluate</button>
                            @elseif(session('eval_status_p2p') == 'close')
                                <button class="bg-red-900 text-white px-2 py-1 rounded-md mt-1 evaluate-button" disabled><i class="fas fa-lock"></i> Close</button>
                            @endif
                    @else
                            <button class="bg-green-800 text-white px-2 py-1 rounded-md mt-1 evaluate-button min-w-20" disabled><i class="fas fa-check"></i></button>
                    @endif
                   
                </div>


                <!-- Modal -->
                <div id="evaluationFormModal{{$peer['peerID']}}" class="fixed z-10 inset-0 overflow-y-auto hidden">
                    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <!-- Modal content -->
                        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full md:max-w-full" style="width: 99%">
                            <div class="px-4 pt-5 pb-4 sm:p-6">
                                <h3 class="text-lg font-bold text-gray-700">Evaluate Instructor: <span><i>{{$peer['peerName']}}</i></span></h3>
                                <p class="text-gray-500 font-semibold">
                                    RATING SCALE :
                                    5 – Outstanding	|				
                                    4 – Very Satisfactory |		            
                                    3 – Satisfactory |
                                    2 – Fair |
                                    1 – Unsatisfactory
                                </p>
                                <!-- Form -->
                                <form action="{{ route('instructor.SubmitEvaluation') }}" method="POST" class="mt-4">
                                    @csrf
                                    <!-- Questions (replace with actual questions) -->
                                    <input type="text" name="instructor_id" value="{{$peer['peerID']}}" class="hidden">
                                    <input type="text" name="evaluator_id" value="{{$instructor_id}}" class="hidden">
                                    <input type="text" name="semester" value="{{ getCurrentSemester() }}" class="hidden">
                                    <input type="text" name="A_Y" value="{{ getCurrentAcademicYear() }}" class="hidden">
                                    <h3 class="text-gray-600 font-bold">A.   Personal Qualities</h3>
                                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-200 p-4 rounded">
                                        <!-- Question -->
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">1. Enthusiastic to work</label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="a_1" id="a1_1" value="1" class="mr-1">
                                                <label for="a1_1" class="mr-2">1</label>
                                                <input type="radio" name="a_1" id="a1_2" value="2" class="mr-1">
                                                <label for="a1_2" class="mr-2">2</label>
                                                <input type="radio" name="a_1" id="a1_3" value="3" class="mr-1">
                                                <label for="a1_3" class="mr-2">3</label>
                                                <input type="radio" name="a_1" id="a1_4" value="4" class="mr-1">
                                                <label for="a1_4" class="mr-2">4</label>
                                                <input type="radio" name="a_1" id="a1_5" value="5" class="mr-1">
                                                <label for="a1_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">2. Well-groomed and properly dressed</label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="a_2" id="a2_1" value="1" class="mr-1">
                                                <label for="a2_1" class="mr-2">1</label>
                                                <input type="radio" name="a_2" id="a2_2" value="2" class="mr-1">
                                                <label for="a2_2" class="mr-2">2</label>
                                                <input type="radio" name="a_2" id="a2_3" value="3" class="mr-1">
                                                <label for="a2_3" class="mr-2">3</label>
                                                <input type="radio" name="a_2" id="a2_4" value="4" class="mr-1">
                                                <label for="a2_4" class="mr-2">4</label>
                                                <input type="radio" name="a_2" id="a2_5" value="5" class="mr-1">
                                                <label for="a2_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">3. Resourceful and has initiative</label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="a_3" id="a3_1" value="1" class="mr-1">
                                                <label for="a3_1" class="mr-2">1</label>
                                                <input type="radio" name="a_3" id="a3_2" value="2" class="mr-1">
                                                <label for="a3_2" class="mr-2">2</label>
                                                <input type="radio" name="a_3" id="a3_3" value="3" class="mr-1">
                                                <label for="a3_3" class="mr-2">3</label>
                                                <input type="radio" name="a_3" id="a3_4" value="4" class="mr-1">
                                                <label for="a3_4" class="mr-2">4</label>
                                                <input type="radio" name="a_3" id="a3_5" value="5" class="mr-1">
                                                <label for="a3_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">4. Productive and output oriented</label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="a_4" id="a4_1" value="1" class="mr-1">
                                                <label for="a4_1" class="mr-2">1</label>
                                                <input type="radio" name="a_4" id="a4_2" value="2" class="mr-1">
                                                <label for="a4_2" class="mr-2">2</label>
                                                <input type="radio" name="a_4" id="a4_3" value="3" class="mr-1">
                                                <label for="a4_3" class="mr-2">3</label>
                                                <input type="radio" name="a_4" id="a4_4" value="4" class="mr-1">
                                                <label for="a4_4" class="mr-2">4</label>
                                                <input type="radio" name="a_4" id="a4_5" value="5" class="mr-1">
                                                <label for="a4_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">5.  Fair and firm in decision making
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="a_5" id="a5_1" value="1" class="mr-1">
                                                <label for="a5_1" class="mr-2">1</label>
                                                <input type="radio" name="a_5" id="a5_2" value="2" class="mr-1">
                                                <label for="a5_2" class="mr-2">2</label>
                                                <input type="radio" name="a_5" id="a5_3" value="3" class="mr-1">
                                                <label for="a5_3" class="mr-2">3</label>
                                                <input type="radio" name="a_5" id="a5_4" value="4" class="mr-1">
                                                <label for="a5_4" class="mr-2">4</label>
                                                <input type="radio" name="a_5" id="a5_5" value="5" class="mr-1">
                                                <label for="a5_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">6.	Honest and trustworthy
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="a_6" id="a6_1" value="1" class="mr-1">
                                                <label for="a6_1" class="mr-2">1</label>
                                                <input type="radio" name="a_6" id="a6_2" value="2" class="mr-1">
                                                <label for="a6_2" class="mr-2">2</label>
                                                <input type="radio" name="a_6" id="a6_3" value="3" class="mr-1">
                                                <label for="a6_3" class="mr-2">3</label>
                                                <input type="radio" name="a_6" id="a6_4" value="4" class="mr-1">
                                                <label for="a6_4" class="mr-2">4</label>
                                                <input type="radio" name="a_6" id="a6_5" value="5" class="mr-1">
                                                <label for="a6_5">5</label>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="text-gray-600 font-bold">B. Interpersonal Relationship</h3>
                                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-200 p-4 rounded">
                                        <!-- Question -->
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">1.	Shows interest to co-workers and flexible in different situations
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="b_1" id="b1_1" value="1" class="mr-1">
                                                <label for="b1_1" class="mr-2">1</label>
                                                <input type="radio" name="b_1" id="b1_2" value="2" class="mr-1">
                                                <label for="b1_2" class="mr-2">2</label>
                                                <input type="radio" name="b_1" id="b1_3" value="3" class="mr-1">
                                                <label for="b1_3" class="mr-2">3</label>
                                                <input type="radio" name="b_1" id="b1_4" value="4" class="mr-1">
                                                <label for="b1_4" class="mr-2">4</label>
                                                <input type="radio" name="b_1" id="b1_5" value="5" class="mr-1">
                                                <label for="b1_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">2.	Pleasant and sincere
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="b_2" id="b2_1" value="1" class="mr-1">
                                                <label for="b2_1" class="mr-2">1</label>
                                                <input type="radio" name="b_2" id="b2_2" value="2" class="mr-1">
                                                <label for="b2_2" class="mr-2">2</label>
                                                <input type="radio" name="b_2" id="b2_3" value="3" class="mr-1">
                                                <label for="b2_3" class="mr-2">3</label>
                                                <input type="radio" name="b_2" id="b2_4" value="4" class="mr-1">
                                                <label for="b2_4" class="mr-2">4</label>
                                                <input type="radio" name="b_2" id="b2_5" value="5" class="mr-1">
                                                <label for="b2_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">3.	Observes confidentiality
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="b_3" id="b3_1" value="1" class="mr-1">
                                                <label for="b3_1" class="mr-2">1</label>
                                                <input type="radio" name="b_3" id="b3_2" value="2" class="mr-1">
                                                <label for="b3_2" class="mr-2">2</label>
                                                <input type="radio" name="b_3" id="b3_3" value="3" class="mr-1">
                                                <label for="b3_3" class="mr-2">3</label>
                                                <input type="radio" name="b_3" id="b3_4" value="4" class="mr-1">
                                                <label for="b3_4" class="mr-2">4</label>
                                                <input type="radio" name="b_3" id="b3_5" value="5" class="mr-1">
                                                <label for="b3_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">4. Appreciates colleague's good
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="b_4" id="b4_1" value="1" class="mr-1">
                                                <label for="b4_1" class="mr-2">1</label>
                                                <input type="radio" name="b_4" id="b4_2" value="2" class="mr-1">
                                                <label for="b4_2" class="mr-2">2</label>
                                                <input type="radio" name="b_4" id="b4_3" value="3" class="mr-1">
                                                <label for="b4_3" class="mr-2">3</label>
                                                <input type="radio" name="b_4" id="b4_4" value="4" class="mr-1">
                                                <label for="b4_4" class="mr-2">4</label>
                                                <input type="radio" name="b_4" id="b4_5" value="5" class="mr-1">
                                                <label for="b4_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">5.	Good listener
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="b_5" id="b5_1" value="1" class="mr-1">
                                                <label for="b5_1" class="mr-2">1</label>
                                                <input type="radio" name="b_5" id="b5_2" value="2" class="mr-1">
                                                <label for="b5_2" class="mr-2">2</label>
                                                <input type="radio" name="b_5" id="b5_3" value="3" class="mr-1">
                                                <label for="b5_3" class="mr-2">3</label>
                                                <input type="radio" name="b_5" id="b5_4" value="4" class="mr-1">
                                                <label for="b5_4" class="mr-2">4</label>
                                                <input type="radio" name="b_5" id="b5_5" value="5" class="mr-1">
                                                <label for="b5_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">6.	Shares expertise and professional knowledge with colleagues
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="b_6" id="b6_1" value="1" class="mr-1">
                                                <label for="b6_1" class="mr-2">1</label>
                                                <input type="radio" name="b_6" id="b6_2" value="2" class="mr-1">
                                                <label for="b6_2" class="mr-2">2</label>
                                                <input type="radio" name="b_6" id="b6_3" value="3" class="mr-1">
                                                <label for="b6_3" class="mr-2">3</label>
                                                <input type="radio" name="b_6" id="b6_4" value="4" class="mr-1">
                                                <label for="b6_4" class="mr-2">4</label>
                                                <input type="radio" name="b_6" id="b6_5" value="5" class="mr-1">
                                                <label for="b6_5">5</label>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="text-gray-600 font-bold">C.	Ethical Behavior</h3>
                                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-200 p-4 rounded">
                                        <!-- Question -->
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">1.	Open-minded, accepts criticism in good spirit
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="c_1" id="c1_1" value="1" class="mr-1">
                                                <label for="c1_1" class="mr-2">1</label>
                                                <input type="radio" name="c_1" id="c1_2" value="2" class="mr-1">
                                                <label for="c1_2" class="mr-2">2</label>
                                                <input type="radio" name="c_1" id="c1_3" value="3" class="mr-1">
                                                <label for="c1_3" class="mr-2">3</label>
                                                <input type="radio" name="c_1" id="c1_4" value="4" class="mr-1">
                                                <label for="c1_4" class="mr-2">4</label>
                                                <input type="radio" name="c_1" id="c1_5" value="5" class="mr-1">
                                                <label for="c1_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">2.	Committed to work
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="c_2" id="c2_1" value="1" class="mr-1">
                                                <label for="c2_1" class="mr-2">1</label>
                                                <input type="radio" name="c_2" id="c2_2" value="2" class="mr-1">
                                                <label for="c2_2" class="mr-2">2</label>
                                                <input type="radio" name="c_2" id="c2_3" value="3" class="mr-1">
                                                <label for="c2_3" class="mr-2">3</label>
                                                <input type="radio" name="c_2" id="c2_4" value="4" class="mr-1">
                                                <label for="c2_4" class="mr-2">4</label>
                                                <input type="radio" name="c_2" id="c2_5" value="5" class="mr-1">
                                                <label for="c2_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">3.	Accepts additional assignments and works religiously on them
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="c_3" id="c3_1" value="1" class="mr-1">
                                                <label for="c3_1" class="mr-2">1</label>
                                                <input type="radio" name="c_3" id="c3_2" value="2" class="mr-1">
                                                <label for="c3_2" class="mr-2">2</label>
                                                <input type="radio" name="c_3" id="c3_3" value="3" class="mr-1">
                                                <label for="c3_3" class="mr-2">3</label>
                                                <input type="radio" name="c_3" id="c3_4" value="4" class="mr-1">
                                                <label for="c3_4" class="mr-2">4</label>
                                                <input type="radio" name="c_3" id="c3_5" value="5" class="mr-1">
                                                <label for="c3_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">4. Fair and objective in dealing with others
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="c_4" id="c4_1" value="1" class="mr-1">
                                                <label for="c4_1" class="mr-2">1</label>
                                                <input type="radio" name="c_4" id="c4_2" value="2" class="mr-1">
                                                <label for="c4_2" class="mr-2">2</label>
                                                <input type="radio" name="c_4" id="c4_3" value="3" class="mr-1">
                                                <label for="c4_3" class="mr-2">3</label>
                                                <input type="radio" name="c_4" id="c4_4" value="4" class="mr-1">
                                                <label for="c4_4" class="mr-2">4</label>
                                                <input type="radio" name="c_4" id="c4_5" value="5" class="mr-1">
                                                <label for="c4_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">5.	Is friendly and courteous in dealing with colleagues
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="c_5" id="c5_1" value="1" class="mr-1">
                                                <label for="c5_1" class="mr-2">1</label>
                                                <input type="radio" name="c_5" id="c5_2" value="2" class="mr-1">
                                                <label for="c5_2" class="mr-2">2</label>
                                                <input type="radio" name="c_5" id="c5_3" value="3" class="mr-1">
                                                <label for="c5_3" class="mr-2">3</label>
                                                <input type="radio" name="c_5" id="c5_4" value="4" class="mr-1">
                                                <label for="c5_4" class="mr-2">4</label>
                                                <input type="radio" name="c_5" id="c5_5" value="5" class="mr-1">
                                                <label for="c5_5">5</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                                            <label class="block text-sm font-semibold">6.	Considerate in the use of equipment, physical facilities and instructional materials
                                            </label>
                                            <!-- Radio inputs -->
                                            <div class="flex items-center justify-center space-x-5">
                                                <input type="radio" name="c_6" id="c6_1" value="1" class="mr-1">
                                                <label for="c6_1" class="mr-2">1</label>
                                                <input type="radio" name="c_6" id="c6_2" value="2" class="mr-1">
                                                <label for="c6_2" class="mr-2">2</label>
                                                <input type="radio" name="c_6" id="c6_3" value="3" class="mr-1">
                                                <label for="c6_3" class="mr-2">3</label>
                                                <input type="radio" name="c_6" id="c6_4" value="4" class="mr-1">
                                                <label for="c6_4" class="mr-2">4</label>
                                                <input type="radio" name="c_6" id="c6_5" value="5" class="mr-1">
                                                <label for="c6_5">5</label>
                                            </div>
                                        </div>  
                                        <!-- Repeat for other questions -->
                                    </div>
                                    
                                    <!-- Comments -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold">Comments</label>
                                        <textarea name="comments" class="w-full border border-gray-300 rounded-md p-2"></textarea>
                                    </div>
                                    
                                    <!-- Submit and close buttons -->
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-4 py-2 mr-2 bg-green-500 text-white rounded-md hover:bg-green-600" >Submit</button>
                                        <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400" id="closeFormModal" onclick="closeModal('{{ $peer['peerID'] }}')">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
            @endforeach
           
        </div>

</div>



    <!-- Script  -->
    <script>
        function openModal(peerID) {
            var modal = document.getElementById('evaluationFormModal' + peerID);
            modal.classList.remove('hidden');
        }
    
        function closeModal(peerID) {
            var modal = document.getElementById('evaluationFormModal' + peerID);
            modal.classList.add('hidden');
        }
    </script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('input[type="radio"]');
        const starLabels = document.querySelectorAll('label[for^="star"]');
    
        stars.forEach((star, index) => {
            starLabels[index].addEventListener('click', () => {
                starLabels.forEach((label, idx) => {
                    if (idx <= index) {
                        label.style.color = '#fbbf24'; // Yellow color for filled star
                    } else {
                        label.style.color = '#ddd'; // Gray color for unfilled star
                    }
                });
                star.checked = true;
            });
        });
    });
</script>
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
