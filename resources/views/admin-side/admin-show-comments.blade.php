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

<x-nav-admin/> 

<div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-2 mx-2">
    <!-- Main Container -->
    
    <!-- Search Form -->
    <div class="flex justify-end mb-1 no-print">
        <form method="GET" action="{{ route('admin.showComments', ['admin_id' => $admin_id, 'instructor_id' => $instructor->instructor_id]) }}" class="flex gap-4 items-center">
            <div class="flex gap-4 items-center">
                <!-- Academic Year -->
                <div>
                    <label for="academic_year" class="block text-sm font-semibold">Academic Year</label>
                    <select id="academic_year" name="academic_year" class="border border-gray-300 rounded-md p-1 text-sm">
                        <option value="">Select A.Y</option>
                        <option value="2024-2025" {{ request()->input('academic_year') == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                        <option value="2025-2026" {{ request()->input('academic_year') == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                    </select>
                </div>
                <!-- Semester -->
                <div>
                    <label for="semester" class="block text-sm font-semibold">Semester</label>
                    <select id="semester" name="semester" class="border border-gray-300 rounded-md p-1 text-sm">
                        <option value="">Select Semester</option>
                        <option value="1st" {{ request()->input('semester') == '1st' ? 'selected' : '' }}>1st Semester</option>
                        <option value="2nd" {{ request()->input('semester') == '2nd' ? 'selected' : '' }}>2nd Semester</option>
                    </select>
                </div>
                <!-- Search Button -->
                <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded text-sm mt-5 mr-1">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white container mx-auto mt-2 text-center p-3 overflow-y-auto" style="height: 580px;">
        
            <!-- The Container to Print or Download -->
            <div id="content-to-print-or-download" class="print-container">
                <div class="flex items-start justify-between mb-4 mx-auto">
                    <!-- School Logos and Details -->
                    <img src="{{ asset('storage/images/dhvsu.png') }}" alt="School Logo" class="h-20">
                    <div class="text-center flex-grow">
                        <h3 class="text-md">Republic of the Philippines</h3>
                        <h2 class="text-xl font-bold">Don Honorio Ventura State University</h2>
                        <h3 class="text-sm">Sta. Catalina Lubao, Pampanga</h3>
                        <p class="mt-5 text-md font-bold">LUBAO CAMPUS</p>
                        <p class="text-md font-bold">Faculty Code: {{$instructor->instructor_id}}</p>
                        <p class="text-md font-bold">Faculty Name: {{$instructor->lastname}}, {{$instructor->firstname}} 
                            @if($instructor->middlename)
                                {{ strtoupper(substr($instructor->middlename, 0, 1)) }}
                            @else
                                N/A
                            @endif.
                        </p>
                        <p class="text-md font-bold">{{$semester}} SEMESTER - A.Y {{$academicYear}}</p>
                    </div>
                    <img src="{{ asset('storage/images/dlc-logo-bg.jpg') }}" alt="School Logo" class="h-20">
                </div>
            
                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="divide-y divide-gray-200 border-collapse border border-gray-400" style="table-layout: auto; width: 100%;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Equivalent</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $totalEquivalent = 0;
                                $count = $comments->count();
                            @endphp
                            @foreach($comments->take(100) as $comment)
                                @php
                                    $equivalent = round(($comment->total_score / 70) * 100);
                                    $totalEquivalent += $equivalent;
                                @endphp
                                <tr class="{{ $loop->iteration % 50 == 0 ? 'page-break' : '' }}">
                                    <td class="px-6 py-1 text-sm text-gray-800 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-1 text-sm text-gray-800 text-center">{{ $comment->total_score }}</td>
                                    <td class="px-6 py-1 text-sm text-gray-800 text-center">{{ $equivalent }}</td>
                                    <td class="px-6 py-1 text-sm text-gray-800 text-left" style="word-wrap: break-word; white-space: normal;">{{ $comment->comments }}</td>
                                </tr>
                            @endforeach
                        
                            @php
                                $averageEquivalent = $count > 0 ? round($totalEquivalent / $count) : 0;
                            @endphp
                        
                            <!-- Add the row for average -->
                            <tr class="bg-gray-100">
                                <td class="px-6 py-1 text-sm font-semibold text-gray-800 text-center" colspan="2">Average</td>
                                <td class="px-6 py-1 text-sm font-semibold text-gray-800 text-center">{{ $averageEquivalent }}</td>
                                <td class="px-6 py-1 text-sm text-gray-800"></td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            
                <!-- Signature Section -->
                <div class="mt-8">
                    <div class="flex flex-col">
                        <!-- Conforme Section -->
                        <div class="text-left mb-8">
                            <p class="font-semibold">Conforme:</p>
                            <div class="mt-10">
                                <hr class="border-t border-gray-800 w-1/4">
                            </div>
                        </div>

                        <!-- Certified Correct Section -->
                        <div class="flex justify-between text-left">
                            <div class="signature-section flex-1">
                                <p class="font-semibold">Certified Correct:</p>
                                <div class="mt-10">
                                    <p class="text-md font-semibold">MARIA CHRISTINA L. MEDINA, LPT, MALEd</p>
                                    <p>Academic Chairperson, Lubao Campus</p>
                                </div>
                            </div>
                            <div class="signature-section flex-1">
                                <div class="mt-14">
                                    <p class="text-md font-semibold">ROWEL D. WAJE, RCE, MAEd</p>
                                    <p>Director Lubao Campus</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    .signature-section {
                        display: flex;
                        flex-direction: column;
                        align-items: left;
                    }
                </style>
                

            </div>
            <!-- Print and Download Buttons -->
            <div class=" text-right no-print">
                <button onclick="window.print()" class="px-4 py-2 bg-gray-500 text-white rounded">Print</button>
                <button onclick="downloadPDF()" class="px-4 py-2 bg-green-500 text-white rounded">Download as PDF</button>
            </div>

            <!-- JavaScript for PDF Download -->
            <script>
                function downloadPDF() {
                    var element = document.getElementById('content-to-print-or-download');
                    html2pdf(element, {
                        margin: 0.5,
                        filename: 'my_students_evaluation.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: 'in', format: 'legal', orientation: 'portrait' }
                    });
                }
            </script>

            <!-- CSS for Print Layout -->
            <style>
                @media print {
                    /* Ensure content fits on the page properly */
                    @page {
                        size: 8.5in 14in; /* Legal size paper dimensions */
                        margin: 0.5in; /* Adjust margins as needed */
                    }
                    body {
                        -webkit-print-color-adjust: exact;
                        print-color-adjust: exact;
                        font-size: 12px;
                    }
            
                    /* Hide everything except the div we want to print */
                    body * {
                        visibility: hidden;
                    }
            
                    #content-to-print-or-download, #content-to-print-or-download * {
                        visibility: visible;
                    }
            
                    #content-to-print-or-download {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                    }
            
                    /* Set page break behavior to handle long content */
                    .page-break {
                        page-break-before: always;
                    }
            
                    .print-container {
                        page-break-inside: avoid;
                        break-inside: avoid;
                    }
            
                    table {
                        border-collapse: collapse;
                    }
            
                    th, td {
                        word-wrap: break-word;
                        padding: 3px;
                    }
                    table {
                        width: 100%;
                        table-layout: auto;
                    }
                    td {
                        word-wrap: break-word;
                        white-space: normal;
                    }
                    .page-break {
                        page-break-after: always;
                    }
                }
            </style>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</body>

@include('partials.footer')
@endauth
