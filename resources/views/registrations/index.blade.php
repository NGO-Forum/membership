@extends('layouts.app')
@section('content')

    <div class="max-w-full mx-auto mt-2 bg-white rounded-xl shadow-lg overflow-x-auto">
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 sm:p-6 bg-green-600 text-white rounded-t-xl">
            <h2 class="text-xl sm:text-2xl font-bold">
                All Register Events
            </h2>
        </div>

        @if ($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-emerald-200 text-sm sm:text-base">
                    <thead class="bg-emerald-100 text-emerald-600">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                Start
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                End
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                Location
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                Organizer
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                Total Registrations
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($events as $event)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 sm:px-6 py-3 sm:py-4 font-medium text-gray-900">
                                    @if (strlen($event->title) > 30)
                                        {{ substr($event->title, 0, 30) . '...' }}
                                    @else
                                        {{ $event->title }}
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-gray-600">
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-gray-600">
                                    {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-gray-600">
                                    {{ $event->location ?? '-' }}</td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-gray-600">
                                    {{ $event->organizer ?? '-' }}</td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-600 text-center">
                                    {{ $event->registrations->count() }}
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center text-sm text-gray-700 relative">
                                    <div x-data="{ open: false }" class="inline-block text-left">

                                        <!-- Kebab Menu Button -->
                                        <button @click="open = !open"
                                            class="p-2 rounded hover:bg-gray-200 transition focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="1.5" />
                                                <circle cx="12" cy="12" r="1.5" />
                                                <circle cx="12" cy="19" r="1.5" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div x-show="open" @click.away="open = false"
                                            class="absolute right-2 sm:right-8 -mt-6 w-20 bg-white border border-gray-200 rounded-lg shadow-xl z-10 flex flex-col p-1 space-y-1 text-sm">
                                            <!-- View Details -->
                                            <a href="{{ route('registrations.showAll', $event->id) }}"
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
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="p-8 text-center text-gray-500 text-lg">No events found.</p>
        @endif
    </div>

@endsection
