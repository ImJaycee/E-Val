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
<x-messages/>
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
                    This page contains anonymous comments from students. 
                    These comments provide valuable insights into the student experience and can help 
                    you understand their perspectives, challenges, and suggestions. Please review 
                    these comments to gain a better understanding of students' feedback and 
                    enhance teaching approach.
                </p>
            </div>
        </div>
        <div class="bg-gray-400 max-w-full p-2 rounded">
            <p class="font-bold mb-1">Offensive Word Filter</p>
            <form action="{{route('admin.filter-words')}}" method="POST">
                @csrf
                <input type="text" id="word" name="word" placeholder="Enter word to block" class="p-2 border border-gray-300 rounded w-full mb-4" required>
                <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600 text-sm">Add to Filter</button>
            </form>
        </div>
        
        
    </div>

    <div class="container mx-auto mt-5 ">
        <div class="relative bg-cover bg-center bg-no-repeat rounded-lg p-4 my-4 " style="height: 27rem;">
            <!-- Blurred Background Image -->
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('storage/images/index-bg.jpg'); filter: blur(8px);"></div>
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
            </div>
            <div class="relative overflow-y-auto " style="height: 100%;">
                <div class="relative grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-4 z-0 ">
                    @php
                        // Define an array of background colors
                        $colors = [
                            'bg-blue-500',
                            'bg-green-500',
                            'bg-red-500',
                            'bg-yellow-500',
                            'bg-purple-500',
                            'bg-orange-500',
                            'bg-pink-500',
                            'bg-teal-500',
                            'bg-indigo-500',
                            'bg-gray-500'
                        ];
                    @endphp
                    @foreach($instructors as  $index => $instructor)
                    <div class="relative bg-cover bg-center shadow-md rounded p-3 opacity-85 {{ $colors[$index % count($colors)] }}">
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded"></div>
                        <div class="relative z-10">
                            <div class="mb-2">
                                <h2 class="text-sm font-bold text-gray-100"></h2>
                                <p class="font-bold text-xs text-gray-200">{{ $instructor->firstname }} {{ $instructor->lastname }}</p>
                            </div>
                            <div class="mb-2">
                                <h2 class="text-sm font-bold text-gray-100">Faculty Code</h2>
                                <p class="font-bold text-xs text-gray-200">{{ $instructor->instructor_id }}</p>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('admin.showComments', ['admin_id' => $admin_id, 'instructor_id' => $instructor->instructor_id]) }}" class="bg-gray-200 px-2 py-1 font-semibold rounded text-green-800 text-xs w-full">
                                    View Comments <i class="fas fa-comments"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
</div> <!-- Close the outermost container div -->


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
