@auth('instructors')

@php
    $title = 'E-Val-Evaluation';
    $array = ['title' => $title];
    // $instructor_id = session('instructor_id');
@endphp

@include('partials.header-instructor')


<body class="bg-gray-200">

<x-nav-instructor/> <!--Include nav and sidebar-->

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
       
        <div class="grid lg:grid-cols-4 grid-cols-2 gap-4">
            <!-- Sample instructor card, repeat this for each instructor -->
            <div class="bg-gray-200 p-2 rounded-lg flex flex-col items-center justify-center">
                <img src="storage/images/test-profile.png" alt="Instructor 1" class="w-16 h-16 rounded-full mb-1">
                <p class="text-xs font-semibold text-gray-600">CAP323</p>
                <p class="text-sm font-semibold text-gray-700">Davemm Salalila</p>
                <button class="bg-green-700 hover:bg-green-600 text-white px-2 py-1 rounded-md mt-1" id="evaluateInstructor">Evaluate</button>
            </div>
            <div class="bg-gray-200 p-2 rounded-lg flex flex-col items-center justify-center">
                <img src="storage/images/test-profile.png" alt="Instructor 1" class="w-16 h-16 rounded-full mb-1">
                <p class="text-xs font-semibold text-gray-600">CAP323</p>
                <p class="text-sm font-semibold text-gray-700">Davemm Salalila</p>
                <button class="bg-green-700 hover:bg-green-600 text-white px-2 py-1 rounded-md mt-1" id="evaluateInstructor">Evaluate</button>
            </div>
            <div class="bg-gray-200 p-2 rounded-lg flex flex-col items-center justify-center">
                <img src="storage/images/test-profile.png" alt="Instructor 1" class="w-16 h-16 rounded-full mb-1">
                <p class="text-xs font-semibold text-gray-600">CAP323</p>
                <p class="text-sm font-semibold text-gray-700">Davemm Salalila</p>
                <button class="bg-green-700 hover:bg-green-600 text-white px-2 py-1 rounded-md mt-1" id="evaluateInstructor">Evaluate</button>
            </div>
            <div class="bg-gray-200 p-2 rounded-lg flex flex-col items-center justify-center">
                <img src="storage/images/test-profile.png" alt="Instructor 1" class="w-16 h-16 rounded-full mb-1">
                <p class="text-xs font-semibold text-gray-600">CAP323</p>
                <p class="text-sm font-semibold text-gray-700">Davemm Salalila</p>
                <button class="bg-green-700 hover:bg-green-600 text-white px-2 py-1 rounded-md mt-1" id="evaluateInstructor">Evaluate</button>
            </div>
            <div class="bg-gray-200 p-2 rounded-lg flex flex-col items-center justify-center">
                <img src="storage/images/test-profile.png" alt="Instructor 1" class="w-16 h-16 rounded-full mb-1">
                <p class="text-xs font-semibold text-gray-600">CAP323</p>
                <p class="text-sm font-semibold text-gray-700">Davemm Salalila</p>
                <button class="bg-green-700 hover:bg-green-600 text-white px-2 py-1 rounded-md mt-1" id="evaluateInstructor">Evaluate</button>
            </div>
            <div class="bg-gray-200 p-2 rounded-lg flex flex-col items-center justify-center">
                <img src="storage/images/test-profile.png" alt="Instructor 1" class="w-16 h-16 rounded-full mb-1">
                <p class="text-xs font-semibold text-gray-600">CAP323</p>
                <p class="text-sm font-semibold text-gray-700">Davemm Salalila</p>
                <button class="bg-green-700 hover:bg-green-600 text-white px-2 py-1 rounded-md mt-1" id="evaluateInstructor">Evaluate</button>
            </div>
            <div class="bg-gray-200 p-2 rounded-lg flex flex-col items-center justify-center">
                <img src="storage/images/test-profile.png" alt="Instructor 1" class="w-16 h-16 rounded-full mb-1">
                <p class="text-xs font-semibold text-gray-600">CAP323</p>
                <p class="text-sm font-semibold text-gray-700">Davemm Salalila</p>
                <button class="bg-green-700 hover:bg-green-600 text-white px-2 py-1 rounded-md mt-1" id="evaluateInstructor">Evaluate</button>
            </div>
            <div class="bg-gray-200 p-2 rounded-lg flex flex-col items-center justify-center">
                <img src="storage/images/test-profile.png" alt="Instructor 1" class="w-16 h-16 rounded-full mb-1">
                <p class="text-xs font-semibold text-gray-600">CAP323</p>
                <p class="text-sm font-semibold text-gray-700">Davemm Salalila</p>
                <button class="bg-green-700 hover:bg-green-600 text-white px-2 py-1 rounded-md mt-1" id="evaluateInstructor">Evaluate</button>
            </div>
            <!-- Sample instructor card, repeat this for each instructor -->
        </div>

</div>

<!-- Modal -->
<div id="evaluationFormModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- Modal content -->
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full md:max-w-full" style="width: 99%">
            <div class="px-4 pt-5 pb-4 sm:p-6">
                <h3 class="text-lg font-bold text-gray-700">Evaluate Instructor: <span><i>Davemm Salalila</i></span></h3>
                <p class="text-gray-500 font-semibold">
                    RATING SCALE :
                    5 – Outstanding	|				
                    4 – Very Satisfactory |		            
                    3 – Satisfactory |
                    2 – Fair |
                    1 – Unsatisfactory
                </p>
                <!-- Form -->
                <form action="#" method="POST" class="mt-4">
                    <!-- Questions (replace with actual questions) -->
                    
                    <h3 class="text-gray-600 font-bold">I.   Course Planning/Preparation</h3>
                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-200 p-4 rounded">
                        <!-- Question -->
                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                            <label class="block text-sm font-semibold">1. Provides each student a copy of the syllabus and clearly explains its content</label>
                            <!-- Radio inputs -->
                            <div class="flex items-center justify-center space-x-5">
                                <input type="radio" name="question1" id="q1_1" value="1" class="mr-1">
                                <label for="q1_1" class="mr-2">1</label>
                                <input type="radio" name="question1" id="q1_2" value="2" class="mr-1">
                                <label for="q1_2" class="mr-2">2</label>
                                <input type="radio" name="question1" id="q1_3" value="3" class="mr-1">
                                <label for="q1_3" class="mr-2">3</label>
                                <input type="radio" name="question1" id="q1_4" value="4" class="mr-1">
                                <label for="q1_4" class="mr-2">4</label>
                                <input type="radio" name="question1" id="q1_5" value="5" class="mr-1">
                                <label for="q1_5">5</label>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                            <label class="block text-sm font-semibold">2. Plans lessons effectively according to the objectives of the course</label>
                            <!-- Radio inputs -->
                            <div class="flex items-center justify-center space-x-5">
                                <input type="radio" name="question2" id="q2_1" value="1" class="mr-1">
                                <label for="q2_1" class="mr-2">1</label>
                                <input type="radio" name="question2" id="q2_2" value="2" class="mr-1">
                                <label for="q2_2" class="mr-2">2</label>
                                <input type="radio" name="question2" id="q2_3" value="3" class="mr-1">
                                <label for="q2_3" class="mr-2">3</label>
                                <input type="radio" name="question2" id="q2_4" value="4" class="mr-1">
                                <label for="q2_4" class="mr-2">4</label>
                                <input type="radio" name="question2" id="q2_5" value="5" class="mr-1">
                                <label for="q2_5">5</label>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                            <label class="block text-sm font-semibold">3. Explains subject requirements properly and provides reasonable time for their completion</label>
                            <!-- Radio inputs -->
                            <div class="flex items-center justify-center space-x-5">
                                <input type="radio" name="question3" id="q3_1" value="1" class="mr-1">
                                <label for="q3_1" class="mr-2">1</label>
                                <input type="radio" name="question3" id="q3_2" value="2" class="mr-1">
                                <label for="q3_2" class="mr-2">2</label>
                                <input type="radio" name="question3" id="q3_3" value="3" class="mr-1">
                                <label for="q3_3" class="mr-2">3</label>
                                <input type="radio" name="question3" id="q3_4" value="4" class="mr-1">
                                <label for="q3_4" class="mr-2">4</label>
                                <input type="radio" name="question3" id="q3_5" value="5" class="mr-1">
                                <label for="q3_5">5</label>
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
                                <input type="radio" name="question4" id="q4_1" value="1" class="mr-1">
                                <label for="q4_1" class="mr-2">1</label>
                                <input type="radio" name="question4" id="q4_2" value="2" class="mr-1">
                                <label for="q4_2" class="mr-2">2</label>
                                <input type="radio" name="question4" id="q4_3" value="3" class="mr-1">
                                <label for="q4_3" class="mr-2">3</label>
                                <input type="radio" name="question4" id="q4_4" value="4" class="mr-1">
                                <label for="q4_4" class="mr-2">4</label>
                                <input type="radio" name="question4" id="q4_5" value="5" class="mr-1">
                                <label for="q4_5">5</label>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                            <label class="block text-sm font-semibold">2.	Motivates students to think critically and creatively
                            </label>
                            <!-- Radio inputs -->
                            <div class="flex items-center justify-center space-x-5">
                                <input type="radio" name="question5" id="q5_1" value="1" class="mr-1">
                                <label for="q5_1" class="mr-2">1</label>
                                <input type="radio" name="question5" id="q5_2" value="2" class="mr-1">
                                <label for="q5_2" class="mr-2">2</label>
                                <input type="radio" name="question5" id="q5_3" value="3" class="mr-1">
                                <label for="q5_3" class="mr-2">3</label>
                                <input type="radio" name="question5" id="q5_4" value="4" class="mr-1">
                                <label for="q5_4" class="mr-2">4</label>
                                <input type="radio" name="question5" id="q5_5" value="5" class="mr-1">
                                <label for="q5_5">5</label>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                            <label class="block text-sm font-semibold">3.	Has a good command of the language of instruction with well modulated voice that can be understood by all students
                            </label>
                            <!-- Radio inputs -->
                            <div class="flex items-center justify-center space-x-5">
                                <input type="radio" name="question6" id="q6_1" value="1" class="mr-1">
                                <label for="q6_1" class="mr-2">1</label>
                                <input type="radio" name="question6" id="q6_2" value="2" class="mr-1">
                                <label for="q6_2" class="mr-2">2</label>
                                <input type="radio" name="question6" id="q6_3" value="3" class="mr-1">
                                <label for="q6_3" class="mr-2">3</label>
                                <input type="radio" name="question6" id="q6_4" value="4" class="mr-1">
                                <label for="q6_4" class="mr-2">4</label>
                                <input type="radio" name="question6" id="q6_5" value="5" class="mr-1">
                                <label for="q6_5">5</label>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                            <label class="block text-sm font-semibold">4.	Comes to class on time and makes productive use of allotted time for the subject
                            </label>
                            <!-- Radio inputs -->
                            <div class="flex items-center justify-center space-x-5">
                                <input type="radio" name="question7" id="q7_1" value="1" class="mr-1">
                                <label for="q7_1" class="mr-2">1</label>
                                <input type="radio" name="question7" id="q7_2" value="2" class="mr-1">
                                <label for="q7_2" class="mr-2">2</label>
                                <input type="radio" name="question7" id="q7_3" value="3" class="mr-1">
                                <label for="q7_3" class="mr-2">3</label>
                                <input type="radio" name="question7" id="q7_4" value="4" class="mr-1">
                                <label for="q7_4" class="mr-2">4</label>
                                <input type="radio" name="question7" id="q7_5" value="5" class="mr-1">
                                <label for="q7_5">5</label>
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
                                <input type="radio" name="question8" id="q8_1" value="1" class="mr-1">
                                <label for="q8_1" class="mr-2">1</label>
                                <input type="radio" name="question8" id="q8_2" value="2" class="mr-1">
                                <label for="q8_2" class="mr-2">2</label>
                                <input type="radio" name="question8" id="q8_3" value="3" class="mr-1">
                                <label for="q8_3" class="mr-2">3</label>
                                <input type="radio" name="question8" id="q8_4" value="4" class="mr-1">
                                <label for="q8_4" class="mr-2">4</label>
                                <input type="radio" name="question8" id="q8_5" value="5" class="mr-1">
                                <label for="q8_5">5</label>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                            <label class="block text-sm font-semibold">2.	Is fair and objective in giving grades
                            </label>
                            <!-- Radio inputs -->
                            <div class="flex items-center justify-center space-x-5">
                                <input type="radio" name="question9" id="q9_1" value="1" class="mr-1">
                                <label for="q9_1" class="mr-2">1</label>
                                <input type="radio" name="question9" id="q9_2" value="2" class="mr-1">
                                <label for="q9_2" class="mr-2">2</label>
                                <input type="radio" name="question9" id="q9_3" value="3" class="mr-1">
                                <label for="q9_3" class="mr-2">3</label>
                                <input type="radio" name="question9" id="q9_4" value="4" class="mr-1">
                                <label for="q9_4" class="mr-2">4</label>
                                <input type="radio" name="question9" id="q9_5" value="5" class="mr-1">
                                <label for="q9_5">5</label>
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
                                <input type="radio" name="question10" id="q10_1" value="1" class="mr-1">
                                <label for="q10_1" class="mr-2">1</label>
                                <input type="radio" name="question10" id="q10_2" value="2" class="mr-1">
                                <label for="q10_2" class="mr-2">2</label>
                                <input type="radio" name="question10" id="q10_3" value="3" class="mr-1">
                                <label for="q10_3" class="mr-2">3</label>
                                <input type="radio" name="question10" id="q10_4" value="4" class="mr-1">
                                <label for="q10_4" class="mr-2">4</label>
                                <input type="radio" name="question10" id="q10_5" value="5" class="mr-1">
                                <label for="q10_5">5</label>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                            <label class="block text-sm font-semibold">2.	Is approachable but firm in implementation of policies
                            </label>
                            <!-- Radio inputs -->
                            <div class="flex items-center justify-center space-x-5">
                                <input type="radio" name="question11" id="q11_1" value="1" class="mr-1">
                                <label for="q11_1" class="mr-2">1</label>
                                <input type="radio" name="question11" id="q11_2" value="2" class="mr-1">
                                <label for="q11_2" class="mr-2">2</label>
                                <input type="radio" name="question11" id="q11_3" value="3" class="mr-1">
                                <label for="q11_3" class="mr-2">3</label>
                                <input type="radio" name="question11" id="q11_4" value="4" class="mr-1">
                                <label for="q11_4" class="mr-2">4</label>
                                <input type="radio" name="question11" id="q11_5" value="5" class="mr-1">
                                <label for="q11_5">5</label>
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
                                <input type="radio" name="question12" id="q12_1" value="1" class="mr-1">
                                <label for="q12_1" class="mr-2">1</label>
                                <input type="radio" name="question12" id="q12_2" value="2" class="mr-1">
                                <label for="q12_2" class="mr-2">2</label>
                                <input type="radio" name="question12" id="q12_3" value="3" class="mr-1">
                                <label for="q12_3" class="mr-2">3</label>
                                <input type="radio" name="question12" id="q12_4" value="4" class="mr-1">
                                <label for="q12_4" class="mr-2">4</label>
                                <input type="radio" name="question12" id="q12_5" value="5" class="mr-1">
                                <label for="q12_5">5</label>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                            <label class="block text-sm font-semibold">2.	Wears the prescribed uniform
                            </label>
                            <!-- Radio inputs -->
                            <div class="flex items-center justify-center space-x-5">
                                <input type="radio" name="question13" id="q13_1" value="1" class="mr-1">
                                <label for="q13_1" class="mr-2">1</label>
                                <input type="radio" name="question13" id="q13_2" value="2" class="mr-1">
                                <label for="q13_2" class="mr-2">2</label>
                                <input type="radio" name="question13" id="q13_3" value="3" class="mr-1">
                                <label for="q13_3" class="mr-2">3</label>
                                <input type="radio" name="question13" id="q13_4" value="4" class="mr-1">
                                <label for="q13_4" class="mr-2">4</label>
                                <input type="radio" name="question13" id="q13_5" value="5" class="mr-1">
                                <label for="q13_5">5</label>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-2 shadow-xl">
                            <label class="block text-sm font-semibold">2.	Wears the prescribed uniform
                            </label>
                            <!-- Radio inputs -->
                            <div class="flex items-center justify-center space-x-5">
                                <input type="radio" name="question14" id="q14_1" value="1" class="mr-1">
                                <label for="q14_1" class="mr-2">1</label>
                                <input type="radio" name="question14" id="q14_2" value="2" class="mr-1">
                                <label for="q14_2" class="mr-2">2</label>
                                <input type="radio" name="question14" id="q14_3" value="3" class="mr-1">
                                <label for="q14_3" class="mr-2">3</label>
                                <input type="radio" name="question14" id="q14_4" value="4" class="mr-1">
                                <label for="q14_4" class="mr-2">4</label>
                                <input type="radio" name="question14" id="q14_5" value="5" class="mr-1">
                                <label for="q14_5">5</label>
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
                        <button type="button" class="px-4 py-2 mr-2 bg-green-500 text-white rounded-md hover:bg-green-600" id="submitEvaluation">Submit</button>
                        <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400" id="closeFormModal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Script  -->
    <script>
        const evaluateInstructor = document.getElementById('evaluateInstructor');
        const evaluationFormModal = document.getElementById('evaluationFormModal');
        const closeFormModal = document.getElementById('closeFormModal');
    
        evaluateInstructor.addEventListener('click', () => {
            evaluationFormModal.classList.remove('hidden');
        });
    
        closeFormModal.addEventListener('click', () => {
            evaluationFormModal.classList.add('hidden');
        });
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
