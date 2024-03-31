
<nav class="bg-gray-700 border-b border-gray-300">
    <div class="flex justify-between items-center px-9">
        <button id="menuBtn" class="lg:hidden">
            <i class="fas fa-bars text-gray-200 text-lg"></i>
        </button>

        <!-- Logo -->
        <div class="ml-1">
            <img src="storage/image/dlc-logo1.png" alt="logo" class="h-14 w-15 p-1">
        </div>

        {{-- notification --}}
            <a href="{{route('student.profile')}}">
                <img class="h-10 w-10 rounded-full object-cover" src="storage/image/test-profile.png" alt="User profile picture">
            </a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div id="sideNav" class="lg:block hidden bg-gray-700 w-64 h-screen fixed rounded-none border-none">
    <!-- Items -->
    <div class="p-4 space-y-4">
        <!-- Home -->
        <a href="{{ route('student.dashboard') }}" aria-label="dashboard" class="relative px-4 py-3 flex items-center space-x-4 rounded-lg text-gray-200 ">
            <i class="fas fa-home text-white"></i>
            <span class="">Home</span>
        </a>

        <a href="#" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-200 group">
            <i class="fas fa-poll"></i>
            <span>Evaluation</span>
        </a>
        <a href="{{route('student.instructor-rank')}}" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-200 group">
            <i class="fas fa-star"></i>
            <span>Instructors Ranking</span>
        </a>
        <a href="{{route('student.feedback')}}" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-200 group">
            <i class="fas fa-comment"></i>
            <span>Feedback</span>
        </a>
        <a href="{{route('student.profile')}}" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-200 group">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
        <a href="#" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-200 group">
            <i class="fas fa-sign-out-alt"></i>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit">Log out</button>
            </form>
        </a>
    </div>
    <footer class="bg-gray-700 text-gray-200 py-3 text-center rounded-md mt-52">
        <p class="text-sm">&copy; 2024 All Rights Reserved.</p>
        <p class="mt-1 text-xs">Developed by <a href="#" class=""><i>Jay Cee Cruz</i></a></p>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currentUrl = window.location.href;
        var navLinks = document.querySelectorAll('#sideNav a');

        navLinks.forEach(function(link) {
            if (link.href === currentUrl) {
                link.classList.add('text-gray-200', 'bg-gradient-to-r', 'from-red-900', 'to-yellow-500','font-bold',);
            }
        });
    });
</script>