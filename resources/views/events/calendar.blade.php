@extends('layouts.app')
@section('content')
    <div class="pt-6">

        {{-- Calendar Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-2">
                @php
                    $isCurrentMonth = $startOfMonth->isSameMonth(now()) && $startOfMonth->isSameYear(now());
                @endphp
                <a href="{{ route('events.calendar', ['month' => $startOfMonth->copy()->subMonth()->month, 'year' => $startOfMonth->copy()->subMonth()->year]) }}"
                    class="px-2 sm:px-3 py-1 rounded-md bg-gray-300 hover:bg-gray-400 transition">&lt;</a>

                <a href="{{ route('events.calendar', ['month' => now()->month, 'year' => now()->year]) }}"
                    class="px-3 sm:px-4 py-1 rounded-md shadow transition
                   {{ $isCurrentMonth ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-blue-400 text-white hover:bg-blue-500' }}">
                    Today
                </a>

                <a href="{{ route('events.calendar', ['month' => $startOfMonth->copy()->addMonth()->month, 'year' => $startOfMonth->copy()->addMonth()->year]) }}"
                    class="px-2 sm:px-3 py-1 rounded-md bg-gray-300 hover:bg-gray-400 transition">&gt;</a>
            </div>

            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 text-center sm:text-left">
                {{ $startOfMonth->format('F Y') }}
            </h2>
            @if (auth()->user()->role === 'admin')
                <button onclick="openEventModal()"
                    class="px-3 sm:px-4 py-1 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition text-sm sm:text-base">
                    + Add Event
                </button>
            @endif
        </div>

        {{-- Calendar Grid --}}
        <div class="overflow-x-auto">
            <div class="grid grid-cols-7 min-w-[700px] border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                {{-- Weekday Header --}}
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                    <div
                        class="py-2 sm:py-3 text-center text-xs sm:text-sm font-semibold bg-green-600 text-white border-b border-white">
                        {{ $dayName }}
                    </div>
                @endforeach

                @php $currentDay = $gridStart->copy(); @endphp
                @while ($currentDay <= $gridEnd)
                    @php
                        $date = $currentDay->toDateString();
                        $dayEvents = $events->filter(function ($event) use ($date) {
                            return $event->start_date <= $date && $event->end_date >= $date;
                        });
                        $isToday = $date === now()->toDateString();
                        $isCurrentMonth = $currentDay->month === $startOfMonth->month;
                        $isWeekend = in_array($currentDay->dayOfWeek, [0, 6]);
                    @endphp

                    <div class="relative h-20 sm:h-24 md:h-32 p-1 sm:p-2 border-b border-r border-green-300 cursor-pointer
                            {{ !$isCurrentMonth ? 'text-gray-400 bg-gray-100' : ($isWeekend ? 'bg-gray-50' : 'bg-white') }}"
                             @if (auth()->user()->role === 'admin') onclick="openEventModal('{{ $date }}')" @endif>

                        {{-- Day Number --}}
                        <div class="absolute top-1 sm:top-2 left-1 sm:left-2 text-xs sm:text-sm">
                            @if ($isToday)
                                <span
                                    class="bg-blue-600 text-white rounded-full w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center font-semibold">
                                    {{ $currentDay->day }}
                                </span>
                            @else
                                <span class="font-medium">{{ $currentDay->day }}</span>
                            @endif
                        </div>

                        {{-- Events (Multi-Day Logic) --}}
                        @foreach ($dayEvents as $event)
                            @if (Carbon\Carbon::parse($event->start_date)->isSameDay($currentDay))
                                @php
                                    $start = Carbon\Carbon::parse($event->start_date);
                                    $end = Carbon\Carbon::parse($event->end_date);
                                    $days = $start->diffInDays($end) + 1;
                                    $remainingDays =
                                        $start->diffInDays($gridEnd->copy()->endOfWeek(Carbon\Carbon::SATURDAY)) + 1;
                                    $span = min($days, $remainingDays);
                                    $widthClass = 'w-[' . $span * (100 / 7) . '%]';
                                    $leftOffset = $currentDay->dayOfWeek * (100 / 7);
                                @endphp
                                <div class="absolute z-10 p-1 sm:p-1.5 mt-6 md:mt-8 bg-green-300 rounded-lg cursor-pointer hover:bg-green-400 transition border-l-8 border-green-600"
                                    style="width: {{ $span * 97 }}%;"
                                    onclick='event.stopPropagation(); openEventDetailModal(@json($event));'>

                                    <div class="text-[6px] sm:text-xs truncate">
                                        {{ Carbon\Carbon::parse($event->start_time)->format('g:i A') }} <span
                                            class="font-medium">
                                            @if (strlen($event->title) > 30)
                                                {{ substr($event->title, 0, 30) . '...' }}
                                            @else
                                                {{ $event->title }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @php $currentDay->addDay(); @endphp
                @endwhile
            </div>
        </div>
    </div>

    {{-- Create Event Modal --}}
    <div id="eventModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden z-50 p-2">
        <div
            class="bg-white p-4 sm:p-6 md:p-8 rounded-lg shadow-xl w-full 
                max-w-sm sm:max-w-md md:max-w-2xl lg:max-w-3xl 
                max-h-[90vh] overflow-y-auto">

            <h3 class="text-lg text-green-600 font-semibold mb-3">Add Event</h3>

            <form action="{{ route('events.store') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="date" id="eventDate">

                <div>
                    <label class="block text-sm font-medium mb-1">Title</label>
                    <input type="text" name="title" class="border rounded-md p-2 w-full focus:ring focus:ring-blue-200"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" class="border rounded-md p-2 w-full focus:ring focus:ring-blue-200"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div onclick="this.querySelector('input').showPicker()">
                        <label class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="date" name="start_date"
                            class="border rounded-md p-2 w-full focus:ring focus:ring-blue-200" required>
                    </div>
                    <div onclick="this.querySelector('input').showPicker()">
                        <label class="block text-sm font-medium mb-1">End Date</label>
                        <input type="date" name="end_date"
                            class="border rounded-md p-2 w-full focus:ring focus:ring-blue-200" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div onclick="this.querySelector('input').showPicker()">
                        <label class="block text-sm font-medium mb-1">Start Time</label>
                        <input type="time" name="start_time"
                            class="border rounded-md p-2 w-full focus:ring focus:ring-blue-200" required>
                    </div>
                    <div onclick="this.querySelector('input').showPicker()">
                        <label class="block text-sm font-medium mb-1">End Time</label>
                        <input type="time" name="end_time"
                            class="border rounded-md p-2 w-full focus:ring focus:ring-blue-200" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Location</label>
                    <input type="text" name="location"
                        class="border rounded-md p-2 w-full focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Organizer</label>
                    <input type="text" name="organizer"
                        class="border rounded-md p-2 w-full focus:ring focus:ring-blue-200">
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-1">Organizer Email</label>
                    <input type="email" name="organizer_email"
                        class="border rounded-md p-2 w-full focus:ring focus:ring-blue-200">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeEventModal()"
                        class="px-3 py-1 rounded-md bg-orange-400 text-white hover:bg-orange-500 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-1 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- Event Detail Modal --}}
    <div id="eventDetailModal" class="fixed inset-0 flex items-center justify-center bg-black/50 hidden z-50 p-2">
        <div
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg relative overflow-hidden transform transition-all duration-300">

            <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-4 flex justify-between items-center">
                <h3 id="detailTitle" class="text-xl font-bold text-white flex items-center gap-2">
                </h3>
                <button type="button" onclick="closeEventDetailModal()" class="text-white hover:text-gray-200 transition">
                    ✕
                </button>
            </div>

            <div class="p-6 space-y-5 text-gray-700">

                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p><span class="font-semibold mr-2">Date: </span> <span id="detailDate"></span></p>
                </div>

                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p><span class="font-semibold mr-2">Time: </span> <span id="detailTime"></span></p>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zm4.95 2.45a2.5 2.5 0 100 5 2.5 2.5 0 000-5z"
                            clip-rule="evenodd" />
                    </svg>
                    <p><span class="font-semibold mr-2">Location:</span> <span id="detailLocation"></span></p>
                </div>

                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p><span class="font-semibold mr-2">Organizer: </span> <span id="detailOrganizer"></span></p>
                </div>

                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6M9 8h6m2-6H7a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V4a2 2 0 00-2-2z" />
                        </svg>
                        <span class="font-semibold">Description:</span>
                    </div>
                    <p id="detailDescription"
                        class="whitespace-pre-wrap p-3 rounded-lg bg-gray-100 border text-sm text-gray-600">
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEventModal(date = null) {
            document.getElementById('eventDate').value = date || '';
            const startDateInput = document.querySelector('input[name="start_date"]');
            if (date) startDateInput.value = date;
            else startDateInput.value = '';
            document.getElementById('eventModal').classList.remove('hidden');
        }

        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }

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
    </script>
@endsection
