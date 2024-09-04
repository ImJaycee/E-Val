@auth('admins')

@php
    $title = 'E-Val-Summary';
    $array = ['title' => $title];
    $admin_id = session('admin_id');
    $firstname = session('firstname');
    $lastname = session('lastname');

@endphp

@include('partials.header-admin')


<div class="container mx-auto mt-5 text-center">
    <div id="content-to-print-or-download">
        <!-- Header and Logo Section -->
        <div class="flex items-start justify-between mb-4 mx-auto">
            <!-- School Logos and Details -->
            <img src="{{ asset('storage/images/dhvsu.png') }}" alt="School Logo" class="h-20">
            <div class="text-center flex-grow">
                <h3 class="text-md">Republic of the Philippines</h3>
                <h2 class="text-xl font-bold">Don Honorio Ventura State University</h2>
                <h3 class="text-sm">Sta. Catalina Lubao, Pampanga</h3>
                <p class="mt-5 text-md font-bold">SUMMARY STUDENTS' EVALUATION</p>
                <p class="text-md font-bold">{{ $semester }} SEMESTER - A.Y {{ $academicYear }}</p>
            </div>
            <img src="{{ asset('storage/images/dlc-logo-bg.jpg') }}" alt="School Logo" class="h-20">
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border-collapse border border-gray-400">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor Name</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Sex</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Faculty Code</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($instructors as $instructor)
                        <tr>
                            <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-800 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-800 text-center">{{ $instructor->lastname }}, {{ $instructor->firstname }} {{ strtoupper(substr($instructor->middlename, 0, 1)) }}.</td>
                            <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-800 text-center">{{ $instructor->sex }}</td>
                            <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-800 text-center">{{ $instructor->instructor_id }}</td>
                            <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-800 text-center">{{ $instructor->rating ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Print and Download Buttons -->
    <div class="mt-4 text-center">
        <button onclick="window.print()" class="px-4 py-2 bg-gray-500 text-white rounded no-print">Print</button>
        <button onclick="downloadPDF()" class="px-4 py-2 bg-green-500 text-white rounded no-print">Download as PDF</button>
        <form action="{{ route('view.Ranking') }}" method="POST" class="inline no-print">
            @csrf
            <input type="hidden" name="A_Y" value="{{ $academicYear }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Sort By Rating</button>
        </form>
        <form action="{{ route('view.summary') }}" method="POST" class="inline no-print">
            @csrf
            <input type="hidden" name="A_Y" value="{{ $academicYear }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Sort Alphabetically</button>
        </form>
    </div>
    
</div>

<!-- JavaScript for PDF Download -->
<script>
    function downloadPDF() {
        var element = document.getElementById('content-to-print-or-download');
        html2pdf(element, {
            margin:       1,
            filename:     'summary_students_evaluation.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        });
    }
</script>

<style>
    /* CSS for Print Layout */
    @media print {
        .no-print {
            display: none;
        }
        .print-container {
            page-break-inside: avoid;
        }
    }
</style>



<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

</body>
@include('partials.footer')
@endauth
