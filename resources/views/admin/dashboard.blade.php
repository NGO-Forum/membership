@extends('layouts.app')

@section('title', 'NGO Forum Dashboard')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
    <div class="max-w-full mx-auto px-2 sm:px-4">

        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <span class="font-semibold text-gray-800">NGO Forum</span>
                <span>/</span>
                <span>Admin</span>
                <span>/</span>
                <span class="text-gray-900 font-semibold">Dashboard</span>
            </div>

            <div class="mt-2 flex flex-col md:flex-row md:items-end md:justify-between gap-3">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-green-700">
                        Membership & Events Dashboard
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Monitor memberships, requests, events.
                    </p>
                </div>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            {{-- Approved --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Approved</div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalApproved }}</div>
                        <div class="mt-1 text-xs text-gray-500">Active memberships</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                    </div>
                </div>
            </div>

            {{-- Pending --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Pending</div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalPending }}</div>
                        <div class="mt-1 text-xs text-gray-500">Requests waiting</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-yellow-500">
                        <i class="fa-solid fa-hourglass-half text-lg"></i>
                    </div>
                </div>
            </div>

            {{-- Cancel --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Cancelled</div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalCancel }}</div>
                        <div class="mt-1 text-xs text-gray-500">Stopped memberships</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-600">
                        <i class="fa-solid fa-ban text-lg"></i>
                    </div>
                </div>
            </div>

            {{-- Events --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Events</div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalEvents }}</div>
                        <div class="mt-1 text-xs text-gray-500">All events recorded</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-calendar-days text-lg"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- Map + Chart + List --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Chart --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">NGOs by Province</h2>
                    <span class="text-sm text-gray-500">Click a slice to view NGOs</span>
                </div>

                <div style="height: 350px;">
                    <canvas id="provinceChart"></canvas>
                </div>
            </div>

            {{-- Map --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">Membership Locations</h2>
                    <span class="text-sm text-gray-500">Pins: {{ count($mapPoints ?? []) }}</span>
                </div>

                <div id="map" class="w-full" style="height: 350px; border-radius: 16px;"></div>

                @if (empty($mapPoints) || count($mapPoints) === 0)
                    <p class="text-sm text-gray-500 mt-3">No locations available yet.</p>
                @endif
            </div>

            {{-- List Panel --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">
                    NGOs in: <span id="selectedProvince" class="text-green-700">-</span>
                </h2>

                <div id="ngoList" class="text-sm text-gray-700 space-y-2">
                    <p class="text-gray-500">Click a province bar to see NGO names.</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        const points = @json($mapPoints ?? []);
        const provinceLabels = @json($provinceChartLabels ?? []);
        const provinceCounts = @json($provinceChartCounts ?? []);
        const provinceGroups = @json($provinceGroups ?? []);

        const norm = s => (s || '').toString().trim().toLowerCase();

        // DOM (exists now)
        const selectedProvinceEl = document.getElementById('selectedProvince');
        const ngoListEl = document.getElementById('ngoList');

        function renderNgoList(provinceName) {
            if (!selectedProvinceEl || !ngoListEl) return;

            selectedProvinceEl.textContent = provinceName;

            // try direct key first
            let ngos = provinceGroups[provinceName] || [];

            // fallback: normalize match keys
            if (!ngos.length) {
                const key = Object.keys(provinceGroups).find(k => norm(k) === norm(provinceName));
                ngos = key ? (provinceGroups[key] || []) : [];
            }

            if (!ngos.length) {
                ngoListEl.innerHTML = `<p class="text-gray-500">No NGO found for this province.</p>`;
                return;
            }

            ngoListEl.innerHTML = `
                <div class="space-y-2">
                    ${ngos.map(n => `
                                    <div class="border rounded-lg p-3 bg-gray-50">
                                        <a href="${n.url}" target="_blank" class="text-green-700 font-semibold underline">
                                            ${n.org}
                                        </a>
                                        <div class="text-xs text-gray-500 mt-1">${n.loc ?? ''}</div>
                                    </div>
                                `).join('')}
                </div>
            `;
        }

        // ===== Leaflet Map =====
        const cambodiaBounds = L.latLngBounds([9.9, 102.3], [14.7, 107.7]);

        const map = L.map('map', {
            maxBounds: cambodiaBounds,
            maxBoundsViscosity: 1.0,
            minZoom: 6,
            maxZoom: 18
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        map.fitBounds(cambodiaBounds, {
            padding: [20, 20]
        });
        setTimeout(() => map.invalidateSize(), 200);

        fetch("{{ asset('geo/cambodia_provinces.geojson') }}")
            .then(r => r.json())
            .then(geo => {
                L.geoJSON(geo, {
                    style: {
                        color: "#0f766e",
                        weight: 1,
                        fillOpacity: 0.08
                    },
                    onEachFeature: (feature, layer) => {
                        const provinceName =
                            feature.properties.NAME_1 ||
                            feature.properties.name ||
                            feature.properties.province ||
                            feature.properties.PROVINCE ||
                            "Unknown";

                        layer.on("mouseover", () => layer.setStyle({
                            fillOpacity: 0.18
                        }));
                        layer.on("mouseout", () => layer.setStyle({
                            fillOpacity: 0.08
                        }));

                        layer.on("click", () => {
                            // Update right-side list too
                            renderNgoList(provinceName);

                            // Popup on map
                            const key = Object.keys(provinceGroups).find(k => norm(k) === norm(
                                provinceName));
                            const ngos = key ? (provinceGroups[key] || []) : [];

                            let html = `<div style="min-width:260px;font-family:Arial,sans-serif;">
                                <div style="font-weight:bold;margin-bottom:6px;">${provinceName}</div>`;

                            if (!ngos.length) {
                                html +=
                                    `<div style="color:#666;">No NGO found for this province.</div>`;
                            } else {
                                html +=
                                    `<div style="margin-bottom:6px;color:#444;">NGOs working here (${ngos.length}):</div>`;
                                html += `<ul style="padding-left:16px;margin:0;">`;
                                ngos.forEach(n => {
                                    html += `<li style="margin-bottom:6px;">
                                        <a href="${n.url}" target="_blank" style="color:#0f766e;text-decoration:underline;">${n.org}</a>
                                        <div style="font-size:12px;color:#666;">${n.loc ?? ''}</div>
                                    </li>`;
                                });
                                html += `</ul>`;
                            }

                            html += `</div>`;
                            layer.bindPopup(html).openPopup();
                        });
                    }
                }).addTo(map);
            })
            .catch(err => console.error("Province GeoJSON load error:", err));

        // Markers
        points.forEach(p => {
            if (p.lat && p.lng) {
                L.marker([p.lat, p.lng]).addTo(map)
                    .bindPopup(`<b>${p.org ?? 'N/A'}</b><br>${p.location ?? ''}`);
            }
        });

        // ===== Chart.js =====
        // ===== PIE CHART =====
        const canvas = document.getElementById('provinceChart');
        if (canvas) {
            const ctx = canvas.getContext('2d');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: provinceLabels,
                    datasets: [{
                        label: 'NGO Count',
                        data: provinceCounts,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const label = context.label || '';
                                    const value = context.raw ?? 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    },
                    onClick: (evt, elements) => {
                        if (!elements.length) return;
                        const index = elements[0].index;
                        const provinceName = provinceLabels[index];
                        renderNgoList(provinceName);
                    }
                }
            });
        }
    </script>
@endsection
