@extends('layouts.app')

@section('title', 'Membership Profile')

@section('content')
    <style>
        /* Base shadows, adjusted to use a subtle gray/black hint */
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .card-shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Status Badges - green backgrounds, dark text */
        .status-active {
            background: linear-gradient(#16a34a);
            /* Light to medium green */
            color: #ffff;
            /* Dark gray text */
            border: 1px solid #d1d5db;
            /* Light gray border */
        }

        .status-inactive {
            background: linear-gradient(135deg, #e6ffe6, #c2f0c2);
            /* Very light green */
            color: #1f2937;
            /* Dark gray text */
            border: 1px solid #d1d5db;
            /* Light gray border */
        }

        /* Section Headers - light green gradient background, light gray border */
        .section-header {
            background: linear-gradient(#ffff);
            /* Very light to light green */
            border-bottom: 1px solid #d1d5db;
            /* Light gray border */
        }

        /* Specific Card Backgrounds - different green gradients, light gray borders */
        .vision-card {
            background: linear-gradient(#16a34a);
            /* Pale to medium green */
            border: 1px solid #d1d5db;
            /* Light gray border */
            color: #ffff;
        }

        .mission-card {
            background: linear-gradient(#16a34a);
            /* Medium to strong green */
            border: 1px solid #d1d5db;
            /* Light gray border */
            color: #ffff;
        }

        .goal-card {
            background: linear-gradient(#16a34a);
            /* Yellowish-green to olive green */
            border: 1px solid #d1d5db;
            /* Light gray border */
            color: #ffff;
        }

        /* File Links - green background, dark text, light gray border */
        .file-link {
            background: linear-gradient(#e6ffee);
            border: 1px solid #d1d5db;
            color: #1f2937;
            /* Dark gray text */
            transition: all 0.2s ease;
        }

        .file-link:hover {
            background: linear-gradient(#82cd82);
            color: #ffff;
            transform: translateY(-1px);
        }

        /* Network Item - green background and accent, dark text */
        .network-item {
            background: linear-gradient(#eaffea);
            /* Very light to light green */
            border-left: 4px solid #16a34a;
            /* Strong green accent */
        }

        /* Focal Point Card - light green background, light gray border, dark text */
        .focal-point-card {
            background: linear-gradient(#e0f8e0);
            /* Very pale to light green */
            border: 1px solid #d1d5db;
            /* Light gray border */
        }

        /* Overview Card - white background, neutral hover shadow */
        .overview-card {
            background: white;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .overview-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Icon Colors - green backgrounds, dark gray icons */
        .icon-dark-green {
            color: #ffff;
            background: #16a34a;
        }

        .icon-medium-green {
            color: #ffff;
            background: #16a34a;
        }

        .icon-earthy-green {
            color: #ffff;
            background: #16a34a;
        }

        .icon-yellowish-green {
            color: #ffff;
            background: #16a34a;
        }

        .icon-muted-green {
            color: #ffff;
            background: #16a34a;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-delay-1 {
            animation-delay: 0.1s;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
        }
    </style>

    <div class="min-h-screen max-w-full mx-auto">
        @foreach ($memberships as $membership)
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h1 class="text-xl lg:text-3xl font-bold text-gray-900 mb-2">
                            {{ $membership->org_name_en ?? 'N/A' }}
                            ( {{ $membership->org_name_abbreviation ?? '' }} )
                        </h1>
                        <p class="text-gray-700 text-base md:text-xl font-medium">Membership Details & Information</p>
                        <p class="text-gray-700 text-base md:text-lg mt-4">Applying for: <span
                                class="px-2 py-1 text-white rounded bg-green-500">{{ $membership->membership_type ?? 'N/A' }}</span>
                        </p>
                        <div class="flex justify-between items-center">
                            <p class="text-gray-600 mt-4 text-5sm">
                                {{ optional($membership->created_at)->format('d M Y') ?? 'N/A' }}
                            </p>
                            <p
                                class="px-2 py-1 text-white rounded
                                @if ($membership->status === 'pending') bg-orange-400
                                @elseif($membership->status === 'approved') bg-green-500
                                @elseif($membership->status === 'cancel') bg-red-500 @endif">
                                {{ ucfirst($membership->status) }}
                            </p>
                        </div>
                    </div>


                    <div class="max-w-8xl mx-auto py-4">
                        <!-- Overview Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                            <div
                                class="overview-card rounded-xl card-shadow border border-gray-200 p-3 md:p-6 animate-fade-in">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 icon-dark-green rounded-lg">
                                        <svg class="w-4 md:w-8 h-4 md:h-8" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Director</h3>
                                        <p class="text-gray-700">{{ $membership->director_name ?? 'N/A' }}</p>
                                        <p class="text-gray-700">{{ $membership->director_email ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="overview-card rounded-xl card-shadow border border-gray-200 p-3 md:p-6 animate-fade-in animate-delay-1">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 icon-medium-green rounded-lg">
                                        <svg class="w-4 md:w-8 h-4 md:h-8" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Alternative Contact Person</h3>
                                        <p class="text-gray-700">{{ $membership->representative_name ?? 'N/A' }}</p>
                                        <p class="text-gray-700">{{ $membership->representative_email ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="overview-card rounded-xl card-shadow border border-gray-200 p-3 md:p-6 animate-fade-in animate-delay-2">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 icon-earthy-green rounded-lg">
                                        <svg class="w-4 md:w-8 h-4 md:h-8" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14-7H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Address</h3>
                                        <p class="text-gray-700">{{ $membership->address ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 mb-8">
                            <!-- Networks Section -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                                <!-- Header -->
                                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 rounded-xl bg-green-600 text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Networks & Focal Points</h3>
                                            <p class="text-sm text-gray-600">List of focal points and their network details
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="p-6">
                                    @php
                                        $uploads = $membership->membershipUploads ?? collect();
                                    @endphp

                                    @if ($uploads->isNotEmpty())
                                        @foreach ($uploads as $upload)
                                            @php
                                                $focals = $upload->focalPoints ?? collect();
                                            @endphp

                                            @if ($focals->isNotEmpty())
                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                    @foreach ($focals as $focal)
                                                        <div
                                                            class="rounded-xl border border-gray-200 bg-green-50 p-4 hover:shadow-md transition">
                                                            <!-- Top Row -->
                                                            <div class="flex items-start justify-between gap-3 mb-3">
                                                                <div>
                                                                    <h4 class="text-base font-semibold text-gray-900">
                                                                        {{ $focal->name ?? 'N/A' }}
                                                                    </h4>
                                                                </div>

                                                                <span
                                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-100">
                                                                    {{ $focal->network_name ?? 'Network' }}
                                                                </span>
                                                            </div>

                                                            <!-- Details -->
                                                            <div class="space-y-2 text-sm">
                                                                <div class="flex items-center gap-2 text-gray-700">
                                                                    <!-- Mail icon -->
                                                                    <svg class="w-4 h-4 text-gray-500" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                    </svg>

                                                                    <a href="mailto:{{ $focal->email }}"
                                                                        class="text-blue-600 hover:underline break-all">
                                                                        {{ $focal->email ?? 'N/A' }}
                                                                    </a>
                                                                </div>
                                                                <div class="flex items-center gap-2">
                                                                    <svg class="w-4 h-4 text-gray-600" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                                        </path>
                                                                    </svg>
                                                                    <span class="text-gray-600">{{ $focal->phone }}</span>
                                                                </div>

                                                                <div class="flex items-center gap-2 text-gray-700">
                                                                    <!-- Briefcase icon -->
                                                                    <svg class="w-4 h-4 text-gray-500" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M10 6h4m-7 4h10m-13 9h16a2 2 0 002-2V9a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <span>Position: <span
                                                                            class="font-medium text-gray-900">{{ $focal->position ?? 'N/A' }}</span></span>
                                                                </div>

                                                                <div class="flex items-center gap-2 text-gray-700">
                                                                    <!-- Users icon -->
                                                                    <svg class="w-4 h-4 text-gray-500" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M17 20h5v-1a4 4 0 00-4-4h-1M9 20H2v-1a4 4 0 014-4h1m6-4a4 4 0 10-8 0 4 4 0 008 0zm8 0a3 3 0 10-6 0 3 3 0 006 0z" />
                                                                    </svg>
                                                                    <span>Network: <span
                                                                            class="font-medium text-gray-900">{{ $focal->network_name ?? 'N/A' }}</span></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <!-- Empty focal points -->
                                                <div
                                                    class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center">
                                                    <p class="text-gray-600 italic">No focal points available.</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <!-- Empty uploads -->
                                        <div
                                            class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center">
                                            <p class="text-gray-600 italic">No focal points available.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Applications Section -->
                        <div
                            class="bg-white rounded-xl card-shadow border border-gray-200 overflow-hidden animate-fade-in animate-delay-3 mb-8">
                            <div class="section-header px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 icon-medium-green rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Basic Organazational Information</h3>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-8">
                                    <div class="space-y-6">
                                        <!-- Contact Information -->
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="space-y-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="p-2 bg-green-600 text-white rounded-lg mt-1">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M22.675 0h-21.35C.595 0 0 .593 0 1.326v21.348C0 23.407.595 24 1.326 24H12.82V14.706h-3.13v-3.622h3.13V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.463.099 2.794.143v3.24l-1.918.001c-1.504 0-1.796.716-1.796 1.765v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.405 24 24 23.407 24 22.674V1.326C24 .593 23.405 0 22.675 0z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900 mb-1">Facebook</h4>
                                                        <p class="text-gray-700">{{ $membership->facebook ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="flex items-start gap-3">
                                                    <div class="p-2 bg-green-600 text-white rounded-lg mt-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <circle cx="12" cy="12" r="10"
                                                                stroke-width="2" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900 mb-1">Website</h4>
                                                        <p class="text-gray-700">{{ $membership->website ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="space-y-4">
                                                @if (!empty($membership->director_phone) || !empty($membership->alt_phone))
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900 mb-2">Phone Numbers</h4>
                                                        <div class="space-y-2">
                                                            @if (!empty(trim($membership->director_phone)))
                                                                <div class="flex items-center gap-2">
                                                                    <svg class="w-4 h-4 text-gray-600" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                                        </path>
                                                                    </svg>
                                                                    <span
                                                                        class="text-gray-600">{{ $membership->director_phone }}</span>
                                                                </div>
                                                            @endif

                                                            @if (!empty(trim($membership->alt_phone)))
                                                                <div class="flex items-center gap-2">
                                                                    <svg class="w-4 h-4 text-gray-600" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                                        </path>
                                                                    </svg>
                                                                    <span
                                                                        class="text-gray-600">{{ $membership->alt_phone }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="space-y-4">

                                                <div class="flex items-start gap-3">
                                                    <div class="p-2 bg-green-600 text-white rounded-lg mt-1">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M22.23 0H1.77C.79 0 0 .774 0 1.728v20.544C0 23.226.79 24 1.77 24h20.46c.98 0 1.77-.774 1.77-1.728V1.728C24 .774 23.21 0 22.23 0zM7.119 20.452H3.56V9h3.559v11.452zM5.34 7.433c-1.14 0-2.063-.928-2.063-2.072 0-1.144.923-2.071 2.063-2.071 1.14 0 2.063.927 2.063 2.071 0 1.144-.923 2.072-2.063 2.072zM20.452 20.452h-3.559v-5.605c0-1.336-.027-3.057-1.863-3.057-1.864 0-2.149 1.454-2.149 2.958v5.704H9.322V9h3.414v1.561h.049c.476-.9 1.637-1.849 3.368-1.849 3.6 0 4.266 2.37 4.266 5.455v6.285z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900 mb-1">LinkedIn</h4>
                                                        <p class="text-gray-700">{{ $membership->linkedin ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- File Location --}}
                                        <div>
                                            <div class="flex items-center gap-2 mb-4">
                                                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <h4 class="font-semibold text-lg text-green-900">Target Program Areas
                                                </h4>
                                            </div>
                                            <div>
                                                @if (!empty($membership->basicInformation?->file))
                                                    <a href="{{ asset('storage/' . $membership->basicInformation->file) }}"
                                                        target="_blank"
                                                        class="file-link inline-flex items-center gap-2 px-3 py-2 text-gray-700 rounded-lg text-sm font-medium">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                            </path>
                                                        </svg>
                                                        Location File
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 italic">No location file available</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Files Section -->
                                        <div>
                                            @if ($membership->membershipUploads->count())
                                                @foreach ($membership->membershipUploads as $app)
                                                    <div class="flex items-center gap-2 mb-4">
                                                        <svg class="w-5 h-5 text-green-700" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                            </path>
                                                        </svg>
                                                        <h4 class="font-semibold text-lg text-green-900">Uploaded Documents
                                                        </h4>
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                                                        @foreach ([
            'letter' => 'Letter',
            'constitution' => 'Constitution',
            'activities' => 'Activities',
            'funding' => 'Funding',
            'board' => 'Borad',
            'authorization' => 'Authorization',
            'strategic_plan' => 'Strategic Plan',
            'fundraising_strategy' => 'Fundraising Strategy',
            'audit_report' => 'Audit Report',
            'signature' => 'Signature',
        ] as $field => $label)
                                                            @if (!empty($app->$field))
                                                                <a href="{{ asset('storage/' . $app->$field) }}"
                                                                    target="_blank"
                                                                    class="file-link inline-flex items-center gap-2 px-3 py-2 text-gray-700 rounded-lg text-sm font-medium">
                                                                    <svg class="w-4 h-4" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                        </path>
                                                                    </svg>
                                                                    {{ $label }}
                                                                    <svg class="w-3 h-3" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                                        </path>
                                                                    </svg>
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        @endforeach
    </div>
@endsection
