@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📊 Membership Dashboard</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">
        <!-- Card Component -->
        @php
            $cards = [
                ['title' => 'New Membership', 'color' => 'blue-600', 'value' => $totalNew, 'img' => '/new.jpg'],
                ['title' => 'Old Membership', 'color' => 'green-600', 'value' => $totalOld, 'img' => '/approved.jpg'],
                [
                    'title' => 'Request Membership',
                    'color' => 'yellow-400',
                    'value' => $totalRequest,
                    'img' => '/request.jpg',
                ],
                ['title' => 'Cancel Membership', 'color' => 'red-500', 'value' => $totalCancel, 'img' => '/cencel.jpg'],
                [
                    'title' => 'Total Membership',
                    'color' => 'gray-500',
                    'value' => $totalMembership,
                    'img' => '/total.jpg',
                ],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="w-full">
                <div class="mb-4 bg-{{ $card['color'] }} text-white text-sm text-center px-4 py-1 rounded-full">
                    {{ $card['title'] }}
                </div>
                <div class="bg-white shadow p-4 sm:p-6 rounded-lg hover:shadow-lg transition text-center">
                    <div class="flex justify-center mb-4 mt-2">
                        <img src="{{ $card['img'] }}" alt="{{ $card['title'] }}" class="w-12 h-12 sm:w-16 sm:h-16">
                    </div>
                    <div class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $card['value'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Line Chart -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="font-semibold text-lg text-green-700 mb-4">Events Growth</h2>
            <canvas id="lineChart" class="h-48 sm:h-56"></canvas>
        </div>

        <!-- Pie Chart -->
        <div
            class="bg-white p-4 sm:p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col sm:flex-row items-center sm:items-start">
            <div class="mb-4 sm:mb-0 sm:mr-6">
                <h2 class="font-semibold text-lg text-green-700 mb-2">Membership Overview</h2>
                <ul class="text-base mt-4 sm:mt-12 ml-2 sm:ml-6">
                    <li class="flex items-center mb-1"><span class="w-3 h-3 inline-block mr-2"
                            style="background-color: #facc15;"></span> Request</li>
                    <li class="flex items-center mb-1"><span class="w-3 h-3 inline-block mr-2"
                            style="background-color: #22c55e;"></span> Total Old</li>
                    <li class="flex items-center mb-1"><span class="w-3 h-3 inline-block mr-2"
                            style="background-color: #ef4444;"></span> Cancel</li>
                    <li class="flex items-center mb-1"><span class="w-3 h-3 inline-block mr-2"
                            style="background-color: #3b82f6;"></span> Total New</li>
                </ul>
            </div>
            <div class="w-40 h-40 sm:w-72 sm:h-72 mt-1 mb-2 sm:mt-12">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Line Chart
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Memberships',
                    data: @json($monthlyData),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.2)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0, // start at 0
                        max: 30, // end at 15
                        ticks: {
                            stepSize: 1 // show every integer
                        }
                    }
                }
            }
        });


        // Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['Request', 'Total Old', 'Cancel', 'Total New'],
                datasets: [{
                    data: [{{ $totalRequest }}, {{ $totalOld }}, {{ $totalCancel }},
                        {{ $totalNew }}
                    ],
                    backgroundColor: ['#facc15', '#22c55e', '#ef4444', '#3b82f6'],
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush
