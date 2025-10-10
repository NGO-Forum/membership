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
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">
                            {{ $membership->org_name_en ?? 'N/A' }}
                        </h1>
                        <p class="text-gray-700 text-lg">Membership Details & Information</p>
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
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="overview-card rounded-xl card-shadow border border-gray-200 p-6 animate-fade-in">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 icon-dark-green rounded-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Director</h3>
                                        <p class="text-gray-700">{{ $membership->director_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="overview-card rounded-xl card-shadow border border-gray-200 p-6 animate-fade-in animate-delay-1">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 icon-medium-green rounded-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Contact User</h3>
                                        <p class="text-gray-700">{{ optional($membership->user)->email ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="overview-card rounded-xl card-shadow border border-gray-200 p-6 animate-fade-in animate-delay-2">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 icon-earthy-green rounded-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14-7H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Position</h3>
                                        <p class="text-gray-700">Director</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                            <!-- Networks Section -->
                            <div
                                class="bg-white rounded-xl card-shadow border border-gray-200 overflow-hidden animate-fade-in animate-delay-1">
                                <div class="section-header px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 icon-earthy-green rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14-7H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900">Networks</h3>
                                    </div>
                                </div>
                                <div class="p-6">
                                    @php
                                        $uploads = $membership->membershipUploads ?? collect();
                                    @endphp

                                    @if ($uploads->isNotEmpty())
                                        <div class="space-y-3">
                                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                                                @foreach ($uploads as $upload)
                                                    @if (!empty($upload->networks) && count($upload->networks))
                                                        @foreach ($upload->networks as $network)
                                                            <div
                                                                class="network-item flex items-center gap-3 p-3 rounded-lg">
                                                                <div
                                                                    class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0">
                                                                </div>
                                                                <span
                                                                    class="text-gray-800 font-medium">{{ $network->network_name }}</span>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-gray-600 italic">No networks available.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Focal Points Section -->
                            <div
                                class="bg-white rounded-xl card-shadow border border-gray-200 overflow-hidden animate-fade-in animate-delay-2">
                                <div class="section-header px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 icon-dark-green rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900">Focal Points</h3>
                                    </div>
                                </div>
                                <div class="p-6">
                                    @if ($uploads->isNotEmpty())
                                        @foreach ($uploads as $upload)
                                            @php
                                                $focals = $upload->focalPoints ?? collect();
                                            @endphp

                                            @if ($focals->isNotEmpty())
                                                <div class="space-y-4">
                                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                                                        @foreach ($focals as $focal)
                                                            <div class="focal-point-card p-4 rounded-lg">
                                                                <h4 class="font-semibold text-gray-900">{{ $focal->name }}
                                                                </h4>
                                                                <p class="text-gray-600 font-medium">{{ $focal->position }}
                                                                </p>
                                                                <p class="text-gray-700 text-sm">{{ $focal->network_name }}
                                                                </p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-gray-600 italic">No focal points available.</p>
                                            @endif
                                        @endforeach
                                    @else
                                        <p class="text-gray-600 italic">No focal points available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Applications Section -->
                        <div
                            class="bg-white rounded-xl card-shadow border border-gray-200 overflow-hidden mb-8 animate-fade-in animate-delay-3">
                            <div class="section-header px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 icon-medium-green rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Applications</h3>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-8">
                                    <div class="space-y-6">
                                        <!-- Contact Information -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="space-y-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="p-2 bg-green-600 text-white rounded-lg mt-1">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900 mb-1">Facebook</h4>
                                                        <p class="text-gray-700">{{ $membership->social_media ?? 'N/A' }}
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
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                                        @foreach ([
                                                            'letter' => 'Letter',
                                                            'mission_vision' => 'Mission & Vision',
                                                            'constitution' => 'Constitution',
                                                            'activities' => 'Activities',
                                                            'funding' => 'Funding',
                                                            'authorization' => 'Authorization',
                                                            'strategic_plan' => 'Strategic Plan',
                                                            'fundraising_strategy' => 'Fundraising Strategy',
                                                            'signature' => 'Signature',
                                                            'audit_report' => 'Audit Report',
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
