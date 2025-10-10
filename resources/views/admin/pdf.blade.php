<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Memberships Export PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
        th, td { border: 1px solid #333; padding: 6px; vertical-align: top; }
        th { background-color: #2f855a; color: white; }
        ul { margin: 0; padding-left: 16px; }
        .application { margin-bottom: 15px; padding: 10px; border: 1px solid #aaa; background: #f9f9f9; }
        .section-title { font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Memberships Export</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NGO Name</th>
                <th>Director</th>
                <th>Email</th>
                <th>Position</th>
                <th>Networks</th>
                <th>Date</th>
                <th>Applications</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($memberships as $membership)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $membership->ngo_name ?? 'N/A' }}</td>
                <td>{{ $membership->director_name ?? 'N/A' }}</td>
                <td>{{ $membership->director_email ?? 'N/A' }}</td>
                <td>{{ $membership->alt_name ?? 'N/A' }}</td>
                <td>
                    @if ($membership->networks->count())
                        <ul>
                            @foreach ($membership->networks as $network)
                                <li>{{ $network->network_name }}</li>
                            @endforeach
                        </ul>
                    @else
                        No networks
                    @endif
                </td>
                <td>{{ optional($membership->created_at)->format('d M Y') ?? 'N/A' }}</td>
                <td>
                    @if ($membership->applications->count())
                        @foreach ($membership->applications as $app)
                            <div class="application">
                                <p><span class="section-title">Date:</span> {{ $app->date?->format('d M Y') ?? 'N/A' }}</p>
                                <p><span class="section-title">Mailing Address:</span> {{ $app->mailing_address ?? 'N/A' }}</p>
                                <p><span class="section-title">Facebook:</span> {{ $app->facebook ?? 'N/A' }}</p>

                                <p><span class="section-title">Communication Channels:</span> 
                                    @if (is_array($app->comm_channels) && count($app->comm_channels))
                                        {{ implode(', ', $app->comm_channels) }}
                                    @else
                                        None
                                    @endif
                                </p>

                                <p><span class="section-title">Communication Phones:</span></p>
                                @if (is_array($app->comm_phones) && count($app->comm_phones))
                                    <ul>
                                        @foreach ($app->comm_phones as $channel => $phone)
                                            <li>{{ ucfirst($channel) }}: {{ $phone }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    None
                                @endif

                                <p><span class="section-title">Website:</span>
                                    <a href="{{ $app->website }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ $app->website ?? 'N/A' }}
                                    </a>
                                </p>

                                <p><span class="section-title">Vision:</span> {{ $app->vision ?? 'N/A' }}</p>
                                <p><span class="section-title">Mission:</span> {{ $app->mission ?? 'N/A' }}</p>
                                <p><span class="section-title">Goal:</span> {{ $app->goal ?? 'N/A' }}</p>

                                <strong>Files:</strong>
                                <ul>
                                @foreach ([
                                    'letter' => 'Letter',
                                    'constitution' => 'Constitution',
                                    'activities' => 'Activities',
                                    'funding' => 'Funding',
                                    'registration' => 'Registration',
                                    'strategic_plan' => 'Strategic Plan',
                                    'fundraising_strategy' => 'Fundraising Strategy',
                                    'audit_report' => 'Audit Report',
                                    'signature' => 'Signature',
                                ] as $field => $label)
                                    @if (!empty($app->$field))
                                        <li>
                                            <a href="{{ route('file.view', ['path' => 'uploads/membership/XaUYvRgUFVnRqc5yT49SkcdTZPjPwShlZusrHeLo.pdf']) }}" target="_blank" class="underline hover:text-blue-800">
                                                View PDF
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @else
                        No applications
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
