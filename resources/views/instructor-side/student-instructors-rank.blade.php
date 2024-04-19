@auth('students')

@php
    $title = 'E-Val-Ranking';
    $array = ['title' => $title];
    // $studentID = session('studentID');
@endphp

@include('partials.header-student')


<body class="bg-gray-200">

<x-nav-student/> <!--Include nav and sidebar-->

<div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-4 mx-2">
    <!-- Main Container -->
    <div class="lg:flex gap-4 items-stretch">
        <!-- White Box -->
        <div class="bg-white p-4 rounded-lg xs:mb-4 max-w-full shadow-md lg:w-[100%]">
            <!-- Small Boxes -->
            <div class="block justify-center h-full">
                <h3 class="text-xl font-bold text-gray-700">
                    Intructors Ranking!
                </h3>
                <p class="text-md font-bold text-gray-600">
                    <i class="font-normal">
                        Based on evaluation results, this ranking aims to improve teaching quality. Thank you for your input!
                    </i>
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg p-4 shadow-md my-3 h-full" >
        <h3 class="text-xl font-bold text-gray-700">A.Y. 2023-2024 - 1st Semester</h3>
        <form action="#" method="GET" class="flex flex-col lg:flex-row justify-end mb-2">
            <label for="academic_year" class="font-semibold text-gray-700 mr-2">A.Y.</label>
            <select name="academic_year" id="academic_year" required class="border border-gray-300 rounded-md p-1 mb-2 lg:mb-0 lg:mr-1 text-sm">
                <option value="" disabled selected class="text-sm">Select academic year</option>
                <option value="2021-2022-1">2021-2022 - 1st sem</option>
                <option value="2021-2022-2">2021-2022 - 2nd sem</option>
                <option value="2022-2023-1">2022-2023 - 1st sem</option>
                <option value="2022-2023-2">2022-2023 - 2nd sem</option>
                <option value="2023-2024-1">2023-2024 - 1st sem</option>
                <!-- Add more options as needed -->
            </select>
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold py-1 px-2 rounded"><i class="fas fa-search"></i></button>
        </form>
        <ul class="divide-y divide-gray-200 lg:h-96 overflow-y-auto" style="height: 28rem;">
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full">
                    <span class="ml-4 font-bold">Aldrin Duana</span>
                </div>
                <span class="text-sm text-gray-600 mr-3">Rating: 4.9</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full">
                    <span class="ml-4 font-bold">Davemm Salalila</span>
                </div>
                <span class="text-sm text-gray-600 mr-3">Rating: 4.3</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full">
                    <span class="ml-4 font-bold">Aldrin Duana</span>
                </div>
                <span class="text-sm text-gray-600 mr-3">Rating: 4.9</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full">
                    <span class="ml-4 font-bold">Davemm Salalila</span>
                </div>
                <span class="text-sm text-gray-600 mr-3">Rating: 4.3</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full">
                    <span class="ml-4 font-bold">Aldrin Duana</span>
                </div>
                <span class="text-sm text-gray-600 mr-3">Rating: 4.9</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full">
                    <span class="ml-4 font-bold">Davemm Salalila</span>
                </div>
                <span class="text-sm text-gray-600 mr-3">Rating: 4.3</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full">
                    <span class="ml-4 font-bold">Aldrin Duana</span>
                </div>
                <span class="text-sm text-gray-600 mr-3">Rating: 4.9</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full">
                    <span class="ml-4 font-bold">Davemm Salalila</span>
                </div>
                <span class="text-sm text-gray-600 mr-3">Rating: 4.3</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full">
                    <span class="ml-4 font-bold">Aldrin Duana</span>
                </div>
                <span class="text-sm text-gray-600 mr-3">Rating: 4.9</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full">
                    <span class="ml-4 font-bold">Davemm Salalila</span>
                </div>
                <span class="text-sm text-gray-600 mr-3">Rating: 4.3</span>
            </li>
            <!-- Add more list items for other instructors -->
        </ul>
    </div>
    

</div>


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
