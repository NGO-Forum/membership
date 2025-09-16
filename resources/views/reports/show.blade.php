@extends('layouts.app')

@section('content')
    <div class="container mx-auto bg-white p-10 shadow-lg rounded-lg leading-relaxed text-justify">

        {{-- Header --}}
        <div class="flex justify-center flex-col items-center mb-8">
            <img src="/logo.png" alt="image" class="w-64 h-40 mb-8">
            <h2 class="text-xl font-bold italic text-center mb-1">Assessment Report</h2>
            <p class="text-xl font-bold italic text-center mb-1">Submitted to board of Directors</p>
            <p class="text-xl font-bold italic text-center mb-1">Of NGO Forum on Cambodia</p>
        </div>


        {{-- Section 1: Summary --}}
        <h3 class="text-2xl text-green-700 font-bold mb-3">1. Summary</h3>
        <p>
            Buddhism for Social Development Action (BSDA) is a local Cambodian NGO established to
            empower marginalized communities, with a focus on children, youth, and women. Their mission
            is to ensure equitable access to education, health, and livelihoods, contributing to sustainable
            development in Cambodia. BSDA has a solid track record of implementing impactful programs
            and has submitted all necessary documents, including their strategic plan, financial reports,
            governing documents, and a letter of intent for NGO Forum membership.
        </p>
        <p class="mt-3">
            BSDA's application for NGO Forum membership meets almost all the requirements. They have
            provided a letter of intent, mission and vision statements, constitution and by-laws, a list of
            activities and brochures, funding sources, board members, and an audited financial report.
            The constitution mentions income sources, which partially fulfill this requirement. While BSDA’s
            application is mostly complete, they have not provided a separate fundraising strategy, which is
            required but not compulsory. BSDA has a strong commitment to creating sustainable livelihoods
            for beneficiaries. The competition for international donor funding is increasing, making it difficult
            to secure resources for new initiatives. In response, BSDA has invested in social enterprises such
            as the Smile Restaurant and Hanchey Bamboo Resort to generate income and support community
            programs.
        </p>
        <p class="mt-3">
            The application reviewer concludes that BSDA is well-qualified for NGO Forum membership,
            with all requirements met except for the standalone fundraising strategy but it is not compulsory.
            The application reviewer recommends approving BSDA’s membership.
        </p>

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
                    <td class="border px-2 py-2"><img
                            src="{{ Storage::url($membership->membershipUploads->first()->logo) }}" alt="Logo"
                            width="200"></td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Type of NGO</td>
                    <td class="border px-2 py-2">{{ $typeNgo ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Vision</td>
                    <td class="border px-2 py-2">{{ $visionText ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Mission</td>
                    <td class="border px-2 py-2">{{ $missionText ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Year Established</td>
                    <td class="border px-2 py-2">05 July 2005</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Address</td>
                    <td class="border px-2 py-2">{{ $addressText ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Name of Director</td>
                    <td class="border px-2 py-2">{{ $membership->director_name }}</td>
                </tr>
                <tr>
                    <td class="border w-40 px-2 py-2 font-semibold">Key Actions</td>
                    <td class="border px-2 py-2">
                        <ul class="list-disc ml-6">
                            @forelse($keyActions as $action)
                                <li>{{ $action }}</li>
                            @empty
                                <li>N/A</li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        <h4 class="font-bold mb-2 text-green-600">BB) Meeting Requirements being a member of NGOF</h4>
        <table class="w-full border border-green-400 text-sm mb-6">
            <thead>
                <tr class="bg-green-200 text-center">
                    <th class="border px-2 py-2">Item</th>
                    <th class="border px-2 py-2">Description</th>
                    <th class="border px-2 py-2">Rating(1-5)</th>
                    <th class="border px-2 py-2">Comments</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border w-16 text-center">1</td>
                    <td class="border px-2 py-2">Letter of Intent</td>
                    <td class="border text-center w-24">{{ $membership->letter_score }}</td>
                    <td class="border px-2 py-2">{{ $membership->letter_comments }}</td>
                </tr>
                <tr>
                    <td class="border w-16 text-center">2</td>
                    <td class="border px-2 py-2">Mission/Vision Statement</td>
                    <td class="border text-center w-24">{{ $membership->mission_vision_score }}</td>
                    <td class="border px-2 py-2">{{ $membership->mission_vision_comments }}</td>
                </tr>
                <tr>
                    <td class="border w-16 text-center">3</td>
                    <td class="border px-2 py-2">Constitution / By-Laws</td>
                    <td class="border text-center w-24">{{ $membership->constitution_score }}</td>
                    <td class="border px-2 py-2">{{ $membership->constitution_comments }}</td>
                </tr>
                <tr>
                    <td class="border w-16 text-center">4</td>
                    <td class="border px-2 py-2">Activities & Brochures</td>
                    <td class="border text-center w-24">{{ $membership->activities_score }}</td>
                    <td class="border px-2 py-2">{{ $membership->activities_comments }}</td>
                </tr>
                <tr>
                    <td class="border w-16 text-center">5</td>
                    <td class="border px-2 py-2">Funding & Decision-Makers</td>
                    <td class="border text-center w-24">{{ $membership->funding_score }}</td>
                    <td class="border px-2 py-2">{{ $membership->funding_comments }}</td>
                </tr>
                <tr>
                    <td class="border w-16 text-center">6</td>
                    <td class="border px-2 py-2">Authorization to Operate</td>
                    <td class="border text-center w-24">{{ $membership->authorization_score }}</td>
                    <td class="border px-2 py-2">{{ $membership->authorization_comments }}</td>
                </tr>
                <tr>
                    <td class="border w-16 text-center">7</td>
                    <td class="border px-2 py-2">Strategic Plan</td>
                    <td class="border text-center w-24">{{ $membership->strategic_plan_score }}</td>
                    <td class="border px-2 py-2">{{ $membership->strategic_plan_comments }}</td>
                </tr>
                <tr>
                    <td class="border w-16 text-center">8</td>
                    <td class="border px-2 py-2">Fundraising Strategy</td>
                    <td class="border text-center w-24">{{ $membership->fundraising_strategy_score }}</td>
                    <td class="border px-2 py-2">{{ $membership->fundraising_strategy_comments }}</td>
                </tr>
                <tr>
                    <td class="border w-16 text-center">9</td>
                    <td class="border px-2 py-2">Global Audit Report</td>
                    <td class="border text-center w-24">{{ $membership->audit_report_score }}</td>
                    <td class="border px-2 py-2">{{ $membership->audit_report_comments }}</td>
                </tr>
            </tbody>
        </table>


        <h4 class="font-bold mb-2 text-green-600">CC) Type of Membership / Fee</h4>
        <table class="w-full border border-green-400 text-sm mb-6">
            <tbody>
                <tr>
                    <td class="border w-16 text-center">10</td>
                    <td class="border px-2 py-2 font-semibold">Type</td>
                    <td class="border px-2 py-2">{{ $membership->membership_type }}</td>
                </tr>
                <tr>
                    <td class="border w-16 text-center">11</td>
                    <td class="border px-2 py-2 font-semibold">Fee</td>
                    <td class="border px-2 py-2">USD 200 per year</td>
                </tr>
            </tbody>
        </table>

        <h4 class="font-bold mb-2 text-green-600">DD) Interest in attending network meetings</h4>
        <table class="w-full border border-green-400 text-sm mb-6">
            <tbody>
                @foreach ($membership->membershipUploads->first()->networks ?? [] as $index => $network)
                    @if ($network->network_name == 'NECCAW')
                        <tr>
                            <td class="border w-16 text-center">12</td>
                            <td class="border px-2 py-2">Network of Environment, Climate Change, Agriculture and Water (
                                {{ $network->network_name }} )</td>
                            <td class="border px-2 py-2"></td>
                        </tr>
                    @endif
                    @if ($network->network_name == 'BWG')
                        <tr>
                            <td class="border w-16 text-center">13</td>
                            <td class="border px-2 py-2">Budget Working Group ( {{ $network->network_name }} )</td>
                            <td class="border px-2 py-2"></td>
                        </tr>
                    @endif
                    @if ($network->network_name == 'RCC')
                        <tr>
                            <td class="border w-16 text-center">14</td>
                            <td class="border px-2 py-2">Rivers Coalition of Cambodia ( {{ $network->network_name }} )</td>
                            <td class="border px-2 py-2"></td>
                        </tr>
                    @endif
                    @if ($network->network_name == 'NRLG')
                        <tr>
                            <td class="border w-16 text-center">15</td>
                            <td class="border px-2 py-2">Natural Resources and Land Governance (
                                {{ $network->network_name }} )</td>
                            <td class="border px-2 py-2"></td>
                        </tr>
                    @endif
                    @if ($network->network_name == 'GGESI')
                        <tr>
                            <td class="border w-16 text-center">16</td>
                            <td class="border px-2 py-2">Gender, Governance, Environment and Social Inclusion (
                                {{ $network->network_name }} )</td>
                            <td class="border px-2 py-2"></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>


        {{-- Section 3: Conclusions --}}
        <h3 class="text-2xl text-green-700 font-bold mb-3">3. Conclusions and Recommendations</h3>
        <p>
            Based on a thorough evaluation of BSDA's application for membership in the NGO Forum, it is
            clear that the organization demonstrates a strong commitment to its mission and vision. The
            proposed strategies are designed to promote a more inclusive and sustainable society, focusing
            particularly on enhancing livelihood security for women, youth, and vulnerable groups.The
            following key strategies are recommended for BSDA to achieve its objectives:
        </p>
        <ul class="list-disc list-inside mt-3 mb-4">
            <li><span class="font-bold">Cross-Cutting Programs:
                </span>Integrate education, health, and livelihood support to create
                holistic programs that address multiple needs simultaneously.</li>
            <li><span class="font-bold">Social Enterprises: </span>Foster the development of social enterprises that
                generate income
                opportunities for marginalized communities.</li>
            <li><span class="font-bold">Monitoring Strategies: </span>Enhance monitoring mechanisms to ensure effective
                allocation
                of resources, enabling better tracking of program outcomes.
            </li>
            <li><span class="font-bold">Organizational Capacity Building: </span>Invest in staff training to strengthen the
                capabilities
                of the organization, ensuring that team members are well-equipped to implement
                programs effectively.</li>
            <li><span class="font-bold">Partnerships: </span>Strengthen collaborations with other organizations to leverage
                resources
                and expertise, creating a more robust network for support.</li>
            <li><span class="font-bold">Awareness and Advocacy Campaigns: </span>Promote initiatives that mobilize
                community
                support and raise awareness about the challenges faced by vulnerable populations.
            </li>
        </ul>
        <p>
            By implementing these recommendations, BSDA is positioned to significantly improve the lives
            of vulnerable groups and move closer to its vision of an empowered society with secure
            livelihoods. This strategic approach not only aligns with BSDA's mission but also contributes to
            broader societal goals of equity and sustainability
        </p>
        <h2 class="font-bold mt-6 text-lg">Key Strengths of BSDA's Application:</h2>
        <ul class="list-disc list-inside mt-3 mb-4 ml-8">
            <li><span class="font-bold">Clear Mission and Vision:
                </span>BSDA articulates a strong commitment to inclusivity and
                empowerment in its mission and vision statements.</li>
            <li><span class="font-bold">Comprehensive Documentation: </span>The organization has submitted all necessary
                documentation, including strategic plans, activity details, financial information, and
                governing documents, demonstrating transparency and a solid organizational structure.</li>
            <li><span class="font-bold">Strong Organizational Structure: </span>The organization's constitution, list of
                activities, and
                details of board members underscore a well-established governance framework.

            </li>
            <li><span class="font-bold">Financial Accountability: </span>The submission of an audited financial report
                illustrates sound
                financial management and accountability; however, it is based on the year ending in
                2022, and an updated report for 2023 would be beneficial.</li>
            <li><span class="font-bold">Active Participation: </span>BSDA's interest in participating in several network
                meetings
                highlights their commitment to engagement and collaboration within the NGO
                community. However, they did not include the names of individuals who will attend these
                meetings.</li>
        </ul>
        <p class="mt-4"><span class="font-bold">Minor Gap Identified: </span>The missing documentation is a standalone
            fundraising strategy and
            details regarding the members who will attend network meetings. While not a compulsory
            requirement, it would be advantageous for the applicant organization to consider developing this
            in the future.
        </p>
        <h2 class="mt-4 font-bold text-lg">Recommendation: </h2>
        <p class="mt-3">
            Given BSDA’s robust application and minor documentation gap, it is recommended that their
            membership in the NGO Forum be approved, contingent upon the submission of a standalone
            fundraising strategy document. BSDA's strong financial record and proactive interest in
            networking further support their case for membership. It is also suggested that they provide the
            name of the key person responsible for attending the network meetings.
        </p>
        <h2 class="mt-4 font-bold text-lg">Conclusion: </h2>
        <p class="mt-3">
            BSDA is well-qualified for NGO Forum membership, and their inclusion is likely to contribute
            positively to the collective efforts of the NGO community in Cambodia. Approving their
            membership, with the condition of submitting the missing fundraising strategy and identifying
            their representative for network meetings, ensures that all requirements are met while
            recognizing BSDA's potential to drive meaningful change.
        </p>

        {{-- Signatures --}}
        <div class="mt-20 flex justify-around">
            <div>
                <b>Reviewed by</b><br><br><br>
                <br>
                <br>
                <br>
                <span class="font-bold">Mr. CHAN Vicheth</span><br>
                Program Manager of NGO <br>Forum on Cambodia
            </div>

            <div>
                <b>Submitted by</b><br><br><br>
                <br>
                <br>
                <br>
                <span class="font-bold">Mr. SOEUNG Saroeun</span><br>
                Executive Director of NGO <br>Forum on Cambodia
            </div>

            <div>
                <b>Endorsed by</b><br><br><br>
                <br>
                <br>
                <br>
                <span class="font-bold">Mr. TOURT Chamroen</span><br>
                Chair of Board of Directors<br>for NGO Forum on Cambodia
            </div>
        </div>
        <a href="{{ route('reports.membership') }}"
            class="inline-flex items-center gap-2 px-4 py-2 mt-10 bg-green-600 hover:bg-green-700 text-white 
                            rounded-md font-medium transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                </path>
            </svg>
            Back
        </a>
    </div>
@endsection
