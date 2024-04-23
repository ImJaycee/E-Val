@auth('instructors')

@php
    $title = 'E-Val-Ranking';
    $array = ['title' => $title];
    // $studentID = session('studentID');
@endphp

@include('partials.header-instructor')


<body class="bg-gray-200">

<x-nav-instructor/> <!--Include nav and sidebar-->

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

        <div class="bg-white rounded-lg p-4 shadow-md my-3 h-full">
            <h3 class="text-xl font-bold text-gray-700"></h3>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 items-center">
                <div class="bg-white rounded-lg p-6 shadow-md max-w-sm">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full mx-auto">
                    <div class="text-center mt-2">
                        <span class="font-bold text-gray-800">Aldrin Duana</span><br>
                        <span class="text-md text-gray-700 font-semibold ">Rank: <i class="fas fa-medal text-yellow-500"></i> 1</span><br>
                        <span class="text-sm text-gray-600">A.Y 2022-2023</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md max-w-xs">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full mx-auto">
                    <div class="text-center mt-2">
                        <span class="font-bold text-gray-800">Aldrin Duana</span><br>
                        <span class="text-md text-gray-700 font-semibold ">Rank: <i class="fas fa-medal text-yellow-500"></i> 1</span><br>
                        <span class="text-sm text-gray-600">A.Y 2021-2022</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md max-w-xs">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full mx-auto">
                    <div class="text-center mt-2">
                        <span class="font-bold text-gray-800">Aldrin Duana</span><br>
                        <span class="text-md text-gray-700 font-semibold ">Rank: <i class="fas fa-medal text-yellow-500"></i> 1</span><br>
                        <span class="text-sm text-gray-600">A.Y 2020-2021</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md max-w-sm">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full mx-auto">
                    <div class="text-center mt-2">
                        <span class="font-bold text-gray-800">Aldrin Duana</span><br>
                        <span class="text-md text-gray-700 font-semibold ">Rank: <i class="fas fa-medal text-yellow-500"></i> 1</span><br>
                        <span class="text-sm text-gray-600">A.Y 2019-2020</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md max-w-xs">
                    <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full mx-auto">
                    <div class="text-center mt-2">
                        <span class="font-bold text-gray-800">Aldrin Duana</span><br>
                        <span class="text-md text-gray-700 font-semibold ">Rank: <i class="fas fa-medal text-yellow-500"></i> 1</span><br>
                        <span class="text-sm text-gray-600">A.Y 2018-2019</span>
                    </div>
                </div>
                <!-- Add more instructors here -->
            </div>
   
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
