<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Assessment Report</title>

    <style>
        body {
            font-family: DejaVu Sans, serif;
            font-size: 14px;
            line-height: 1.2;
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

        h4 {
            color: green;
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

        th,
        td {
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

        @page {
            margin: 35px 25px 60px 25px;
            /* top right bottom left */
        }

        footer {
            position: fixed;
            bottom: -25px;
            /* move into bottom margin */
            left: 0;
            right: 0;
            height: 20px;
            text-align: center;
            font-size: 12px;
            color: #444;
        }
    </style>
</head>

<body>

    @php
        /* ===== NGO FORUM LOGO (BASE64) ===== */
        $systemLogoPath = public_path('logo.png');
        $systemLogo = file_exists($systemLogoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($systemLogoPath))
            : null;

        /* ===== ORGANIZATION LOGO (BASE64) ===== */
        $upload = $membership->membershipUploads->first();
        $orgLogo = null;

        if ($upload && $upload->logo) {
            $path = storage_path('app/public/' . $upload->logo);
            if (file_exists($path)) {
                $orgLogo = 'data:image/png;base64,' . base64_encode(file_get_contents($path));
            }
        }
    @endphp

    {{-- COVER HEADER --}}
    @if ($systemLogo)
        <div class="centers">
            <img src="{{ $systemLogo }}" style="height:120px;">
        </div>
    @endif

    <h1>Membership Assessment Report</h1>
    <h1>Submitted to Board of Directors</h1>
    <h1>of NGO Forum on Cambodia</h1>

    {{-- 1. SUMMARY --}}
    <h2>1. Summary</h2>
    {!! $report->summary_html['html'] ?? '<em>Not generated yet.</em>' !!}

    {{-- 2. INFORMATION --}}
    <h2>2. Information about Membership</h2>
    <p>
        The followings are the overall assessment based on submitted documents
        as compared with the required check list stated below:
    </p>

    <h3>2.1) Basic Information about NGO Membership</h3>

    <table>
        <tr>
            <td class="label">Name of Organization</td>
            <td>{{ $membership->org_name_en }} ( {{ $membership->org_name_abbreviation ?? ' ' }} )</td>
        </tr>

        <tr>
            <td class="label">Logo of Organization</td>
            <td style="height:56px;">
                @if ($orgLogo)
                    <img src="{{ $orgLogo }}" style="max-height:80px;">
                @else
                    <em>N/A</em>
                @endif
            </td>
        </tr>

        <tr>
            <td class="label">Type of NGO</td>
            <td>{{ $membership->basicInformation->ngo_type }}</td>
        </tr>

        <tr>
            <td class="label">Vision</td>
            <td>{{ $membership->basicInformation->vision }}</td>
        </tr>

        <tr>
            <td class="label">Mission</td>
            <td>{{ $membership->basicInformation->mission }}</td>
        </tr>

        <tr>
            <td class="label">Year Established</td>
            <td>{{ optional($membership->basicInformation->established_date)->format('d F Y') }}</td>
        </tr>

        <tr>
            <td class="label">Address</td>
            <td>{{ $membership->address }}</td>
        </tr>

        <tr>
            <td class="label">Name of Director</td>
            <td>{{ $membership->director_name }}</td>
        </tr>
        <tr>
            <td class="label">Phone of Director</td>
            <td>{{ $membership->director_phone }}</td>
        </tr>
        <tr>
            <td class="label">Number of Staff</td>
            <td>
                Total: {{ $membership->basicInformation->staff_total ?? 0 }} |
                Female: {{ $membership->basicInformation->staff_female ?? 0 }} |
                PWD: {{ $membership->basicInformation->staff_pwd ?? 0 }}
            </td>
        </tr>
        <tr>
            <td class="label">Target Program Areas</td>
            <td>
                Province: {{ $membership->basicInformation->province ?? 0 }} |
                District: {{ $membership->basicInformation->district ?? 0 }} |
                Commune: {{ $membership->basicInformation->commune ?? 0 }} |
                Village: {{ $membership->basicInformation->village ?? 0 }}
            </td>
        </tr>

        <tr>
            <td class="label">Key Actions</td>
            <td>
                <ul>
                    @foreach ($membership->basicInformation->key_actions ?? [] as $action)
                        <li>{{ $action }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        <tr>
            <td class="label">Key Program Focuses</td>
            <td>
                <ul>
                    @forelse($membership->basicInformation->key_program_focuses ?? [] as $item)
                        <li>{{ $item }}</li>
                    @empty
                        <li>N/A</li>
                    @endforelse
                </ul>
            </td>
        </tr>
        <tr>
            <td class="label">Target Groups</td>
            <td>
                <ul>
                    @forelse($membership->basicInformation->target_groups ?? [] as $item)
                        <li>{{ $item }}</li>
                    @empty
                        <li>N/A</li>
                    @endforelse
                </ul>
            </td>
        </tr>
        <tr>
            <td class="label">Ministries Partners</td>
            <td>
                <ul>
                    @forelse($membership->basicInformation->ministries_partners ?? [] as $item)
                        <li>{{ $item }}</li>
                    @empty
                        <li>N/A</li>
                    @endforelse
                </ul>
            </td>
        </tr>
        <tr>
            <td class="label">Development Partners</td>
            <td>
                <ul>
                    @forelse($membership->basicInformation->development_partners ?? [] as $item)
                        <li>{{ $item }}</li>
                    @empty
                        <li>N/A</li>
                    @endforelse
                </ul>
            </td>
        </tr>
        <tr>
            <td class="label">Private Sector Partners</td>
            <td>
                <ul>
                    @forelse($membership->basicInformation->private_sector_partners ?? [] as $item)
                        <li>{{ $item }}</li>
                    @empty
                        <li>N/A</li>
                    @endforelse
                </ul>
            </td>
        </tr>
    </table>

    {{-- BB CHECKLIST --}}
    <h3>2.2) Meeting Requirements being a member of NGOF</h3>

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
    <h3>2.3) Membership / Fee</h3>

    <table>
        <tr>
            <td class="center">10</td>
            <td class="label">Applying for</td>
            <td>{{ $membership->membership_type }}</td>
        </tr>
        <tr>
            <td class="center">11</td>
            <td class="label">Membership fee</td>
            <td>USD {{ $membership->basicInformation->membership_fee }} per year</td>
        </tr>
    </table>

    {{-- DD --}}
    <h3>2.4) Interest in attending network meetings</h3>

    <table>
        @foreach ($membership->membershipUploads->first()->networks ?? [] as $i => $network)
            <tr>
                <td class="center">{{ 12 + $i }}</td>
                <td class="label">{{ $network->network_name }}</td>
                <td>
                    {{ optional(
                        $membership->membershipUploads->first()->focalPoints->where('network_name', $network->network_name)->first(),
                    )->summaries }}
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
                Program Manager of<br>
                NGO Forum on Cambodia
            </td>

            <td>
                Submitted by<br><br><br><br><br>
                <strong>{{ $ed?->name ?? 'Mr. SOEUNG Saroeun' }}</strong><br>
                Executive Director of<br>
                NGO Forum on Cambodia<br>
            </td>

            <td>
                Endorsed by<br><br><br><br><br>
                <strong>{{ $board?->name ?? 'Mr. TOURT Chamroen' }}</strong><br>
                Chair of Board of Directors<br>
                NGO Forum on Cambodia<br>
            </td>
        </tr>
    </table>


    <footer></footer>

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {

                $text = "Page $pageNumber"; // or "Page $pageNumber of $pageCount"
                $font = $fontMetrics->getFont("DejaVu Sans", "normal");
                $size = 10;

                $width = $fontMetrics->getTextWidth($text, $font, $size);

                $rightMargin = 25; // must match @page right margin
                $x = $canvas->get_width() - $width - $rightMargin; // ✅ right aligned
                $y = $canvas->get_height() - 28; // move up/down if needed

                $canvas->text($x, $y, $text, $font, $size);
            });
        }
    </script>
</body>

</html>
