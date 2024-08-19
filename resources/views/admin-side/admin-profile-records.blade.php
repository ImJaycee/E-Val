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
    <x-messages/>
    <div class="lg:flex gap-4 items-stretch">
        
        <div class="bg-white md:p-2 p-6 rounded-lg border border-gray-200 mb-4 lg:mb-0 shadow-md lg:w-[25%]">
          
            <div class="block justify-center h-full">
                <div class="max-w-md bg-white shadow-md rounded-lg overflow-hidden mx-auto my-auto">
                    <div class="px-4 py-2">
                        
                        <div class="text-center mt-2">
                            <p class="text-lg text-gray-800 font-medium">{{ $admin->firstname}} {{ $admin->middlename}} {{ $admin->lastname}}</p>
                            <p class="text-gray-600 border-b" style="font-size: 13px;">Admin Name</p>
                            <p class="text-sm font-semibold text-gray-700">{{$admin_id}}</p>
                            <p class="text-gray-600 border-b" style="font-size: 13px;">Admin ID</p>
                            <p class="text-sm font-normal text-gray-700">{{$admin->email}}</p>
                            <p class="text-gray-600 border-b" style="font-size: 13px;">Email</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 flex justify-center">
                        <button class="bg-green-700 hover:bg-green-800 text-sm text-white font-bold py-2 px-4 rounded mr-2" id="updateProfileButton">Update</button>
                        <button class="bg-red-700 hover:bg-red-800 text-sm text-white font-bold py-2 px-4 rounded" id="changePasswordButton">Change Password</button>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="bg-white p-4 rounded-lg xs:mb-4 max-w-full shadow-md lg:w-[75%]">
            <h3 class="font-bold text-gray-700 bg-gray-200 px-1 rounded">Instructors</h3>
            <div class="max-h-60 overflow-x-auto relative">
                <table class="w-full table-fixed">
                    <thead class="bg-white top-0">
                        <tr>
                            <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 33.33%;">
                                <h2 class="text-ml font-bold text-gray-700">Instructor Name</h2>
                            </th>
                            <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 33.33%;">
                                <h2 class="text-ml font-bold text-gray-700">Faculty Code</h2>
                            </th>
                            <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 33.33%;">
                                <h2 class="text-ml font-bold text-gray-700">Action</h2>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($instructors as $instructor)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-left align-top font-semibold text-sm text-gray-600">
                                    <p>{{ $instructor->instructor_name }}</p>
                                </td>
                                <td class="px-4 py-2 text-left font-semibold text-sm text-gray-600">
                                    <p><span>{{ $instructor->instructor_id }}</span></p>
                                </td>
                                <td class="px-4 py-2 text-left font-semibold text-md text-gray-100 text-left">
                                    <a href="javascript:void(0);" class="bg-red-600 p-2 rounded" data-instructor-id="{{ $instructor->instructor_id }}" onclick="openModal('{{ $instructor->instructor_id }}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                            
                                </td>
                            </tr>

                             {{-- Remove Instructor Modal --}}
               {{-- Remove Instructor Modal --}}
                            <div class="fixed inset-0 overflow-y-auto hidden" id="RemoveInstructorModal-{{ $instructor->instructor_id }}">
                                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                    <span class="text-red-600 text-2xl font-bold">
                                                        !
                                                    </span>
                                                </div>
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                        Remove Instructor?
                                                    </h3>
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-500">
                                                            Are you sure you want to remove <span class="text-sm text-gray-600"><i>{{ $instructor->instructor_name}}</i></span>? This action cannot be undone.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 ">
                                            <form action="{{ route('admin.remove-instructor', ['instructor_id' =>$instructor->instructor_id]) }}" method="POST" class="sm:ml-3 sm:w-auto sm:text-sm">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <p class="text-gray-900 text-sm font-bold mb-4">Remove account too?</p>
                                                <div class="mb-4 flex flex-row">
                                                    <div class="flex items-center mb-2">
                                                        <input type="radio" id="RemoveAccountYes" name="RemoveAccount" value="remove_account" class="form-radio text-red-600 focus:ring-red-500">
                                                        <label for="RemoveAccountYes" class="ml-2 text-gray-900 text-sm">Yes</label>
                                                    </div>
                                                    <div class="flex items-center mb-2 ml-4">
                                                        <input type="radio" id="RemoveAccountNo" name="RemoveAccount" value="keep_account" checked class="form-radio text-red-600 focus:ring-red-500">
                                                        <label for="RemoveAccountNo" class="ml-2 text-gray-900 text-sm">No</label>
                                                    </div>
                                                </div>
                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                                    Clear
                                                </button>
                                            </form>
                                            <button onclick="closeModal('{{ $instructor->instructor_id }}')" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
    
                        
                        <tr class="">
                            <td colspan="3" class="text-center text-sm font-semibold py-1 rounded">
                                <button class="w-full md:w-60 py-1 bg-green-800 text-white border-2 border-green-900 rounded mt-2" id="AddInstructorButton">
                                    <i class="fas fa-add"></i> Add Instructor
                                </button>
                            </td>
                        </tr>               
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <div class="bg-white p-4 rounded-lg mt-4 max-w-full shadow-md lg:w-[100%]">
        <div class="flex flex-col md:flex-row justify-between items-center bg-gray-200 px-1 py-2 rounded-lg shadow-md">
            <form action="{{route('admin.profile', ['admin_id' => $admin_id])}}" class="flex w-full md:w-auto items-center md:mb-0">
                <input type="number" name="student_id" class="w-full md:w-96 px-3 py-1 bg-white border-1 border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Student ID" required>
                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded-r-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <button class="w-full md:w-auto px-2 py-1 bg-red-900 text-white border-2 rounded mt-2 md:mt-0 md:ml-4 " id="RemoveAllStudent">
                <i class="fas fa-archive mr-2"></i> Remove All
            </button>

                    <!-- Warning Modal -->
                    <div id="removeAllModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                        <div class="bg-white p-4 rounded shadow-lg max-w-sm w-full">
                            <h2 class="text-xl font-semibold text-red-600 mb-4">Warning</h2>
                            <p class="mb-4">Are you sure you want to remove all students? This action cannot be undone.</p>
                            <div class="flex justify-end">
                                <button id="cancelRemove" class="px-4 py-2 bg-gray-500 text-white rounded mr-2">Cancel</button>
                                <form action="{{ route('admin.move-student-to-archives') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Remove All</button>
                                </form>
                            </div>
                        </div>
                    </div>

        </div>
        
        <div class="max-h-60 overflow-x-auto">
            <table class="w-full table-fixed">
                <thead class="bg-white top-0">
                    <tr>
                        <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 33.33%;">
                            <h2 class="text-ml font-bold text-gray-700"></h2>
                        </th>
                        <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 33.33%;">
                            <h2 class="text-ml font-bold text-gray-700">Student ID</h2>
                        </th>
                        <th class="bg-white px-4 py-2 text-left border-b-2" style="width: 33.33%;">
                            <h2 class="text-ml font-bold text-gray-700">Action</h2>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-left align-top font-bold text-sm text-gray-600">
                                <p>{{ $student->id }}</p>
                            </td>
                            <td class="px-4 py-2 text-left font-bold text-sm text-gray-600">
                                <p><span>{{ $student->student_id }}</span></p>
                            </td>
                            <td class="px-4 py-2 text-left font-semibold text-md text-gray-100 text-left">
                                <a href="javascript:void(0);" class="bg-green-800 py-1 px-2 rounded text-sm" data-student-id="{{ $student->student_id }}" onclick="openModalStudent('{{ $student->student_id }}')">
                                    <i class="fas fa-eye"></i>
                                </a>                                       
                            </td>
                        </tr>

                        {{-- Student Modal --}}
                        <div class="fixed inset-0 overflow-y-auto hidden" id="UpdateStudentModal-{{ $student->student_id }}">
                            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-full sm:max-w-md md:max-w-xl lg:max-w-2xl">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <span class="text-red-600 text-2xl font-bold">
                                                    !
                                                </span>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                    Student Subjects Enrolled
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6">
                                        <form action="{{ route('admin.update-student-subjects', ['admin_id' => $admin_id]) }}" method="POST" class="sm:ml-3 sm:w-auto sm:text-sm">
                                            @csrf
                                            <p class="text-gray-700 border-b">
                                                Sample format: <span class="text-gray-600">IAS 323 BSIT 3B</span>
                                            </p>
                                            <div class="text-gray-700 font-semibold">
                                                <label for="student_id" >Student ID: </label>
                                                <input type="text" name="student_id" id="student_id" value="{{ $student->student_id }}" readonly>
                                            </div>
                                            {{-- Subjects --}}
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                @for ($i = 1; $i <= 10; $i++)
                                                <div class="mb-4">
                                                    <label for="subject{{ $i }}" class="block text-gray-700 text-sm font-bold mb-2">Subject {{ $i }}</label>
                                                    <div class="relative">
                                                        <input type="text" id="subject{{ $i }}" name="subject{{ $i }}" value="{{ old('subject' . $i, $student->{'subject' . $i} ?? '') }}" oninput="this.value = this.value.toUpperCase();"
                                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                                                    </div>
                                                </div>
                                                @endfor
                                            </div>
                                            
                                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                                Update
                                            </button>
                                        </form>
                                        
                                        <button onclick="closeModalStudent('{{ $student->student_id }}')" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    @endforeach
               
                </tbody>
            </table>
        </div>
    </div>


</div>



{{-- Update profile --}}
<div class="fixed inset-0 overflow-y-auto hidden" id="updateProfileModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full md:max-w-md" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-bold text-gray-700">Update Profile</h3>
                <form action="{{ route('admin.update-profile', ['admin_id' => $admin_id]) }}" method="POST" class="bg-white shadow-md rounded px-3 pt-5 pb-6 mb-1">
                    @csrf
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="admin_id" class="block text-gray-700 text-sm font-bold mb-2">Admin ID</label>
                        <div class="relative">
                            <input type="number" id="admin_id" name="admin_id" required onfocus="clearError()" value={{$admin_id}} readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('admin_id')
                                <p id="admin_id" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="firstname" class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                        <div class="relative">
                            <input type="text" id="firstname" name="firstname" required onfocus="clearError()" value={{$admin->firstname}}
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('firstname')
                                <p id="firstname" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="middlename" class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label>
                        <div class="relative">
                            <input type="text" id="middlename" name="middlename" required onfocus="clearError()" value={{$admin->middlename}}
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('middlename')
                                <p id="middlename" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="lastname" class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                        <div class="relative">
                            <input type="text" id="lastname" name="lastname" required onfocus="clearError()" value={{$admin->lastname}}
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('lastname')
                                <p id="lastname" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" required onfocus="clearError()" value={{$admin->email}}
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('email')
                                <p id="email" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm" >
                        Save
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closeUpdateModal">
                        Close
                    </button>
                </form>

            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">       
                
            </div>
        </div>
    </div>
</div>


   {{-- Modal change password --}}
<div class="fixed inset-0 overflow-y-auto hidden" id="changePasswordModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full md:max-w-md" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-bold text-gray-700">Change Password</h3>
                <form action="{{route('admin.change-password', ['admin_id' => $admin_id])}}" method="POST" class="bg-white shadow-md rounded px-3 pt-5 pb-6 mb-1">
                    @csrf
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="oldpassword" class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                        <div class="relative">
                            <input type="password" id="oldpassword" name="oldpassword" required onfocus="clearError()"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="togglePassword_Old" class="far fa-eye-slash text-gray-500 cursor-pointer"></i>
                            </span>
                            @error('oldpassword')
                                <p id="oldpassword_error" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="newpassword" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                        <div class="relative">
                            <input type="password" id="newpassword" name="newpassword" required onfocus="clearError()"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="togglePassword_New" class="far fa-eye-slash text-gray-500 cursor-pointer"></i>
                            </span>
                            @error('newpassword')
                                <p id="newpassword_error" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="con_pass" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                        <div class="relative">
                            <input type="password" id="con_pass" name="con_pass" required onfocus="clearError()"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="togglePassword_Con" class="far fa-eye-slash text-gray-500 cursor-pointer"></i>
                            </span>
                            @error('con_pass')
                                <p id="con_pass" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm" >
                        Save
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closePasswordModal">
                        Close
                    </button>
                </form>

            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">       
                
            </div>
        </div>
    </div>
</div>

  {{-- Modal Add instructor --}}
  <div class="fixed inset-0 overflow-y-auto hidden" id="AddInstructorModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full md:max-w-md" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-bold text-gray-700">Add Instructor</h3>
                <form action="{{route('admin.add-instructor', ['admin_id' => $admin_id])}}" method="POST" class="bg-white shadow-md rounded px-3 pt-5 pb-6 mb-1">
                    @csrf
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="instructor_id" class="block text-gray-700 text-sm font-bold mb-2">Instructor ID</label>
                        <div class="relative">
                            <input type="number" id="instructor_id" name="instructor_id" required onfocus="clearError()"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                           
                            @error('instructor_id')
                                <p id="instructor_id_error" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 md:w-full md:mr-2">
                        <label for="instructor_name" class="block text-gray-700 text-sm font-bold mb-2">Instructor Name 
                            <span class="text-gray-500" style="font-size: 10px;">(LASTNAME, FIRSTNAME MI.)</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="instructor_name" name="instructor_name" required onfocus="clearError()" oninput="this.value = this.value.toUpperCase()"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                           
                            @error('instructor_name')
                                <p id="instructor_name_error" class="text-red-500 text-sm text-end p-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm" >
                        Save
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closeAddingModal">
                        Close
                    </button>
                </form>

            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">       
                
            </div>
        </div>
    </div>
</div>







<!-- Script for update prfile modal -->
<script>
    const updateProfileButton = document.getElementById('updateProfileButton');
    const updateProfileModal = document.getElementById('updateProfileModal');
    const closeUpdateModal = document.getElementById('closeUpdateModal');

    updateProfileButton.addEventListener('click', () => {
        updateProfileModal.classList.remove('hidden');
    });

    closeUpdateModal.addEventListener('click', () => {
        updateProfileModal.classList.add('hidden');
    });
</script>

<!-- Script for adding instructor -->
<script>
    const AddInstructorButton = document.getElementById('AddInstructorButton');
    const AddInstructorModal = document.getElementById('AddInstructorModal');
    const closeAddingModal = document.getElementById('closeAddingModal');

    AddInstructorButton.addEventListener('click', () => {
        AddInstructorModal.classList.remove('hidden');
    });

    closeAddingModal.addEventListener('click', () => {
        AddInstructorModal.classList.add('hidden');
    });
</script>


<!-- Script for change password modal -->
<script>
    const changePasswordButton = document.getElementById('changePasswordButton');
    const changePasswordModal = document.getElementById('changePasswordModal');
    const closePasswordModal = document.getElementById('closePasswordModal');

    changePasswordButton.addEventListener('click', () => {
        changePasswordModal.classList.remove('hidden');
    });

    closePasswordModal.addEventListener('click', () => {
        changePasswordModal.classList.add('hidden');
    });
</script>

{{-- script for show password --}}
<script>
    const oldpassword = document.getElementById('oldpassword');
    const togglePassword_Old = document.getElementById('togglePassword_Old');
    const newpassword = document.getElementById('newpassword');
    const togglePassword_New = document.getElementById('togglePassword_New');
    const con_pass = document.getElementById('con_pass');
    const togglePassword_Con = document.getElementById('togglePassword_Con');

    togglePassword_Old.addEventListener('click', function() {
        if (oldpassword.type === 'password') {
            oldpassword.type = 'text';
            togglePassword_Old.classList.remove('fa-eye-slash');
            togglePassword_Old.classList.add('fa-eye');
        } else {
            oldpassword.type = 'password';
            togglePassword_Old.classList.remove('fa-eye');
            togglePassword_Old.classList.add('fa-eye-slash');
        }
    });
    togglePassword_New.addEventListener('click', function() {
        if (newpassword.type === 'password') {
            newpassword.type = 'text';
            togglePassword_New.classList.remove('fa-eye-slash');
            togglePassword_New.classList.add('fa-eye');
        } else {
            newpassword.type = 'password';
            togglePassword_New.classList.remove('fa-eye');
            togglePassword_New.classList.add('fa-eye-slash');
        }
    });
    togglePassword_Con.addEventListener('click', function() {
        if (con_pass.type === 'password') {
            con_pass.type = 'text';
            togglePassword_Con.classList.remove('fa-eye-slash');
            togglePassword_Con.classList.add('fa-eye');
        } else {
            con_pass.type = 'password';
            togglePassword_Con.classList.remove('fa-eye');
            togglePassword_Con.classList.add('fa-eye-slash');
        }
    });

</script>

<script>
    function openModal(instructorId) {
        const modal = document.getElementById(`RemoveInstructorModal-${instructorId}`);
        modal.classList.remove('hidden');
    }

    function closeModal(instructorId) {
        const modal = document.getElementById(`RemoveInstructorModal-${instructorId}`);
        modal.classList.add('hidden');
    }
</script>


<script>
    function openModalStudent(studentId) {
        const modalStudent = document.getElementById(`UpdateStudentModal-${studentId}`);
        modalStudent.classList.remove('hidden');
    }

    function closeModalStudent(studentId) {
        const modalStudent = document.getElementById(`UpdateStudentModal-${studentId}`);
        modalStudent.classList.add('hidden');
    }
</script>

<script>
    document.getElementById('RemoveAllStudent').addEventListener('click', function() {
    document.getElementById('removeAllModal').classList.remove('hidden');
    });

    document.getElementById('cancelRemove').addEventListener('click', function() {
        document.getElementById('removeAllModal').classList.add('hidden');
    });

</script>

</body>

@include('partials.footer')
@endauth
