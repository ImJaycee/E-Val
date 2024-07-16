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
                    <i>Feedback and Rating Summary</i>!
                </h3>
                <p class="text-md font-bold text-gray-600">
                    This page contains users feedback
                </p>
                
                <p class="text-sm text-gray-500">
                    We appreciate all the feedback from our users as it helps us improve our services. Your insights and suggestions are valuable to us.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg p-4 shadow-md my-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-4"></h1>
        <div class="overflow-y-auto" style="max-height: 360px">
            @foreach($feedbacks as $feedback)
                <div class="flex items-center mb-2">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex-shrink-0">
                        <img src="{{ asset('storage/images/test-profile.png') }}" alt="image" class="w-10 h-10 rounded-full mx-auto">
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">-</p>
                        <p class="text-sm text-gray-600">Date: {{$feedback->created_at}}</p>
                        <p class="text-gray-900 p-2">{{$feedback->comment}}</p>
                        <p class="text-sm font-semibold text-gray-600">
                            Rating:
                            @if($feedback->rating == '1')
                                <i class="fas fa-star text-yellow-400"></i>
                            @elseif($feedback->rating == '2')
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            @elseif($feedback->rating == '3')
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            @elseif($feedback->rating == '4')
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            @elseif($feedback->rating == '5')
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
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
