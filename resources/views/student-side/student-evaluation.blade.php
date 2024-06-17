@auth('students')

@php
    $title = 'E-Val-Evaluation';
    $array = ['title' => $title];
    $student_id = session('student_id');
    $eval_token = session('eval_token');
@endphp

@include('partials.header-student')
@include('partials.semester')

<body class="bg-gray-200">

<x-nav-student/> <!--Include nav and sidebar-->
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
        <!-- Sample instructor card, repeat this for each instructor -->                
        @if(empty($allSubjectsEnrolled))
            <div class="bg-gray-200 p-2 rounded-lg flex max-w-60 mx-auto flex-col items-center justify-center text-gray-800">
                <h3>No Subject Enrolled</h3>
            </div>
        @endif 
       
        <div class="grid lg:grid-cols-4 grid-cols-2 gap-4">     
            @foreach ($allSubjectsEnrolled as $subject)
            
                    <div class="bg-gray-200 p-2 rounded-lg flex flex-col items-center justify-center" >
                        @if ($subject['pfp'])
                        <img src="{{ asset('storage/images/pfp/'.$subject['pfp']) }}" alt="" class="w-16 h-16 rounded-full mb-1">
                        @else
                        <img src="{{'storage/images/test-profile.png' }}" alt="{{ $subject['instructor_name'] }}" class="w-16 h-16 rounded-full mb-1">
                        @endif
                        <p class="text-xs font-semibold text-gray-600">{{ $subject['subject_code'] }}</p>
                        <p class="text-sm font-semibold text-gray-700 mt-1">{{ $subject['instructor_name'] }}</p>
                        @if ($subject['instructor_id'] && $subject['status'] == 'Not submitted')
                            <button class="bg-green-700 hover:bg-green-600 text-white px-2 py-1 rounded-md mt-1 evaluate-button" onclick="openModal('{{ $subject['subject_code'] }}')">Evaluate</button>
                        @elseif ($subject['instructor_id'] == null)
                            <button class="bg-green-700 text-white px-2 py-1 rounded-md mt-1 evaluate-button min-w-20" disabled><i class="fas fa-question"></i></button>
                        @else
                            <button class="bg-green-700 text-white px-2 py-1 rounded-md mt-1 evaluate-button min-w-20" disabled><i class="fas fa-check"></i></button>
                        @endif
   
                        <x-errors/> 
                    </div>

            <!-- Modal -->
            <div id="evaluationFormModal{{$subject['subject_code']}}" class="fixed z-10 inset-0 overflow-y-auto hidden">
                <div class="flex items-center justify-center min-h-screen p-4 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <!-- Modal content -->
                    <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full md:max-w-full" style="width: 99%">
                        <div class="px-4 pt-5 pb-4 sm:p-6">
                            <h3 class="text-lg font-bold text-gray-700">Evaluate Instructor: <span><i>{{ $subject['instructor_name'] }}</i></span></h3>
                            <p class="text-gray-500 font-semibold">
                                RATING SCALE :
                                5 – Outstanding	|				
                                4 – Very Satisfactory |		            
                                3 – Satisfactory |
                                2 – Fair |
                                1 – Unsatisfactory
                            </p>
                            <!-- Form -->
                            <form action="{{ route('student.SubmitEvaluation') }}" method="POST" class="mt-4">
                                <!-- Questions (replace with actual questions) -->
                                @csrf
                                <input type="text" name="instructor_id" value="{{ $subject['instructor_id'] }}" class="hidden">
                                <input type="text" name="eval_token" value="{{$eval_token}}" class="hidden">
                                {{-- <input type="text" name="section" value="{{ $student->program }} {{ $student->year }}{{ $student->section }}" class=""> --}}
                                <input type="text" name="subject_code" value="{{ $subject['subject_code'] }}" class="hidden" >
                                <input type="text" name="semester" value="{{ getCurrentSemester() }}" class="hidden">
                                <input type="text" name="A_Y" value="{{ getCurrentAcademicYear() }}" class="hidden">
                                <h3 class="text-gray-600 font-bold">I.   Course Planning/Preparation</h3>
                                <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-200 p-4 rounded">
                                    <!-- Question -->
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">1. Provides each student a copy of the syllabus and clearly explains its content</label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="I-1" id="1_q1" value="1" class="mr-1">
                                            <label for="1_q1" class="mr-2">1</label>
                                            <input type="radio" name="I-1" id="1_q2" value="2" class="mr-1">
                                            <label for="1_q2" class="mr-2">2</label>
                                            <input type="radio" name="I-1" id="1_q3" value="3" class="mr-1">
                                            <label for="1_q3" class="mr-2">3</label>
                                            <input type="radio" name="I-1" id="1_q4" value="4" class="mr-1">
                                            <label for="1_q4" class="mr-2">4</label>
                                            <input type="radio" name="I-1" id="1_q5" value="5" class="mr-1">
                                            <label for="1_q5">5</label>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">2. Plans lessons effectively according to the objectives of the course</label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="I-2" id="2_q1" value="1" class="mr-1">
                                            <label for="2_q1" class="mr-2">1</label>
                                            <input type="radio" name="I-2" id="2_q2" value="2" class="mr-1">
                                            <label for="2_q2" class="mr-2">2</label>
                                            <input type="radio" name="I-2" id="2_q3" value="3" class="mr-1">
                                            <label for="2_q3" class="mr-2">3</label>
                                            <input type="radio" name="I-2" id="2_q4" value="4" class="mr-1">
                                            <label for="2_q4" class="mr-2">4</label>
                                            <input type="radio" name="I-2" id="2_q5" value="5" class="mr-1">
                                            <label for="2_q5">5</label>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">3. Explains subject requirements properly and provides reasonable time for their completion</label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="I-3" id="3_q1" value="1" class="mr-1">
                                            <label for="3_q1" class="mr-2">1</label>
                                            <input type="radio" name="I-3" id="3_q2" value="2" class="mr-1">
                                            <label for="3_q2" class="mr-2">2</label>
                                            <input type="radio" name="I-3" id="3_q3" value="3" class="mr-1">
                                            <label for="3_q3" class="mr-2">3</label>
                                            <input type="radio" name="I-3" id="3_q4" value="4" class="mr-1">
                                            <label for="3_q4" class="mr-2">4</label>
                                            <input type="radio" name="I-3" id="3_q5" value="5" class="mr-1">
                                            <label for="3_q5">5</label>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="text-gray-600 font-bold">II.	Instructional Delivery</h3>
                                <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-200 p-4 rounded">
                                    
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">1.	Demonstrates mastery of the subject matter
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="II-1" id="4_q1" value="1" class="mr-1">
                                            <label for="4_q1" class="mr-2">1</label>
                                            <input type="radio" name="II-1" id="4_q2" value="2" class="mr-1">
                                            <label for="4_q2" class="mr-2">2</label>
                                            <input type="radio" name="II-1" id="4_q3" value="3" class="mr-1">
                                            <label for="4_q3" class="mr-2">3</label>
                                            <input type="radio" name="II-1" id="4_q4" value="4" class="mr-1">
                                            <label for="4_q4" class="mr-2">4</label>
                                            <input type="radio" name="II-1" id="4_q5" value="5" class="mr-1">
                                            <label for="4_q5">5</label>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">2.	Motivates students to think critically and creatively
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="II-2" id="5_q1" value="1" class="mr-1">
                                            <label for="5_q1" class="mr-2">1</label>
                                            <input type="radio" name="II-2" id="5_q2" value="2" class="mr-1">
                                            <label for="5_q2" class="mr-2">2</label>
                                            <input type="radio" name="II-2" id="5_q3" value="3" class="mr-1">
                                            <label for="5_q3" class="mr-2">3</label>
                                            <input type="radio" name="II-2" id="5_q4" value="4" class="mr-1">
                                            <label for="5_q4" class="mr-2">4</label>
                                            <input type="radio" name="II-2" id="5_q5" value="5" class="mr-1">
                                            <label for="5_q5">5</label>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">3.	Has a good command of the language of instruction with well modulated voice that can be understood by all students
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="II-3" id="6_q1" value="1" class="mr-1">
                                            <label for="6_q1" class="mr-2">1</label>
                                            <input type="radio" name="II-3" id="6_q2" value="2" class="mr-1">
                                            <label for="6_q2" class="mr-2">2</label>
                                            <input type="radio" name="II-3" id="6_q3" value="3" class="mr-1">
                                            <label for="6_q3" class="mr-2">3</label>
                                            <input type="radio" name="II-3" id="6_q4" value="4" class="mr-1">
                                            <label for="6_q4" class="mr-2">4</label>
                                            <input type="radio" name="II-3" id="6_q5" value="5" class="mr-1">
                                            <label for="6_q5">5</label>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">4.	Comes to class on time and makes productive use of allotted time for the subject
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="II-4" id="7_q1" value="1" class="mr-1">
                                            <label for="7_q1" class="mr-2">1</label>
                                            <input type="radio" name="II-4" id="7_q2" value="2" class="mr-1">
                                            <label for="7_q2" class="mr-2">2</label>
                                            <input type="radio" name="II-4" id="7_q3" value="3" class="mr-1">
                                            <label for="7_q3" class="mr-2">3</label>
                                            <input type="radio" name="II-4" id="7_q4" value="4" class="mr-1">
                                            <label for="7_q4" class="mr-2">4</label>
                                            <input type="radio" name="II-4" id="7_q5" value="5" class="mr-1">
                                            <label for="7_q5">5</label>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="text-gray-600 font-bold">III.	Assessment of Student Learning</h3>
                                <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-200 p-4 rounded">
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">1.	Uses appropriate assessment strategies to evaluate learning
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="III-1" id="8_q1" value="1" class="mr-1">
                                            <label for="8_q1" class="mr-2">1</label>
                                            <input type="radio" name="III-1" id="8_q2" value="2" class="mr-1">
                                            <label for="8_q2" class="mr-2">2</label>
                                            <input type="radio" name="III-1" id="8_q3" value="3" class="mr-1">
                                            <label for="8_q3" class="mr-2">3</label>
                                            <input type="radio" name="III-1" id="8_q4" value="4" class="mr-1">
                                            <label for="8_q4" class="mr-2">4</label>
                                            <input type="radio" name="III-1" id="8_q5" value="5" class="mr-1">
                                            <label for="8_q5">5</label>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">2.	Is fair and objective in giving grades
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="III-2" id="9_q1" value="1" class="mr-1">
                                            <label for="9_q1" class="mr-2">1</label>
                                            <input type="radio" name="III-2" id="9_q2" value="2" class="mr-1">
                                            <label for="9_q2" class="mr-2">2</label>
                                            <input type="radio" name="III-2" id="9_q3" value="3" class="mr-1">
                                            <label for="9_q3" class="mr-2">3</label>
                                            <input type="radio" name="III-2" id="9_q4" value="4" class="mr-1">
                                            <label for="9_q4" class="mr-2">4</label>
                                            <input type="radio" name="III-2" id="9_q5" value="5" class="mr-1">
                                            <label for="9_q5">5</label>
                                        </div>
                                    </div>
                                    <!-- Repeat for other questions -->
                                </div>
                                <h3 class="text-gray-600 font-bold">IV.	Classroom Management</h3>
                                <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-200 p-4 rounded">
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">1.	Maintains order in the class
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="IV-1" id="10_q1" value="1" class="mr-1">
                                            <label for="10_q1" class="mr-2">1</label>
                                            <input type="radio" name="IV-1" id="10_q2" value="2" class="mr-1">
                                            <label for="10_q2" class="mr-2">2</label>
                                            <input type="radio" name="IV-1" id="10_q3" value="3" class="mr-1">
                                            <label for="10_q3" class="mr-2">3</label>
                                            <input type="radio" name="IV-1" id="10_q4" value="4" class="mr-1">
                                            <label for="10_q4" class="mr-2">4</label>
                                            <input type="radio" name="IV-1" id="10_q5" value="5" class="mr-1">
                                            <label for="10_q5">5</label>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">2.	Is approachable but firm in implementation of policies
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="IV-2" id="11_q1" value="1" class="mr-1">
                                            <label for="11_q1" class="mr-2">1</label>
                                            <input type="radio" name="IV-2" id="11_q2" value="2" class="mr-1">
                                            <label for="11_q2" class="mr-2">2</label>
                                            <input type="radio" name="IV-2" id="11_q3" value="3" class="mr-1">
                                            <label for="11_q3" class="mr-2">3</label>
                                            <input type="radio" name="IV-2" id="11_q4" value="4" class="mr-1">
                                            <label for="11_q4" class="mr-2">4</label>
                                            <input type="radio" name="IV-2" id="11_q5" value="5" class="mr-1">
                                            <label for="11_q5">5</label>
                                        </div>
                                    </div>
                                    <!-- Repeat for other questions -->
                                </div>
                                <h3 class="text-gray-600 font-bold">V.	Personality and Poise</h3>
                                <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-200 p-4 rounded">
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">1.	Well groomed and has pleasing personality
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="V-1" id="12_q1" value="1" class="mr-1">
                                            <label for="12_q1" class="mr-2">1</label>
                                            <input type="radio" name="V-1" id="12_q2" value="2" class="mr-1">
                                            <label for="12_q2" class="mr-2">2</label>
                                            <input type="radio" name="V-1" id="12_q3" value="3" class="mr-1">
                                            <label for="12_q3" class="mr-2">3</label>
                                            <input type="radio" name="V-1" id="12_q4" value="4" class="mr-1">
                                            <label for="12_q4" class="mr-2">4</label>
                                            <input type="radio" name="V-1" id="12_q5" value="5" class="mr-1">
                                            <label for="12_q5">5</label>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">2.	Wears the prescribed uniform
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="V-2" id="13_q1" value="1" class="mr-1">
                                            <label for="13_q1" class="mr-2">1</label>
                                            <input type="radio" name="V-2" id="13_q2" value="2" class="mr-1">
                                            <label for="13_q2" class="mr-2">2</label>
                                            <input type="radio" name="V-2" id="13_q3" value="3" class="mr-1">
                                            <label for="13_q3" class="mr-2">3</label>
                                            <input type="radio" name="V-2" id="13_q4" value="4" class="mr-1">
                                            <label for="13_q4" class="mr-2">4</label>
                                            <input type="radio" name="V-2" id="13_q5" value="5" class="mr-1">
                                            <label for="13_q5">5</label>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 rounded p-2 shadow-xl">
                                        <label class="block text-sm font-semibold">3.	Has self-confidence and commands respect
                                        </label>
                                        <!-- Radio inputs -->
                                        <div class="flex items-center justify-center space-x-5">
                                            <input type="radio" name="V-3" id="14_q1" value="1" class="mr-1">
                                            <label for="14_q1" class="mr-2">1</label>
                                            <input type="radio" name="V-3" id="14_q2" value="2" class="mr-1">
                                            <label for="14_q2" class="mr-2">2</label>
                                            <input type="radio" name="V-3" id="14_q3" value="3" class="mr-1">
                                            <label for="14_q3" class="mr-2">3</label>
                                            <input type="radio" name="V-3" id="14_q4" value="4" class="mr-1">
                                            <label for="14_q4" class="mr-2">4</label>
                                            <input type="radio" name="V-3" id="14_q5" value="5" class="mr-1">
                                            <label for="14_q5">5</label>
                                        </div>
                                    </div>
                                    <!-- Repeat for other questions -->
                                </div>
                                
                                <!-- Comments -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold">Comments</label>
                                    <textarea name="comments" class="w-full border border-gray-300 rounded-md p-2" required autocorrect="off" autocomplete="off" spellcheck="false"></textarea>
                                </div>
                                
                                <!-- Submit and close buttons -->
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 mr-2 bg-green-500 text-white rounded-md hover:bg-green-600" >Submit</button>
                                    <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400" id="closeFormModal" onclick="closeModal('{{ $subject['subject_code'] }}')">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            @endforeach

            <!-- Sample instructor card, repeat this for each instructor -->
        </div>

</div>

<script>
    function openModal(subject_code) {
        var modal = document.getElementById('evaluationFormModal' + subject_code);
        modal.classList.remove('hidden');
    }

    function closeModal(subject_code) {
        var modal = document.getElementById('evaluationFormModal' + subject_code);
        modal.classList.add('hidden');
    }
</script>


    <!-- Script For modal too  -->
    {{-- <script>
        let subject_code_in;
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('evaluate-button')) {
                const subject_code = event.target.getAttribute('data-subject-code');
                subject_code_in = event.target.getAttribute('data-subject-code');
                if (subject_code) {
                    subject_code_in = subject_code;
                    const evaluationFormModal = document.getElementById('evaluationFormModal' + subject_code);
                    evaluationFormModal.classList.remove('hidden');
                }
            }
        });
    
        const closeFormModal = document.getElementById('closeFormModal');
        closeFormModal.addEventListener('click', () => {
            const evaluationFormModal = document.getElementById('evaluationFormModal'  + subject_code);
            evaluationFormModal.classList.add('hidden');
        });
    </script> --}}


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
