@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-green-600 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">All Registrations</h2>
                    <p class="text-green-100 mt-1">Total: {{ $registrations->count() }} registrants</p>
                </div>
                <div>
                    <a href="{{ url()->previous() }}"
                        class="bg-white text-green-600 font-semibold px-4 py-2 rounded hover:bg-gray-100">
                        ← Back
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Organization</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Events Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Registered At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($registrations as $i => $reg)
                            <tr class="hover:bg-green-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->organization }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->position }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->event->title ?? 'No Event' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                        @if ($registrations->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No registrations yet.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
