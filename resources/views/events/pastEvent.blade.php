@extends('layouts.app')
@section('content')

    <div class="max-w-full mx-auto mt-2 bg-white rounded-xl shadow-lg overflow-x-auto">
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 sm:p-6 bg-green-600 text-white rounded-t-xl">
            <h2 class="text-xl sm:text-2xl font-bold">
                All Past Events
            </h2>
        </div>
    </div>
    @if ($events->count() > 0)
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-4">
            @foreach ($events as $event)
                <div class="bg-white border rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
                    <!-- Card Header -->
                    <div class="bg-green-600 text-white px-4 py-2 flex justify-between items-center">
                        <h3 class="font-bold text-lg md:text-xl truncate">
                            {{ strlen($event->title) > 30 ? substr($event->title, 0, 30) . '...' : $event->title }}
                        </h3>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="p-1 rounded-full hover:bg-green-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="5" r="1.5" />
                                    <circle cx="12" cy="12" r="1.5" />
                                    <circle cx="12" cy="19" r="1.5" />
                                </svg>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-20 bg-white border border-gray-200 rounded-lg shadow-lg z-20 text-sm">
                                <a href="#" onclick='openEventDetailModal(@json($event))'
                                    class="flex items-center px-3 py-1 text-blue-600 hover:bg-blue-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View</a>

                                <a href="#" onclick="openFileModal({{ $event->id }})"
                                    class="flex items-center px-3 py-1 text-orange-600 hover:bg-orange-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    File
                                </a>

                                <a href="#" onclick="openImageModal({{ $event->id }})"
                                    class="flex items-center px-3 py-1 text-yellow-600 hover:bg-yellow-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7h18M3 12h18M3 17h18" />
                                    </svg>
                                    Image
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 space-y-3 text-gray-700 text-sm">

                        <!-- Date (Start - End in one row) -->
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p>
                                <span class="font-semibold">Date:</span>
                                @if ($event->start_date == $event->end_date)
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                    –
                                    {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                                @endif
                            </p>
                        </div>

                        <!-- Time -->
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>
                                <span class="font-semibold">Time:</span>
                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                –
                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                            </p>
                        </div>

                        <!-- Location -->
                        <div class="flex gap-2">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 22s8-4.5 8-12a8 8 0 10-16 0c0 7.5 8 12 8 12z" />
                                </svg>
                            </div>

                            <p>
                                <span class="font-semibold">Location:</span>
                                {{ $event->location ?? '-' }}
                            </p>
                        </div>


                        <!-- Organizer -->
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p><span class="font-semibold">Organizer:</span> {{ $event->organizer ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="p-8 text-center text-gray-500 text-lg">No events found.</p>
    @endif

    <!--- View --->
    <div id="eventDetailModal" class="fixed inset-0 flex items-center justify-center bg-black/50 hidden z-50 p-2">

        <div
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg md:max-w-xl lg:max-w-xl relative overflow-hidden max-h-[95vh] overflow-y-auto transform transition-all duration-300 custom-scrollbar">

            <!-- Header -->
            <div
                class="bg-gradient-to-r from-green-600 to-green-800 px-4 md:px-6 py-3 md:py-4 flex justify-between items-center">
                <h3 id="detailTitle" class="text-lg md:text-xl font-bold text-white flex items-center gap-2"></h3>
                <button type="button" onclick="closeEventDetailModal()"
                    class="text-white hover:text-gray-200 transition text-lg">
                    ✕
                </button>
            </div>

            <!-- Body -->
            <div class="p-4 md:p-6 space-y-4 md:space-y-5 text-gray-700 text-sm md:text-base">

                <!-- Date -->
                <div class="flex items-start md:items-center gap-2 md:gap-4">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p><span class="font-semibold mr-1">Date:</span> <span id="detailDate"></span></p>
                </div>

                <!-- Time -->
                <div class="flex items-start md:items-center gap-2 md:gap-4">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p><span class="font-semibold mr-1">Time:</span> <span id="detailTime"></span></p>
                </div>

                <!-- Location -->
                <div class="flex gap-2 md:gap-4">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zm4.95 2.45a2.5 2.5 0 100 5 2.5 2.5 0 000-5z"
                            clip-rule="evenodd" />
                    </svg>
                    <p><span class="font-semibold mr-1">Location:</span> <span id="detailLocation"></span></p>
                </div>

                <!-- Organizer -->
                <div class="flex items-start md:items-center gap-2 md:gap-4">
                    <svg class="w-5 h-5 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p><span class="font-semibold mr-1">Organizer:</span> <span id="detailOrganizer"></span></p>
                </div>

                <!-- Description -->
                <div>
                    <div class="flex items-center gap-2 md:gap-4 mb-2">
                        <svg class="w-5 h-5 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6M9 8h6m2-6H7a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V4a2 2 0 00-2-2z" />
                        </svg>
                        <span class="font-semibold">Description:</span>
                    </div>
                    <p id="detailDescription"
                        class="whitespace-pre-wrap p-2 md:p-3 rounded-lg bg-gray-100 border text-sm md:text-base text-gray-600">
                    </p>
                </div>

                <!-- Files -->
                <div>
                    <div class="flex items-center gap-2 md:gap-4 mb-2">
                        <svg class="w-5 h-5 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9 6 9-6M3 7l9-6 9 6" />
                        </svg>
                        <span class="font-semibold">Files:</span>
                    </div>
                    <div id="detailFiles" class="text-sm md:text-base text-gray-600">
                    </div>
                </div>

                <!-- Images -->
                <div>
                    <div class="flex items-center gap-2 md:gap-4 mb-2">
                        <svg class="w-5 h-5 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9 6 9-6M3 7l9-6 9 6" />
                        </svg>
                        <span class="font-semibold">Images:</span>
                    </div>
                    <div id="detailImages">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- File Upload Modal -->
    <div id="fileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Upload Files</h3>
            <form id="fileUploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="files[]" multiple required class="mb-3 w-full border rounded p-2">
                <p class="text-sm text-gray-500 mb-3">Allowed: pdf, doc, docx, xls, xlsx. Max size: 5MB each. Max 10 files
                    total.</p>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeFileModal()"
                        class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Upload Modal -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Upload Images</h3>
            <form id="imageUploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="images[]" multiple accept="image/*" required
                    class="mb-3 w-full border rounded p-2">
                <p class="text-sm text-gray-500 mb-3">Allowed: jpg, jpeg, png. Max size: 2MB each. Max 3 images total.</p>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeImageModal()"
                        class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Upload</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function openEventDetailModal(event) {
            function formatDateWithDay(dateStr) {
                if (!dateStr) return '';
                const d = new Date(dateStr);

                const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                const dayName = days[d.getDay()];

                const day = String(d.getDate()).padStart(2, '0');
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const year = d.getFullYear();

                return `${dayName}, ${day}-${month}-${year}`;
            }

            function formatTimeAMPM(time24) {
                if (!time24) return '';
                const [hour, minute] = time24.split(':');
                let h = parseInt(hour);
                const ampm = h >= 12 ? 'PM' : 'AM';
                h = h % 12 || 12;
                return `${h}:${minute} ${ampm}`;
            }

            // Title
            document.getElementById('detailTitle').innerText = truncateText(event.title, 0, 40);

            // Date (with weekday)
            if (event.start_date && event.end_date) {
                if (event.start_date === event.end_date) {
                    document.getElementById('detailDate').innerText = formatDateWithDay(event.start_date);
                } else {
                    document.getElementById('detailDate').innerText =
                        `${formatDateWithDay(event.start_date)} → ${formatDateWithDay(event.end_date)}`;
                }
            } else {
                document.getElementById('detailDate').innerText = 'N/A';
            }

            // Time
            const startTime = event.start_time ? formatTimeAMPM(event.start_time) : '';
            const endTime = event.end_time ? formatTimeAMPM(event.end_time) : '';
            document.getElementById('detailTime').innerText =
                startTime && endTime ? `${startTime} - ${endTime}` : (startTime || endTime || 'N/A');

            // Other fields
            document.getElementById('detailLocation').innerText = event.location || 'N/A';
            document.getElementById('detailOrganizer').innerText = event.organizer || 'N/A';
            document.getElementById('detailDescription').innerText = event.description || 'No description';

            // Files
            const detailFiles = document.getElementById('detailFiles');
            detailFiles.innerHTML = '';
            if (event.files && event.files.length > 0) {
                const ul = document.createElement('ul');
                ul.className = 'list-none space-y-1 max-h-24 overflow-y-auto';
                event.files.forEach(file => {
                    let icon = '📁';
                    let url = `/storage/${file.file_path}`;
                    if (file.file_type) {
                        switch (file.file_type.toLowerCase()) {
                            case 'pdf':
                                icon = '📄';
                                break;
                            case 'doc':
                            case 'docx':
                            case 'xls':
                            case 'xlsx':
                                icon = '📝';
                                url = 'https://docs.google.com/gview?url=' + encodeURIComponent(url) +
                                    '&embedded=true';
                                break;
                        }
                    }

                    const li = document.createElement('li');
                    li.className = 'flex items-center grid-col-1 md:grid-col-2 gap-2';
                    li.innerHTML = `
                <span class="text-xl">${icon}</span>
                <a href="${url}" target="_blank" class="text-blue-600 hover:underline truncate max-w-xs">
                    ${file.file_name || 'Unnamed File'}
                </a>
            `;
                    ul.appendChild(li);
                });
                detailFiles.appendChild(ul);
            } else {
                detailFiles.innerText = 'No files uploaded.';
            }

            // Images
            const detailImages = document.getElementById('detailImages');
            detailImages.innerHTML = '';
            if (event.images && event.images.length > 0) {
                const grid = document.createElement('div');
                grid.className = 'grid grid-cols-2 md:grid-cols-3 gap-3';
                event.images.forEach(img => {
                    const imgEl = document.createElement('img');
                    imgEl.src = `/storage/${img.image_path}`;
                    imgEl.alt = 'Event Image';
                    imgEl.className = 'w-24 h-14 md:w-40 md:h-24 object-cover rounded-md';
                    grid.appendChild(imgEl);
                });
                detailImages.appendChild(grid);
            } else {
                detailImages.innerText = 'No images uploaded.';
            }


            // Show modal
            document.getElementById('eventDetailModal').classList.remove('hidden');
        }

        function closeEventDetailModal() {
            document.getElementById('eventDetailModal').classList.add('hidden');
        }

        function truncateText(text, start, end) {
            if (!text) return '';
            return text.length > end ? text.substring(start, end) + '...' : text;
        }

        function openFileModal(eventId) {
            document.getElementById('fileModal').classList.remove('hidden');
            const form = document.getElementById('fileUploadForm');
            form.action = `/events/${eventId}/files`;
        }

        function closeFileModal() {
            document.getElementById('fileModal').classList.add('hidden');
        }

        function openImageModal(eventId) {
            document.getElementById('imageModal').classList.remove('hidden');
            const form = document.getElementById('imageUploadForm');
            form.action = `/events/${eventId}/images`;
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>

@endsection
