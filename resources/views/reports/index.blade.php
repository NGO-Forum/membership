@extends('layouts.app')

@section('content')
    <div class="container mx-auto bg-white p-10 shadow-lg rounded-lg leading-relaxed text-justify">

        {{-- Header --}}
        <div class="flex justify-center flex-col items-center mb-8">
            <img src="/logo.png" alt="image" class="w-64 h-40 mb-8">
            <h2 class="text-xl font-bold italic text-center mb-1">Assessment Report</h2>
            <p class="text-xl font-bold italic text-center mb-1">Submitted to board of Directors</p>
            <p class="text-xl font-bold italic text-center mb-1">of NGO Forum on Cambodia</p>
        </div>


        {{-- Section 1: Summary --}}
        <h3 class="text-2xl text-green-700 font-bold mb-3">1. Summary</h3>
        <div class="mb-2">

            @if ($canEdit)
                <form method="POST" action="{{ route('reports.update', $report) }}">
                    @csrf @method('PUT')
                    <textarea name="summary_html" rows="16" class="w-full border rounded p-4 mb-3">
                            {{ old('summary_text', $summary_text) }}
                        </textarea>
                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Save
                    </button>
                </form>
            @else
                {!! $report->summary_html['html'] ?? '<em>Not generated yet</em>' !!}
            @endif
        </div>


        {{-- Section 2: Information --}}
        <h3 class="text-2xl text-green-700 font-bold mt-8 mb-3">2. Information about Applicant</h3>
        <p class="mb-2">The followings are the overall assessment based on submitted documents as compared with the
            required check list stated below:</p>

        <h4 class="font-bold mb-2 text-green-600">AA) Basic Information about NGO Applicant</h4>
        <table class="w-full border border-gray-400 text-sm mb-6">
            <tbody>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Name of Organization</td>
                    <td class="border px-2 py-2">{{ $membership->org_name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Logo</td>
                    <td class="border px-2 py-2">
                        @if ($membership->membershipUploads->first() && $membership->membershipUploads->first()->logo)
                            <img src="{{ Storage::url($membership->membershipUploads->first()->logo) }}" alt="Logo"
                                width="200">
                        @else
                            <span class="text-gray-500 italic">No logo uploaded</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Type of NGO</td>
                    <td class="border px-2 py-2">{{ $membership->assessmentReport->ngo_type ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Vision</td>
                    <td class="border px-2 py-2">{{ $membership->assessmentReport->vision ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Mission</td>
                    <td class="border px-2 py-2">{{ $membership->assessmentReport->mission ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Year Established</td>
                    <td class="border px-2 py-2">
                        {{ optional($membership->assessmentReport->established_date)->format('d F Y') ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Address</td>
                    <td class="border px-2 py-2">{{ $membership->assessmentReport->address ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Name of Director</td>
                    <td class="border px-2 py-2">{{ $membership->director_name }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Email of Director</td>
                    <td class="border px-2 py-2">{{ $membership->director_email }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Phone of Director</td>
                    <td class="border px-2 py-2">{{ $membership->director_phone }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Key Actions</td>
                    <td class="border px-2 py-2">
                        <ul class="list-disc ml-6">
                            @php
                                $actions = $membership->assessmentReport->key_actions ?? null;
                                $actions = is_string($actions) ? json_decode($actions, true) : $actions;
                            @endphp

                            @forelse ($actions ?? [] as $action)
                                <li>{{ $action }}</li>
                            @empty
                                <li>N/A</li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        <h4 class="font-bold mb-2 text-green-600">
            BB) Meeting Requirements being a member of NGOF
        </h4>

        <table class="w-full border border-green-400 text-sm mb-6">
            <thead>
                <tr class="bg-green-200 text-center">
                    <th class="border px-2 py-2">Item</th>
                    <th class="border px-2 py-2">Description</th>
                    <th class="border px-2 py-2">Rating (1–5)</th>
                    <th class="border px-2 py-2">Comments</th>
                    <th class="border px-2 py-2">Files</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($report->checklist_json ?? [] as $index => $item)
                    <tr>
                        <td class="border w-12 text-center">
                            {{ $index + 1 }}
                        </td>

                        <td class="border w-[30%] text-base px-2 py-2 font-semibold">
                            {{ $item['label'] }}
                        </td>

                        <td class="border text-center w-16 font-semibold">
                            {{ $item['rating'] }}
                        </td>

                        <td class="border px-2 py-2">
                            {{ $item['comment'] }}
                        </td>

                        <td class="border w-[12%] px-2 py-2 text-center">
                            @if (!empty($item['file_url']))
                                <a href="{{ $item['file_url'] }}" target="_blank"
                                    class="text-blue-600 underline font-medium">
                                    View File
                                </a>
                            @else
                                <span class="text-gray-500 italic">
                                    Not submitted
                                </span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="font-bold mb-2 text-green-600">CC) Type of Membership / Fee</h4>
        <table class="w-full border border-green-400 text-sm mb-6">
            <tbody>
                <tr>
                    <td class="border w-12 text-center">10</td>
                    <td class="border w-[30%] px-2 py-2 font-semibold">Applying for</td>
                    <td class="border px-2 py-2">{{ $membership->membership_type }}</td>
                </tr>
                <tr>
                    <td class="border w-12 text-center">11</td>
                    <td class="border w-[30%] px-2 py-2 font-semibold">Membership fee</td>
                    <td class="border px-2 py-2">${{ $membership->assessmentReport->membership_fee ?? 'N/A' }} per year
                    </td>
                </tr>
            </tbody>
        </table>

        <h4 class="font-bold mb-2 text-green-600">DD) Interest in attending network meetings</h4>
        <table class="w-full border border-green-400 text-sm mb-6">
            @php
                $upload = $membership->membershipUploads->first();
            @endphp

            <tbody>
                @foreach ($upload->networks ?? [] as $index => $network)
                    @php
                        // Find focal point for this network
                        $focalPoint = $upload->focalPoints->where('network_name', $network->network_name)->first();

                        // Network full names
                        $networkNames = [
                            'NECCAW' => 'Network of Environment, Climate Change, Agriculture and Water',
                            'BWG' => 'Budget Working Group',
                            'RCC' => 'Rivers Coalition of Cambodia',
                            'NRLG' => 'Natural Resources and Land Governance',
                            'GGESI' => 'Gender, Governance, Environment and Social Inclusion',
                        ];
                    @endphp

                    <tr>
                        <td class="border w-12 text-center">
                            {{ 12 + $index }}
                        </td>

                        <td class="border w-[30%] px-2 py-2 font-semibold">
                            {{ $networkNames[$network->network_name] ?? $network->network_name }}
                            ({{ $network->network_name }})
                        </td>

                        <td class="border px-2 py-2">
                            {{ $focalPoint->summaries ?? 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>


        {{-- Section 3: Conclusions --}}
        <h3 class="text-2xl text-green-700 font-bold mb-3">3. Conclusions and Recommendations</h3>
        <div class="text-[16px] leading-relaxed text-black">
            @if ($canEdit)
                <form method="POST" action="{{ route('reports.update', $report) }}">
                    @csrf @method('PUT')
                    <textarea name="conclusion_html" rows="30" class="w-full border rounded p-4 mb-3">
                            {{ old('conclusion_text', $conclusion_text) }}
                        </textarea>
                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Save
                    </button>
                </form>
            @else
                {!! $report->conclusion_html['html'] ?? '<em>Not generated yet</em>' !!}
            @endif
        </div>

        {{-- APPROVAL BUTTONS WITH SIGNATURE --}}
        @if ($canApproveManager || $canApproveED || $canApproveBoard)
            <div class="mt-20 border-t pt-10">
                {{-- Approval Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">

                    {{-- MANAGER --}}
                    @if ($canApproveManager)
                        <form method="POST" action="{{ route('reports.approve.manager', $report) }}"
                            enctype="multipart/form-data"
                            class="bg-green-50 border border-green-300 rounded-xl p-6 shadow-md">

                            @csrf

                            <h4 class="text-lg font-bold text-green-800 mb-4 text-center">
                                Program Manager
                            </h4>

                            {{-- <label class="block text-sm font-medium mb-2">
                                Upload Signature
                            </label>

                            <input type="file" name="signature" accept="image/*"
                                class="block w-full text-sm mb-5
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-green-600 file:text-white
                                  hover:file:bg-green-700"> --}}

                            <button
                                class="w-full bg-green-700 hover:bg-green-800
                               text-white font-semibold py-2.5 rounded-lg transition">
                                Approve
                            </button>
                        </form>
                    @endif

                    {{-- EXECUTIVE DIRECTOR --}}
                    @if ($canApproveED)
                        <form method="POST" action="{{ route('reports.approve.ed', $report) }}"
                            enctype="multipart/form-data"
                            class="bg-blue-50 border border-blue-300 rounded-xl p-6 shadow-md">

                            @csrf

                            <h4 class="text-lg font-bold text-blue-800 mb-4 text-center">
                                Executive Director
                            </h4>

                            {{-- <label class="block text-sm font-medium mb-2">
                                Upload Signature
                            </label>

                            <input type="file" name="signature" accept="image/*"
                                class="block w-full text-sm mb-5
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-600 file:text-white
                                  hover:file:bg-blue-700"> --}}

                            <button
                                class="w-full bg-blue-700 hover:bg-blue-800
                               text-white font-semibold py-2.5 rounded-lg transition">
                                Approve
                            </button>
                        </form>
                    @endif

                    {{-- BOARD --}}
                    @if ($canApproveBoard)
                        <form method="POST" action="{{ route('reports.approve.board', $report) }}"
                            enctype="multipart/form-data"
                            class="bg-purple-50 border border-purple-300 rounded-xl p-6 shadow-md">

                            @csrf

                            <h4 class="text-lg font-bold text-purple-800 mb-4 text-center">
                                Board of Directors
                            </h4>

                            {{-- <label class="block text-sm font-medium mb-2">
                                Upload Signature
                            </label>

                            <input type="file" name="signature" accept="image/*"
                                class="block w-full text-sm mb-5
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-purple-600 file:text-white
                                  hover:file:bg-purple-700"> --}}

                            <button
                                class="w-full bg-purple-700 hover:bg-purple-800
                               text-white font-semibold py-2.5 rounded-lg transition">
                                Endorse
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        @endif

    </div>
@endsection
