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



<div class=" lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">
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
    </div>

    <div class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold mb-5">Instructors</h1>
        <div class="bg-white rounded-lg p-4 shadow-md my-4 lg:w-4/5 mx-auto" style="height: 29rem;">
            <a href="{{ route('admin.comments', ['admin_id' => $admin_id]) }}" class="text-white bg-green-700 p-1 rounded mx-auto">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
            @if(empty($allComments))
                <p class="text-center text-gray-500">No comments available</p>
            @else
                <div class="relative overflow-y-auto" style="height: 100%;">
                        @foreach($allComments as $comment)
                        <div class="flex items-center mb-2 bg-gray-100 p-1 rounded mt-4">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex-shrink-0">
                                <img src="{{ asset('storage/images/test-profile.png') }}" alt="Instructor Image" class="w-10 h-10 rounded-full mx-auto">
                            </div>
                            <img src="storage/images/test-profile.png" alt="">
                            <div class="ml-3">
                                <p class="font-semibold">-</p>
                                <p class="text-sm text-gray-600">Date: {{$comment['time']}}</p>
                                <p class="text-gray-900 p-2">{{$comment['comment']}}</p>
                                <p class="text-sm font-semibold text-gray-600">
                                    Sentiment:
                                    @if($comment['sentiment'] == 'Good')
                                        <span class="text-red-600">{{$comment['sentiment']}}</span>
                                    @elseif($comment['sentiment'] == 'Better')
                                        <span class="text-blue-600">{{$comment['sentiment']}}</span>
                                    @elseif($comment['sentiment'] == 'Best')
                                        <span class="text-green-600">{{$comment['sentiment']}}</span>
                                    @endif
                                </p>
                                
                            </div>
                        </div>
                        @endforeach
                </div>
            @endif
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
