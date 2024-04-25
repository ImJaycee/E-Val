@if(session('reload'))
    <script>
        location.reload();
    </script>
@endif
@php
     $student_id = session('student_id');
     $pfp = session('pfp');
@endphp

<nav class="bg-red-900 border-b border-gray-300">
    <div class="flex justify-between items-center px-9">
        <button id="menuBtn" class="lg:hidden">
            <i class="fas fa-bars text-gray-200 text-lg"></i>
        </button>

        <!-- Logo -->
        <div class="ml-1 flex">
            <img src="storage/images/dlc-logo-bg.jpg" alt="logo" class="h-14 w-15 p-2 rounded-full">
            <h1 class="text-sm md:text-xl mt-4 md:mt-3 text-gray-200 font-bold">E-VAL</h1>
        </div>

        {{-- notification --}}
            <a href="{{route('student.profile', ['student_id' => $student_id])}}">
                @If(!empty($pfp))
                    <img class="h-10 w-10 rounded-full object-cover"src="{{ asset('storage/images/pfp/'.$pfp) }}" alt="User profile picture">
                @else
                    <img class="h-10 w-10 rounded-full object-cover"src="storage/images/test-profile.png" alt="User profile picture">
                @endif
            </a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div id="sideNav" class="lg:block hidden bg-gray-100 w-64 h-screen fixed rounded-none border-none">
    <!-- Items -->
    <div class="py-4 space-y-0">
        <!-- Home -->
        <a href="{{ route('student.dashboard') }}" aria-label="dashboard" class="relative px-5 py-4 border-b flex items-center space-x-4 rounded-sm text-gray-700 hover:bg-gray-200">
            <i class="fas fa-home"></i>
            <span class="">Home</span>
        </a>

        <a href="{{route('student.evaluation')}}" class="px-5 py-4 flex items-center space-x-4 border-b rounded-sm text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-poll"></i>
            <span>Evaluation</span>
        </a>
        <a href="{{route('student.instructor-rank')}}" class="px-5 py-4 flex items-center space-x-4 border-b rounded-sm text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-star"></i>
            <span>Instructors Ranking</span>
        </a>
        <a href="{{route('student.feedback')}}" class="px-5 py-4 flex items-center space-x-4 border-b rounded-sm text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-comment"></i>
            <span>Feedback</span>
        </a>
        <a href="{{route('student.profile', ['student_id' => $student_id])}}" class="px-5 py-4 border-b flex items-center space-x-4 rounded-sm text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
        <a href="#" class="px-5 py-4 flex items-center space-x-4 border-b rounded-sm text-gray-700 hover:bg-gray-200 group">
            <i class="fas fa-sign-out-alt"></i>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit">Log out</button>
            </form>
        </a>
    </div>
    <footer class="bg-gray-900 text-gray-200 py-2 text-center rounded-sm mt-60">
        <p class="text-xs">&copy; 2024 All Rights Reserved.</p>
        <p class="mt-1 text-xs">Developed by <a href="#" class=""><i>Jay Cee Cruz</i></a></p>
    </footer>
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