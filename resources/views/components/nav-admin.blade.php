@if(session('reload'))
    <script>
        location.reload();
    </script>
@endif
@php
     $admin_id = session('admin_id');
@endphp

<nav class="bg-red-900 border-b border-gray-300">
    <div class="flex justify-between items-center px-9">
        <button id="menuBtn" class="lg:hidden">
            <i class="fas fa-bars text-gray-200 text-lg"></i>
        </button>

        <!-- Logo -->
        <div class="ml-1 flex">
            <img src="{{ asset('storage/images/dlc-logo-new.png') }}" alt="logo" class="h-14 w-15 p-2 rounded-full">
            <h1 class="text-sm md:text-xl mt-4 md:mt-3 text-gray-200 font-bold">E-VAL</h1>
        </div>

        {{-- notification --}}
        <a href="{{route('admin.profile', ['admin_id' => $admin_id])}}">
            @If(!empty($pfp))
                <img class="h-10 w-10 rounded-full object-cover"src="{{ asset('storage/images/pfp/'.$pfp) }}" alt="User profile picture">
            @else
                <img class="h-10 w-10 rounded-full object-cover"src="{{ asset('storage/images/dhvsu.png') }}" alt="User profile picture">
            @endif
        </a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div id="sideNav" class="lg:block hidden bg-gray-100 w-64 h-screen fixed rounded-none border-none z-50">
    <!-- Items -->
    <div class="p-4 space-y-4">
        <!-- Home -->
        <a href="{{route('admin.dashboard', ['admin_id' => $admin_id])}}" aria-label="dashboard" class="relative px-4 py-3 flex items-center space-x-4 rounded-lg text-gray-700 hover:bg-gray-200 ">
            <i class="fas fa-home"></i>
            <span class="">Home</span>
        </a>

        <a href="{{ route('admin.manageStudent', ['admin_id' => $admin_id]) }}" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-users"></i>
            <span>Students</span>
        </a>
        <a href="{{ route('admin.manageInstructor', ['admin_id' => $admin_id]) }}" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-users"></i>
            <span>Instructors</span>
        </a>
        {{-- <a href="{{route('instructor.instructor-rank')}}" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-star"></i>
            <span>Instructor Ranking</span>
        </a> --}}
        <a href="{{ route('admin.comments', ['admin_id' => $admin_id]) }}" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-comment"></i>
            <span>Comments</span>
        </a>
        <a href="{{ route('admin.feedbacks', ['admin_id' => $admin_id]) }}" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-star"></i>
            <span class=" text-md">Rating & feedback</span>
        </a>
        <a href="{{ route('admin.report', ['admin_id' => $admin_id]) }}" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-chart-line"></i>
            <span class=" text-md">Evaluation Summary</span>
        </a>
        <a href="{{route('admin.profile', ['admin_id' => $admin_id])}}" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-700 hover:bg-gray-200 group"> 
            
            <i class="fas fa-user"></i>
            <span>Profile & Records</span>
        </a>
        <form action="{{ route('admin_logout') }}" method="post" class="flex items-center">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-3 flex items-center space-x-4 rounded-md text-gray-700 hover:bg-gray-200 group">
                <i class="fas fa-sign-out-alt"></i>
                <span>Log out</span>
            </button>
        </form>
              
    </div>
    {{-- <footer class="bg-gray-700 text-gray-200 py-3 text-center rounded-sm mt-36">
        <p class="text-sm">&copy; 2024 All Rights Reserved.</p>
        <p class="mt-1 text-xs">Developed by <a href="#" class=""><i>Jay Cee Cruz</i></a></p>
    </footer> --}}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currentUrl = window.location.href;
        var navLinks = document.querySelectorAll('#sideNav a');

        navLinks.forEach(function(link) {
            if (link.href === currentUrl) {
                // link.classList.add('text-gray-200', 'bg-gradient-to-r', 'from-red-900', 'to-yellow-500','font-bold',);
                link.classList.remove('font-semibold', 'text-gray-700','hover:bg-gray-200');

                link.classList.add('text-gray-200', 'bg-red-900', 'font-bold',);
            }
        });
    });
</script>