<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Assessment Report</title>

    <style>
        body {
            font-family: DejaVu Sans, serif;
            font-size: 14px;
            line-height: 1.6;
            color: #000;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin: 0;
            font-style: italic;
        }

        h2 {
            font-size: 20px;
            color: green;
            margin-top: 12px;
        }

        h3 {
            font-size: 15px;
            color: green;
            margin-top: 10px;
        }

        p {
            text-align: justify;
            margin: 1px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #dbeafe;
            text-align: center;
        }

        .label {
            width: 28%;
            font-weight: bold;
        }

        .center {
            text-align: center;
            width: 35px;
        }

        .centers {
            text-align: center;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        .signature-table td {
            border: none;
            padding-top: 40px;
            text-align: center;
        }
    </style>
</head>

<body>

@php
    /* ===== NGO FORUM LOGO (BASE64) ===== */
    $systemLogoPath = public_path('logo.png');
    $systemLogo = file_exists($systemLogoPath)
        ? 'data:image/png;base64,'.base64_encode(file_get_contents($systemLogoPath))
        : null;

    /* ===== ORGANIZATION LOGO (BASE64) ===== */
    $upload = $membership->membershipUploads->first();
    $orgLogo = null;

    if ($upload && $upload->logo) {
        $path = storage_path('app/public/'.$upload->logo);
        if (file_exists($path)) {
            $orgLogo = 'data:image/png;base64,'.base64_encode(file_get_contents($path));
        }
    }
@endphp

{{-- COVER HEADER --}}
@if($systemLogo)
    <div class="centers">
        <img src="{{ $systemLogo }}" style="height:120px;">
    </div>
@endif

<h1>Assessment Report</h1>
<h1>Submitted to Board of Directors</h1>
<h1>of NGO Forum on Cambodia</h1>

{{-- 1. SUMMARY --}}
<h2>1. Summary</h2>
{!! $report->summary_html['html'] ?? '<em>Not generated yet.</em>' !!}

{{-- 2. INFORMATION --}}
<h2>2. Information about Applicant</h2>
<p>
    The followings are the overall assessment based on submitted documents
    as compared with the required check list stated below:
</p>

<h3>AA) Basic Information about NGO Applicant</h3>

<table>
    <tr>
        <td class="label">Name of Organization</td>
        <td>{{ $membership->org_name_en }}</td>
    </tr>

    <tr>
        <td class="label">Logo of Organization</td>
        <td style="height:56px; text-align:center;">
            @if($orgLogo)
                <img src="{{ $orgLogo }}" style="max-height:50px;">
            @else
                <em>N/A</em>
            @endif
        </td>
    </tr>

    <tr>
        <td class="label">Type of NGO</td>
        <td>{{ $membership->assessmentReport->ngo_type }}</td>
    </tr>

    <tr>
        <td class="label">Vision</td>
        <td>{{ $membership->assessmentReport->vision }}</td>
    </tr>

    <tr>
        <td class="label">Mission</td>
        <td>{{ $membership->assessmentReport->mission }}</td>
    </tr>

    <tr>
        <td class="label">Year Established</td>
        <td>{{ optional($membership->assessmentReport->established_date)->format('d F Y') }}</td>
    </tr>

    <tr>
        <td class="label">Address</td>
        <td>{{ $membership->assessmentReport->address }}</td>
    </tr>

    <tr>
        <td class="label">Name of Director</td>
        <td>{{ $membership->director_name }}</td>
    </tr>

    <tr>
        <td class="label">Key Actions</td>
        <td>
            <ul>
                @foreach ($membership->assessmentReport->key_actions ?? [] as $action)
                    <li>{{ $action }}</li>
                @endforeach
            </ul>
        </td>
    </tr>
</table>

{{-- BB CHECKLIST --}}
<h3>BB) Meeting Requirements being a member of NGOF</h3>

<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Rating (1–5)</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($report->checklist_json ?? [] as $i => $item)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $item['label'] }}</td>
                <td class="center">{{ $item['rating'] }}</td>
                <td>{{ $item['comment'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- CC --}}
<h3>CC) Type of Membership / Fee</h3>

<table>
    <tr>
        <td class="center">10</td>
        <td class="label">Applying for</td>
        <td>{{ $membership->membership_type }}</td>
    </tr>
    <tr>
        <td class="center">11</td>
        <td class="label">Membership fee</td>
        <td>USD {{ $membership->assessmentReport->membership_fee }} per year</td>
    </tr>
</table>

{{-- DD --}}
<h3>DD) Interest in attending network meetings</h3>

<table>
@foreach ($membership->membershipUploads->first()->networks ?? [] as $i => $network)
    <tr>
        <td class="center">{{ 12 + $i }}</td>
        <td class="label">{{ $network->network_name }}</td>
        <td>
            {{
                optional(
                    $membership->membershipUploads->first()
                        ->focalPoints
                        ->where('network_name', $network->network_name)
                        ->first()
                )->summaries
            }}
        </td>
    </tr>
@endforeach
</table>

{{-- 3. CONCLUSION --}}
<h2>3. Conclusions and Recommendations</h2>
{!! $report->conclusion_html['html'] ?? '<em>Not generated yet.</em>' !!}

{{-- SIGNATURES --}}
<table class="signature-table">
    <tr>
        <td>
            Reviewed by<br><br><br><br><br>
            <strong>{{ $manager?->name ?? 'Pending' }}</strong><br>
            Program Manager<br>
            NGO Forum on Cambodia
        </td>

        <td>
            Submitted by<br><br><br><br><br>
            <strong>{{ $ed?->name ?? 'Mr. SOEUNG Saroeun' }}</strong><br>
            Executive Director of NGO<br>
            Forum on Cambodia<br>
        </td>

        <td>
            Endorsed by<br><br><br><br><br>
            <strong>{{ $board?->name ?? 'Mr. TOURT Chamroen' }}</strong><br>
            Chair of Board of Directors<br>
            NGO Forum on Cambodia<br>
        </td>
    </tr>
</table>

</body>
</html>
