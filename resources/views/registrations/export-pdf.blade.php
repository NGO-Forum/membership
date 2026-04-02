<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: hanuman, sans-serif;
            font-size: 9px;
        }

        /* PAGE WRAPPER (Excel grid) */
        .page {
            background-image:
                linear-gradient(to right, #dcdcdc 1px, transparent 1px),
                linear-gradient(to bottom, #dcdcdc 1px, transparent 1px);
            background-size: 10px 10px;
            page-break-after: always;
        }

        header {
            position: fixed;
            top: -160px;
            left: 0;
            right: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            display: table-header-group;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            height: 28px;
            vertical-align: middle;
        }

        th {
            text-align: center;
            background: #f5f5f5;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .red {
            color: #c00000;
        }

        .logo {
            height: 80px;
        }

        .small {
            font-size: 10px;
        }

        .title-kh {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: green;
        }

        .title-en {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @php
        $chunkedRegistrations = $registrations->chunk(10)->map->values(); // Laravel Collection chunk method
    @endphp

    @foreach ($chunkedRegistrations as $chunk)
        <div class="page">

            <header>
                <table style="border:none;">
                    <tr>
                        <td style="border:none; width:25%;">
                            <img src="{{ public_path('logo.png') }}" class="logo">
                        </td>
                        <td style="border:none; width:65%; text-align:center; vertical-align:middle;">
                            <div class="title-kh" style="line-height:1.5;">បញ្ជីវត្តមាន</div>
                            <div class="title-en">Attendant List</div>
                        </td>
                        <td style="border:none; width:10%;"></td>
                    </tr>
                </table>

                <table style="border:none;margin-top:6px;font-size:10px;">
                    <tr>
                        <td style="border:none;">
                            <strong>កាលបរិច្ឆេទ / Date:</strong>
                            <span class="red">{{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;">
                            <strong>សកម្មភាព / Activities:</strong>
                            <span class="red">{{ $event->title }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;">
                            <strong>ទីកន្លែង / Venue:</strong>
                            <span class="red">{{ $event->location }}</span>
                        </td>
                    </tr>
                </table>

                <div style="margin-top:4px;font-size:10px;">
                    <strong>អាយុ:</strong> A. &lt;18 &nbsp;&nbsp; B. 30-60 &nbsp;&nbsp; C. 60&gt;; (Range of age: &lt;18
                    &nbsp;&nbsp; B. 30-60 &nbsp;&nbsp; C. 60&gt;)
                </div>

                <div style="margin-top:4px;font-size:10px;">
                    <strong>ភាពងាយរងគ្រោះ:</strong>
                    1. ក្រុម​ LGBTQIA+ &nbsp;&nbsp; 2. ជនជាតិដើមភាគតិច &nbsp;&nbsp; 3. ជនពិការភាព &nbsp;&nbsp; 4.
                    .ព្រះសង្ឃ &nbsp;&nbsp; 5. មិនមាន; (Type of Participants): 1. LGBTQIA+ group 2. Indigenous people 3.
                    People with disabilities 4. Monks 5. None)
                </div>
            </header>

            <table style="margin-top:10px;">
                <thead>
                    <tr>
                        <th width="3%">ល.រ<br><span class="small">No.</span></th>
                        <th width="8%">ឈ្មោះ<br><span class="small">Name</span></th>
                        <th width="5%">ភេទ<br><span class="small">Gender</span></th>
                        <th width="4%">អាយុ<br><span class="small">Age</span></th>
                        <th width="8%">ភាពងាយរងគ្រោះ<br><span class="small">Vulnerable</span></th>
                        <th width="10%">មុខតំណែង<br><span class="small">Position</span></th>
                        <th width="15%">អង្គភាព<br><span class="small">Organization</span></th>
                        <th width="9%">ទីតាំងអង្គភាព<br><span class="small">Org. Location</span></th>
                        <th width="8%">លេខទូរស័ព្ទ<br><span class="small">Phone</span></th>
                        <th width="15%">អ៊ីមែល<br><span class="small">Email</span></th>
                        <th width="8%">អនុញ្ញាតថតរូប<br><span class="small">Allow photo</span></th>
                        <th width="9%">ហត្ថលេខា<br><span class="small">Signature</span></th>
                    </tr>
                </thead>

                <tbody>
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            <td class="center">{{ $i + 1 }}</td>
                            <td>{{ $chunk[$i]->name ?? '' }}</td>
                            <td class="center">{{ $chunk[$i]->gender ?? '' }}</td>
                            <td class="center">
                                @if (isset($chunk[$i]) && is_numeric($chunk[$i]->age))
                                    @php $age = $chunk[$i]->age; @endphp

                                    @if ($age < 30)
                                        A
                                    @elseif ($age <= 60)
                                        B
                                    @else
                                        C
                                    @endif
                                @endif
                            </td>
                            @php
                                $vulnerableMap = [
                                    'lgbtqia' => 1,
                                    'indigenous' => 2,
                                    'disability' => 3,
                                    'monks' => 4,
                                    // 'women' => 5,
                                    // 'poor' => 6,
                                    'other' => 5,
                                ];
                            @endphp

                            <td class="center">
                                {{ $vulnerableMap[$chunk[$i]->vulnerable ?? ''] ?? '' }}
                            </td>

                            <td class="center">{{ $chunk[$i]->position ?? '' }}</td>
                            <td class="center">{{ $chunk[$i]->organization ?? '' }}</td>
                            <td class="center">{{ $chunk[$i]->org_location ?? '' }}</td>
                            <td class="center">{{ $chunk[$i]->phone ?? '' }}</td>
                            <td>{{ $chunk[$i]->email ?? '' }}</td>
                            <td class="center">
                                @if (isset($chunk[$i]))
                                    {{ $chunk[$i]->allow_photos ? 'Yes' : 'No' }}
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <table style="margin-top:30px; width:100%; border:none; font-size:10px;">
                <tr>
                    <td style="border:none; width:80%; vertical-align:top;">
                        <div style="font-weight:bold;">រៀបចំដោយ / Prepared by:</div>
                        <br><br><br><br>
                        <div style="margin-top:6px; border:none;"><strong>Name:</strong></div>
                        <br>
                        <div><strong>Position:</strong></div>
                    </td>

                    <td style="border:none; width:20%;"></td>

                    <td style="border:none; width:40%; vertical-align:top;">
                        <div style="font-weight:bold;">អនុម័តដោយ / Approved by:</div>
                        <br><br><br><br>
                        <div style="margin-top:6px; border:none;"><strong>Name:</strong></div>
                        <br>
                        <div><strong>Position:</strong></div>
                    </td>
                </tr>
            </table>

        </div>
    @endforeach
</body>

</html>
