@extends('layouts.app')

@section('title', 'Memberships')

@section('content')
    <div class="max-w-full mx-auto">
        <div class="flex justify-between items-center mb-4">
            {{-- Breadcrumbs --}}
            {{-- Page Title --}}
            <h1 class="text-xl md:text-3xl font-semibold text-green-700">All Memberships</h1>
            {{-- Tailwind Export Dropdown --}}
            <div x-data="{ open: false }" class="inline-block text-left">
                <button @click="open = !open" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-1 bg-green-600 text-white text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    aria-haspopup="true" :aria-expanded="open.toString()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4l-8 8 4 4 8-8" />
                    </svg>
                    Export
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="origin-top-right absolute right-0 mt-2 w-28 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                    role="menu" aria-orientation="vertical" aria-labelledby="export-menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <a href="{{ route('memberships.exportPDF') }}"
                            class="text-gray-700 px-4 py-2 text-sm hover:bg-green-100 flex items-center space-x-2"
                            role="menuitem" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M12 2L3 7v13h18V7l-9-5zM11 18v-6h2v6h-2z" />
                            </svg>
                            <span>PDF</span>
                        </a>
                        <a href="{{ route('memberships.exportExcel') }}"
                            class="text-gray-700 px-4 py-2 text-sm hover:bg-green-100 flex items-center space-x-2"
                            role="menuitem" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M5 4h14v16H5zM9 8v8M15 8v8" stroke="#fff" stroke-width="2" />
                            </svg>
                            <span>Excel</span>
                        </a>
                        <a href="{{ route('memberships.exportWord') }}"
                            class="text-gray-700 px-4 py-2 text-sm hover:bg-green-100 flex items-center space-x-2"
                            role="menuitem" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M5 4h14v16H5zM7 8h10M7 12h10M7 16h10" stroke="#fff" stroke-width="2" />
                            </svg>
                            <span>Word</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Memberships Table --}}
        @if ($memberships->count())
            <div class="overflow-x-auto rounded-lg shadow ring-1 ring-black ring-opacity-5">
                <table class="min-w-full divide-y divide-green-500 bg-white">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th
                                class="px-2 py-2 md:px-6 md:py-3 text-xs md:text-sm font-semibold border uppercase tracking-wider">
                                ID</th>
                            <th
                                class="px-2 py-2 md:px-6 md:py-3 text-xs md:text-sm font-semibold border uppercase tracking-wider">
                                NGO Name</th>
                            <th
                                class="px-2 py-2 md:px-6 md:py-3 text-xs md:text-sm font-semibold border uppercase tracking-wider">
                                Director</th>
                            <th
                                class="px-2 py-2 md:px-6 md:py-3 text-xs md:text-sm font-semibold border uppercase tracking-wider">
                                Email</th>
                            <th
                                class="px-2 py-2 md:px-6 md:py-3 text-xs md:text-sm font-semibold border uppercase tracking-wider">
                                Phone</th>
                            <th
                                class="px-2 py-2 md:px-6 md:py-3 text-xs md:text-sm font-semibold border uppercase tracking-wider">
                                Networks</th>
                            <th
                                class="px-2 py-2 md:px-6 md:py-3 text-xs md:text-sm font-semibold border uppercase tracking-wider">
                                Date</th>
                            <th
                                class="px-2 py-2 md:px-6 md:py-3 text-xs md:text-sm font-semibold border uppercase tracking-wider">
                                Applications</th>
                            <th
                                class="px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm font-semibold border uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-green-200">
                        @foreach ($memberships as $membership)
                            <tr class="hover:bg-gray-50">
                                <td class="px-2 py-2 md:px-6 md:py-3 whitespace-normal text-sm border text-gray-700">
                                    {{ str_pad($membership->user->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-3 whitespace-normal text-sm border text-gray-700">
                                    {{ $membership->ngo_name ?? 'N/A' }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-3 whitespace-normal text-sm border text-gray-700">
                                    {{ $membership->director_name ?? 'N/A' }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-3 whitespace-nowrap text-sm border text-gray-700">
                                    {{ $membership->director_email ?? 'N/A' }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-3 whitespace-nowrap text-sm border text-gray-700">
                                    {{ $membership->alt_phone ?? 'N/A' }}</td>
                                <td
                                    class="px-2 py-2 md:px-6 md:py-3 whitespace-normal text-sm border max-h-26 overflow-y-auto text-gray-700">
                                    @if ($membership->networks->count())
                                        <ul class="list-disc list-inside space-y-1 max-h-28 overflow-auto">
                                            @foreach ($membership->networks as $network)
                                                {{ $network->network_name }}
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="italic text-gray-400">No networks</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 md:px-6 md:py-3 whitespace-nowrap text-sm border text-gray-700">
                                    {{ optional($membership->created_at)->format('d M Y') ?? 'N/A' }}</td>
                                <td
                                    class="px-2 py-2 md:px-6 md:py-3 whitespace-normal text-sm border text-gray-700 max-h-12 w-1/5 overflow-y-auto">
                                    @if ($membership->applications->count())
                                        <ul class="list-disc list-inside space-y-4 max-h-12 overflow-auto">
                                            @foreach ($membership->applications as $app)
                                                <div class="border rounded p-3 bg-gray-50">
                                                    <p><strong>Date:</strong> {{ $app->date?->format('d M Y') ?? 'N/A' }}
                                                    </p>
                                                    <p><strong>Mailing Address:</strong>
                                                        {{ $app->mailing_address ?? 'N/A' }}</p>

                                                    <p><strong>Facebook:</strong> {{ $app->facebook ?? 'N/A' }}</p>

                                                    <p><strong>Website:</strong>
                                                        <a href="{{ $app->website }}" target="_blank"
                                                            class="text-blue-600 hover:underline">
                                                            {{ $app->website ?? 'N/A' }}
                                                        </a>
                                                    </p>


                                                    <p><strong>Communication Channels:</strong>
                                                        @if (is_array($app->comm_channels) && count($app->comm_channels))
                                                            {{ implode(', ', $app->comm_channels) }}
                                                        @else
                                                            None
                                                        @endif
                                                    </p>

                                                    <p><strong>Communication Phones:</strong></p>
                                                    @if (is_array($app->comm_phones) && count($app->comm_phones))
                                                        <ul class="list-disc list-inside ml-4">
                                                            @foreach (array_slice($app->comm_phones, 0, 3) as $channel => $phone)
                                                                <li>
                                                                    {{ ucfirst($channel) }}:
                                                                    <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}"
                                                                        class="text-blue-600 hover:underline">
                                                                        {{ $phone }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="italic text-gray-400 ml-4">None</p>
                                                    @endif

                                                    <p><strong>Vision:</strong> {{ $app->vision ?? 'N/A' }}</p>
                                                    <p><strong>Mission:</strong> {{ $app->mission ?? 'N/A' }}</p>
                                                    <p><strong>Goal:</strong> {{ $app->goal ?? 'N/A' }}</p>

                                                    <div class="mt-2">
                                                        <strong>Files:</strong>
                                                        <ul class="list-disc list-inside text-blue-600 space-y-1">
                                                            @foreach ([
                                                                'letter' => 'Letter',
                                                                'constitution' => 'Constitution',
                                                                'activities' => 'Activities',
                                                                'funding' => 'Funding',
                                                                'registration' => 'Registration',
                                                                'strategic_plan' => 'Strategic Plan',
                                                                'fundraising_strategy' => 'Fundraising Strategy',
                                                                'audit_report' => 'Audit Report',
                                                                'signature' => 'Signature',
                                                            ] as $field => $label)
                                                                @if (!empty($app->$field))
                                                                    @php
                                                                        $fileUrl = asset('storage/' . $app->$field);
                                                                        $extension = strtolower(
                                                                            pathinfo($fileUrl, PATHINFO_EXTENSION),
                                                                        );
                                                                    @endphp
                                                                    <li>
                                                                        @if ($extension === 'pdf')
                                                                            <!-- Direct PDF link -->
                                                                            <a href="{{ $fileUrl }}" target="_blank"
                                                                                class="underline hover:text-blue-800">
                                                                                {{ $label }}
                                                                            </a>
                                                                        @elseif (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                                                                            <!-- Use Google Docs Viewer for Office files -->
                                                                            <a href="https://docs.google.com/gview?url={{ urlencode($fileUrl) }}&embedded=true"
                                                                                target="_blank"
                                                                                class="underline hover:text-blue-800">
                                                                                {{ $label }} (Preview)
                                                                            </a>
                                                                        @else
                                                                            <!-- For images or other file types, just open normally -->
                                                                            <a href="{{ $fileUrl }}" target="_blank"
                                                                                class="underline hover:text-blue-800">
                                                                                {{ $label }}
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="italic text-gray-400">No applications</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 md:px-6 md:py-3 text-center text-sm border text-gray-700">
                                    <div x-data="{ open: false }" class="inline-block text-left">

                                        <!-- Kebab Menu Button -->
                                        <button @click="open = !open"
                                            class="p-2 rounded hover:bg-gray-200 transition focus:outline-none focus:ring focus:ring-blue-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="1.5" />
                                                <circle cx="12" cy="12" r="1.5" />
                                                <circle cx="12" cy="19" r="1.5" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div x-show="open" @click.away="open = false"
                                            class="absolute right-8 -mt-3 w-16 md:w-24 bg-white border rounded shadow-lg z-10 flex flex-col p-1 space-y-1">

                                            <!-- View Details -->
                                            <a href="{{ route('admin.show', $membership->id) }}"
                                                class="flex items-center px-2 py-1 text-sm text-blue-700 hover:bg-blue-100 rounded transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('admin.edit', $membership->id) }}"
                                                class="flex items-center px-2 py-1 text-sm text-green-700 hover:bg-green-100 rounded transition">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-green-500 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- Delete -->
                                            <button @click="open = false; $refs.deleteModal.classList.remove('hidden')"
                                                class="flex items-center px-2 py-1 text-sm text-red-600 hover:bg-red-100 rounded transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                                </svg>
                                                Delete
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div x-ref="deleteModal"
                                            class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                            <div class="bg-white rounded-lg shadow-xl w-80 md:w-96 p-6">
                                                <div class="flex flex-col items-center mb-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-16 w-16 text-red-600 mb-2" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01M4.93 19h14.14c1.1 0 1.75-1.18 1.25-2.09l-7.07-12.17a1.5 1.5 0 00-2.56 0L3.68 16.91c-.5.91.14 2.09 1.25 2.09z" />
                                                    </svg>
                                                    <h2 class="text-xl font-bold text-gray-800">Confirm Deletion</h2>
                                                </div>
                                                <p class="text-gray-600 mb-6 text-center">Are you sure you want to delete
                                                    this membership?</p>
                                                <div class="flex justify-end space-x-2">
                                                    <button @click="$refs.deleteModal.classList.add('hidden')"
                                                        class="px-4 py-2 bg-orange-300 text-white rounded hover:bg-orange-400">Cancel</button>
                                                    <form action="{{ route('admin.destroy', $membership->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-center">
                {{ $memberships->links() }}
            </div>
        @else
            <p class="text-center text-gray-600">No memberships found.</p>
        @endif
    </div>
@endsection
