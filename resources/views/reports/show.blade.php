@extends('layouts.app')

@section('content')
    <div class="container mx-auto bg-white p-10 shadow-lg rounded-lg leading-relaxed text-justify">

        {{-- Header --}}
        <div class="flex justify-center flex-col items-center mb-8">
            <img src="/logo.png" alt="image" class="w-64 h-40 mb-8">
            <h2 class="text-xl font-bold italic text-center mb-1">Membership Assessment Report</h2>
            <p class="text-xl font-bold italic text-center mb-1">Submitted to board of Directors</p>
            <p class="text-xl font-bold italic text-center mb-1">of NGO Forum on Cambodia</p>
        </div>


        {{-- Section 1: Summary --}}
        <h3 class="text-2xl text-green-700 font-bold mb-3">1. Summary</h3>
        <div class="mb-2">
            <div
                class="
                    text-[16px]
                    leading-[1.9]
                    text-black
                    text-justify
                    space-y-6
                    [&_p]:mb-4
                ">
                {!! $report->summary_html['html'] ?? '<em>Not generated yet.</em>' !!}
            </div>
        </div>


        {{-- Section 2: Information --}}
        <h3 class="text-2xl text-green-700 font-bold mt-8 mb-3">2. Information about Membership</h3>
        <p class="mb-2">The followings are the overall assessment based on submitted documents as compared with the
            required check list stated below:</p>

        <h4 class="font-bold mb-2 text-green-600">2.1) Basic Information about NGO Membership</h4>
        <table class="w-full border border-gray-400 text-sm mb-6">
            <tbody>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Name of Organization</td>
                    <td class="border px-2 py-2">{{ $membership->org_name_en ?? 'N/A' }} (
                        {{ $membership->org_name_abbreviation ?? ' ' }} )</td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Logo</td>
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
                    <td class="border w-44 px-2 py-2 font-semibold">Type of NGO</td>
                    <td class="border px-2 py-2">{{ $membership->basicInformation->ngo_type ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Vision</td>
                    <td class="border px-2 py-2">{{ $membership->basicInformation->vision ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Mission</td>
                    <td class="border px-2 py-2">{{ $membership->basicInformation->mission ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Year Established</td>
                    <td class="border px-2 py-2">
                        {{ optional($membership->basicInformation->established_date)->format('d F Y') ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Address</td>
                    <td class="border px-2 py-2">{{ $membership->address ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Name of Director</td>
                    <td class="border px-2 py-2">{{ $membership->director_name }}</td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Email of Director</td>
                    <td class="border px-2 py-2">{{ $membership->director_email }}</td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Phone of Director</td>
                    <td class="border px-2 py-2">{{ $membership->director_phone }}</td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Number of Staff</td>
                    <td class="border px-2 py-2">
                        Total: {{ $membership->basicInformation->staff_total ?? 0 }} |
                        Female: {{ $membership->basicInformation->staff_female ?? 0 }} |
                        PWD: {{ $membership->basicInformation->staff_pwd ?? 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Target Program Areas</td>
                    <td class="border px-2 py-2">
                        Province: {{ $membership->basicInformation->province ?? 0 }} |
                        District: {{ $membership->basicInformation->district ?? 0 }} |
                        Commune: {{ $membership->basicInformation->commune ?? 0 }} |
                        Village: {{ $membership->basicInformation->village ?? 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="border w-44 px-2 py-2 font-semibold">Key Actions</td>
                    <td class="border px-2 py-2">
                        <ul class="list-disc ml-6">
                            @php
                                $actions = $membership->basicInformation->key_actions ?? null;
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
                <tr>
                    <td class="border px-2 py-2 font-semibold w-44">Key Program Focuses</td>
                    <td class="border px-2 py-2">
                        <ul class="list-disc ml-6">
                            @forelse($membership->basicInformation->key_program_focuses ?? [] as $item)
                                <li>{{ $item }}</li>
                            @empty
                                <li>N/A</li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td class="border px-2 py-2 font-semibold w-44">Target Groups</td>
                    <td class="border px-2 py-2">
                        <ul class="list-disc ml-6">
                            @forelse($membership->basicInformation->target_groups ?? [] as $item)
                                <li>{{ $item }}</li>
                            @empty
                                <li>N/A</li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td class="border px-2 py-2 font-semibold w-44">Ministries Partners</td>
                    <td class="border px-2 py-2">
                        <ul class="list-disc ml-6">
                            @forelse($membership->basicInformation->ministries_partners ?? [] as $item)
                                <li>{{ $item }}</li>
                            @empty
                                <li>N/A</li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td class="border px-2 py-2 font-semibold w-44">Development Partners</td>
                    <td class="border px-2 py-2">
                        <ul class="list-disc ml-6">
                            @forelse($membership->basicInformation->development_partners ?? [] as $item)
                                <li>{{ $item }}</li>
                            @empty
                                <li>N/A</li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td class="border px-2 py-2 font-semibold w-44">Private Sector Partners</td>
                    <td class="border px-2 py-2">
                        <ul class="list-disc ml-6">
                            @forelse($membership->basicInformation->private_sector_partners ?? [] as $item)
                                <li>{{ $item }}</li>
                            @empty
                                <li>N/A</li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        <h4 class="font-bold mb-2 text-green-600">
            2.2) Meeting Requirements being a member of NGOF
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

        <h4 class="font-bold mb-2 text-green-600">2.3) Membership / Fee</h4>
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
                    <td class="border px-2 py-2">${{ $membership->basicInformation->membership_fee ?? 'N/A' }} per year
                    </td>
                </tr>
            </tbody>
        </table>

        <h4 class="font-bold mb-2 text-green-600">2.4) Interest in attending network meetings</h4>
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
            <div
                class="
                    space-y-4
                    text-justify
                    [&_h4]:font-bold
                    [&_h4]:text-green-600
                    [&_h4]:mt-2
                    [&_h4]:text-[18px]
                    [&_ul]:list-disc
                    [&_ul]:ml-10
                    [&_li]:mb-2
                    [&_strong]:font-bold
                ">
                {!! $report->conclusion_html['html'] ?? '<em>Not generated yet.</em>' !!}
            </div>
        </div>


        <div class="flex gap-4 mt-10">

            {{-- ADMIN: Back + Export --}}
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('reports.membership') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white 
                  rounded-md font-medium transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
            @endif

            {{-- ADMIN + MANAGER: Export --}}
            @if (in_array(auth()->user()->role, ['admin', 'manager']))
                <a href="{{ route('reports.export', $membership->id) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white 
                  rounded-md shadow hover:bg-red-700">
                    Export PDF
                </a>
            @endif

        </div>

    </div>
@endsection
