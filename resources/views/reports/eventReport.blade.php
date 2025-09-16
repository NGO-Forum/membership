@extends('layouts.app')

@section('title', 'Event Reports')

@section('content')
    <div class="min-h-screen max-w-full mx-auto">
        <div class="border-b border-gray-200 pb-4">
            <h1 class="text-3xl lg:text-4xl font-bold text-green-700 mb-2">
                Event Reports
            </h1>
        </div>
        <div
            class="bg-white rounded-lg card-shadow border border-gray-200 overflow-hidden mb-8 animate-fade-in animate-delay-3">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-600">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-white text-gray-700 uppercase tracking-wider">
                            #
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-white text-gray-700 uppercase tracking-wider">
                            Name
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-white text-gray-700 uppercase tracking-wider">
                            Email
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-white text-gray-700 uppercase tracking-wider">
                            Phone
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-white text-gray-700 uppercase tracking-wider">
                            Position</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-white text-gray-700 uppercase tracking-wider">
                            Events Name</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-white text-gray-700 uppercase tracking-wider">
                            Date</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-white text-gray-700 uppercase tracking-wider">
                            Location</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($registrations as $i => $reg)
                        <tr class="hover:bg-green-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $i + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $reg->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $reg->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $reg->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $reg->position }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $reg->event->title ?? 'No Event' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                @if ($reg->event->start_date == $reg->event->end_date)
                                    {{ \Carbon\Carbon::parse($reg->event->start_date)->format('M d, Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($reg->event->start_date)->format('M d, Y') }}
                                    –
                                    {{ \Carbon\Carbon::parse($reg->event->end_date)->format('M d, Y') }}
                                @endif</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                @if (strlen($reg->event->location ?? 'N/A') > 25)
                                    {{ substr($reg->event->location, 0, 25) . '...' }}
                                @else
                                    {{ $reg->event->location ?? 'N/A' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
