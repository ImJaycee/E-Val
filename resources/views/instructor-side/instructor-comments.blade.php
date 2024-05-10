@auth('instructors')

@php
    $title = 'E-Val-comments';
    $array = ['title' => $title];
    $instructor_id = session('instructor_id');
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
                    <i>Student Comments</i>!
                </h3>
                <p class="text-md font-bold text-gray-600">
                    Welcome, Instructor! This page contains anonymous comments from your students. 
                    These comments provide valuable insights into the student experience and can help 
                    you understand their perspectives, challenges, and suggestions. Please review 
                    these comments to gain a better understanding of your students' feedback and 
                    enhance your teaching approach. Your attention to these comments is greatly appreciated!
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg p-4 shadow-md my-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Anonymous Student Comments</h1>
        <div class="overflow-y-auto" style="max-height: 360px">
            @foreach($comments as $comment)
                <div class="flex items-center mb-2">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex-shrink-0">
                        <img src="storage/images/test-profile.png" alt="Instructor Image" class="w-10 h-10 rounded-full mx-auto">
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">Anonymous Student</p>
                        <p class="text-sm text-gray-600">Date: {{$comment->created_at}}</p>
                        <p class="text-gray-900 p-2">{{$comment->comments}}</p>
                        <p class="text-sm font-semibold text-gray-600">
                            Sentiment:
                            @if($comment->sentiment == 'Good')
                                <span class="text-green-600">{{$comment->sentiment}}</span>
                            @elseif($comment->sentiment == 'Better')
                                <span class="text-blue-600">{{$comment->sentiment}}</span>
                            @elseif($comment->sentiment == 'Best')
                                <span class="text-purple-600">{{$comment->sentiment}}</span>
                            @endif
                        </p>
                        
                    </div>
                </div>
            @endforeach
            <!-- Add more comments here -->
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
