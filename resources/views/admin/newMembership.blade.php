@extends('layouts.app')

@section('title', 'Memberships')

@section('content')
    <div class="max-w-full mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-semibold text-green-700">All Memberships</h1>
        </div>

        @if ($newMemberships->count())
            <div class="overflow-x-auto rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                <table class="min-w-full divide-y divide-green-200 bg-white border-collapse">
                    <thead class="bg-green-600 text-white sticky top-0">
                        <tr>
                            @foreach (['ID', 'NGO Name', 'Director', 'Email', 'Networks', 'Type', 'Date', 'Applications'] as $head)
                                <th class="px-2 py-2 md:px-6 md:py-3 text-xs font-bold uppercase tracking-wider border">
                                    {{ $head }}
                                </th>
                            @endforeach
                            <th class="px-2 py-2 md:px-4 md:py-3 text-xs font-bold uppercase tracking-wider border">
                                    Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($newMemberships as $membership)
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-2 py-2 md:px-4 md:py-3 text-center border text-sm">{{ str_pad($membership->user->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-3 border text-sm">{{ $membership->org_name_en }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-3 border text-sm">{{ $membership->director_name }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-3 border break-words text-sm">{{ $membership->director_email }}</td>

                                {{-- Networks --}}
                                <td class="px-2 py-2 md:px-6 md:py-3 border max-w-xs text-sm">
                                    <div class="max-h-16 overflow-y-auto">
                                        @foreach ($membership->membershipUploads as $upload)
                                            @foreach ($upload->networks as $network)
                                                <span
                                                    class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs mb-1">
                                                    {{ $network->network_name }}
                                                </span><br>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </td>

                                {{-- Focal Points --}}
                                <td class="px-2 py-2 md:px-6 md:py-3 text-center border max-w-xs text-sm">
                                    {{ $membership->membership_type }}
                                </td>

                                {{-- Date --}}
                                <td class="px-2 py-2 md:px-6 md:py-3 text-center border text-sm">
                                    @foreach ($membership->membershipUploads as $upload)
                                        {{ $upload->created_at->format('d M Y') }}<br>
                                    @endforeach
                                </td>

                                {{-- Applications --}}
                                <td class="px-2 py-2 md:px-6 md:py-3 border text-sm">
                                    <div class="max-h-16 overflow-y-auto space-y-2">
                                        @foreach ($membership->membershipUploads as $upload)
                                            <div class="border rounded p-2 mb-2 bg-gray-50 shadow-sm">
                                                <ul class="list-disc list-inside space-y-1 text-green-700">
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
                                                        @if (!empty($upload->$field))
                                                            @php
                                                                $fileUrl = asset('storage/' . $upload->$field);
                                                                $extension = strtolower(
                                                                    pathinfo($fileUrl, PATHINFO_EXTENSION),
                                                                );
                                                                $isImage = in_array($extension, [
                                                                    'jpg',
                                                                    'jpeg',
                                                                    'png',
                                                                    'gif',
                                                                    'webp',
                                                                ]);
                                                                $isDoc = in_array($extension, ['doc', 'docx', 'pdf']);
                                                                $link = $isDoc
                                                                    ? 'https://docs.google.com/gview?url=' .
                                                                        urlencode($fileUrl) .
                                                                        '&embedded=true'
                                                                    : $fileUrl;
                                                            @endphp

                                                            <li>
                                                                @if ($field === 'signature' && $isImage)
                                                                    <img src="{{ $fileUrl }}" alt="Signature"
                                                                        class="h-16 border rounded">
                                                                @else
                                                                    <a href="{{ $extension === 'pdf' ? $fileUrl : $link }}"
                                                                        target="_blank"
                                                                        class="underline hover:text-green-900">
                                                                        {{ $label }}{{ $isDoc ? ' (Preview)' : '' }}
                                                                    </a>
                                                                @endif
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                {{-- Action Buttons --}}
                                <td class="px-2 py-2 md:px-4 md:py-3 text-center text-sm border text-gray-700">
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
                                            <a href="{{ route('admin.newShowMembership', $membership->id) }}"
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
                                            <a href="{{ route('admin.editNewMembership', $membership->id) }}"
                                                class="flex items-center px-2 py-1 text-sm text-green-700 hover:bg-green-100 rounded transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                                        class="px-2 py-2 md:px-6 md:py-3 bg-orange-300 text-white rounded hover:bg-orange-400">Cancel</button>
                                                    <form action="{{ route('admin.destroy', $membership->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-2 py-2 md:px-6 md:py-3 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
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
        @else
            <p class="text-center text-gray-600 mt-6">No memberships found.</p>
        @endif
    </div>
@endsection
