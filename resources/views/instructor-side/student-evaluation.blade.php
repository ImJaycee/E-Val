@auth('students')

@php
    $title = 'E-Val-Evaluation';
    $array = ['title' => $title];
    // $studentID = session('studentID');
@endphp

@include('partials.header-student')


<body class="bg-gray-200">

<x-nav-student/> <!--Include nav and sidebar-->

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
                    <i class="font-normal">
                        Based on your evaluation, we can improve the quality of teaching. Thank you for your input!
                    </i>                  
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
{{-- Modal for add subject --}}
<div class="fixed inset-0 overflow-y-auto hidden" id="evaluationFormModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full md:max-w-md" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-bold text-gray-700">Evaluate Instructor</h3>
                <form action="#" method="POST" class="bg-white shadow-md rounded px-3 pt-5 pb-6 mb-1">
                    @csrf

                    <!-- Question 1 -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Question 1</label>
                        <div class="flex items-center justify-center">
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

                    <!-- Question 2 -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Question 2</label>
                        <div class="flex items-center justify-center">
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

                    <!-- Repeat for questions 3 to 10 -->
                    <!-- Question 3 -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Question 3</label>
                        <div class="flex items-center justify-center">
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

                    <!-- Repeat for questions 4 to 10 -->
                    <!-- Question 4 -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Question 4</label>
                        <div class="flex items-center justify-center">
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

                    <!-- Question 5 -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Question 5</label>
                        <div class="flex items-center justify-center">
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

                    <!-- Question 6 -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Question 6</label>
                        <div class="flex items-center justify-center">
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

                    <!-- Question 7 -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Question 7</label>
                        <div class="flex items-center justify-center">
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

                    <!-- Question 8 -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Question 8</label>
                        <div class="flex items-center justify-center">
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

                    <!-- Question 9 -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Question 9</label>
                        <div class="flex items-center justify-center">
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

                    <!-- Question 10 -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Question 10</label>
                        <div class="flex items-center justify-center">
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

                
                    <div class="mb-4">
                        <label class="block text-sm font-semibold">Comments</label>
                        <textarea name="comments" class="w-full mt-1 border border-gray-300 rounded-md p-2"></textarea>
                    </div>
                   
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm" id="submitEvaluation">
                            Submit
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closeFormModal">
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
