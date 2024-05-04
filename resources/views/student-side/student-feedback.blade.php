@auth('students')

@php
    $title = 'E-Val-Feedback';
    $array = ['title' => $title];
    $student_id = session('student_id');
@endphp

@include('partials.header-student')


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
                    Rate <i>E-Val</i>!
                </h3>
                <p class="text-md font-bold text-gray-600">
                    Thank you for using our system! Your feedback is important to us as it helps us 
                    improve and provide a better experience for you and other users. Please take a moment 
                    to rate our system and let us know how we're doing. <br/>
                    <i class="font-normal">
                        Your honest feedback is greatly appreciated. Thank you!
                    </i>
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg p-4 shadow-md my-4 mt-6">
        <form action="{{ route('student-side.submit-feedback') }}" method="POST" class="text-center">
            @csrf
            <input type="text" name="users_id" value="{{$student_id}}" class="hidden">
            <input type="text" name="current_date" id="current_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}" class="hidden">
            <div class="mb-4">
                <label for="rating" class="block text-gray-700 font-semibold mb-2">Rating:</label>
                <div class="flex justify-center items-center text-gray-200">
                    <input type="radio" id="star1" name="rating" value="1" class="hidden" />
                    <label for="star1" class="text-3xl cursor-pointer">&#9733;</label>
                    <span class="mx-1"> </span>
                    <input type="radio" id="star2" name="rating" value="2" class="hidden" />
                    <label for="star2" class="text-3xl cursor-pointer">&#9733;</label>
                    <span class="mx-1"> </span>
                    <input type="radio" id="star3" name="rating" value="3" class="hidden" />
                    <label for="star3" class="text-3xl cursor-pointer">&#9733;</label>
                    <span class="mx-1"> </span>
                    <input type="radio" id="star4" name="rating" value="4" class="hidden" />
                    <label for="star4" class="text-3xl cursor-pointer">&#9733;</label>
                    <span class="mx-1"> </span>
                    <input type="radio" id="star5" name="rating" value="5" class="hidden" />
                    <label for="star5" class="text-3xl cursor-pointer">&#9733;</label>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="comment" class="block text-gray-700 font-semibold mb-2">Comment:</label>
                <textarea name="comment" id="comment" cols="30" rows="5" class="border border-gray-300 rounded-md px-3 py-2 w-full resize-none focus:outline-none focus:ring focus:border-blue-300"></textarea>
            </div>
            <button type="submit" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md">Submit Feedback</button>
        </form>
    </div>

    <footer class="bg-gray-700 text-gray-200 py-2 text-center rounded-md lg:mt-16">
        <p>&copy; 2024 All Rights Reserved.</p>
        <p class="mt-1 text-sm">Developed by <a href="#" class=""><i>Jay Cee Cruz</i></a></p>
    </footer>


</div>


<script>
    function updateDateTime() {
        const now = new Date();
        const date = now.toISOString().slice(0, 10);
        const time = now.toTimeString().slice(0, 8);
        const datetime = `${date} ${time}`;
        document.getElementById('current_date').value = datetime;
    }

    // Update date and time every second
    setInterval(updateDateTime, 1000);

    // Initial update
    updateDateTime();
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
