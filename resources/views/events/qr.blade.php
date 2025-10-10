@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto px-2 sm:px-4 lg:px-6">

        {{-- Page Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-green-700">
                QR Code Events
            </h1>
            <p class="mt-2 text-gray-600">Scan the QR code below to register for your event</p>
        </div>

        {{-- Events Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($events as $event)
                @php

                    // Format date and time
                    $startDate = Carbon\Carbon::parse($event->start_date)->format('D, d M Y');
                    $endDate = Carbon\Carbon::parse($event->end_date)->format('D, d M Y');
                    $startTime = Carbon\Carbon::parse($event->start_time)->format('g:i A');
                    $endTime = Carbon\Carbon::parse($event->end_time)->format('g:i A');
                @endphp


                <div id="card-{{ $event->id }}"
                    class="relative bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl transition-transform transform hover:-translate-y-1 duration-300 border-t-8 border-b-8 border-green-600 cursor-pointer"
                    onclick="downloadCard({{ $event->id }}, '{{ $event->title }}')">

                    {{-- Event Content --}}
                    <div class="p-6 flex flex-col items-center">

                        {{-- Event Title --}}
                        <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">
                            {{ $event->title }}
                        </h2>

                        {{-- QR Code --}}
                        @if ($event->qr_code_path)
                            <div class="flex flex-col items-center space-y-2">
                                <img src="{{ asset('storage/' . $event->qr_code_path) }}"
                                    alt="QR Code for {{ $event->title }}"
                                    class="w-40 h-40 border rounded-xl shadow-md hover:scale-105 transition-transform duration-300">
                                <p class="text-sm text-gray-500">Scan to register</p>
                            </div>
                        @else
                            <p class="text-red-500 italic">No QR code available</p>
                        @endif

                        {{-- Event Info --}}
                        <div class="mt-4 space-y-0 text-gray-700 text-sm text-center">

                            {{-- Date --}}
                            <div class="flex items-center justify-center gap-2">
                                <div class="flex items-center mt-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex items-center text-sm">
                                    <span class="font-semibold">Date:</span>
                                    <span class="ml-1">
                                        @if ($startDate === $endDate)
                                            {{ $startDate }}
                                        @else
                                            {{ $startDate }} - {{ $endDate }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            {{-- Time --}}
                            <div class="flex items-center justify-center gap-2">
                                <div class="flex items-center mt-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex items-center text-sm">
                                    <span class="font-semibold">Time:</span>
                                    <span class="ml-1">{{ $startTime }} - {{ $endTime }}</span>
                                </div>
                            </div>

                            {{-- Location --}}
                            @if ($event->location)
                                <div class="flex justify-center gap-2">
                                    <div class="flex mt-3">
                                        <svg class="w-4 h-4 text-red-600" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zm4.95 2.45a2.5 2.5 0 100 5 2.5 2.5 0 000-5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="flex text-sm">
                                        <p class="font-semibold">Location: <span class="ml-1 font-normal">{{ $event->location }}</span></p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Include html2canvas --}}
    <script>
        function downloadCard(id, title) {
        const card = document.getElementById(`card-${id}`);
        html2canvas(card, {
            useCORS: true,
            allowTaint: true,
            backgroundColor: "#ffffff",
            scale: 2,
            logging: false
        }).then(canvas => {
            const link = document.createElement("a");

            // Make title safe for filename
            let safeTitle = title.replace(/\s+/g, "_").replace(/[^a-zA-Z0-9_\-]/g, "");
            // Truncate to 50 characters max
            if (safeTitle.length > 50) {
                safeTitle = safeTitle.substring(0, 50);
            }

            link.download = `${safeTitle}.png`;
            link.href = canvas.toDataURL("image/png");
            link.click();
        });
    }
    </script>
@endsection
