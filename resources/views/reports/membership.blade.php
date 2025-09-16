@extends('layouts.app')

@section('title', 'Memberships')

@section('content')
    <div class="max-w-full mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-semibold text-green-700">Report Memberships</h1>
        </div>

        @if ($newMemberships->count())
            <div class="overflow-x-auto rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                <table class="min-w-full divide-y divide-green-200 bg-white border-collapse">
                    <thead class="bg-green-600 text-white sticky top-0">
                        <tr>
                            @foreach (['ID', 'NGO Name', 'Director', 'Email', 'Type', 'Date', 'Status'] as $head)
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
                                <td class="px-2 py-2 md:px-4 md:py-3 text-center border text-sm">
                                    {{ str_pad($membership->user->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-3 border text-sm">{{ $membership->org_name_en }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-3 border text-sm">{{ $membership->director_name }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-3 border break-words text-sm">
                                    {{ $membership->director_email }}</td>

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

                                <td class="px-2 py-2 md:px-4 md:py-3 text-center text-sm border">
                                    <span class="bg-green-600 text-white font-semibold py-1 px-2 rounded-lg">{{ $membership->status }}</span>
                                </td>
                                <td class="px-2 py-2 md:px-4 md:py-3 text-center text-sm border text-gray-700">
                                    <a href="{{ route('reports.show', $membership->id) }}" class="bg-blue-600 text-white py-1 px-2 rounded-lg">View</a>
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
