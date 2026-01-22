@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-green-600 flex flex-col md:flex-row items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-lg md:text-2xl font-bold text-white">All Registrations</h2>
                    <p class="text-green-100 mt-1">Total: {{ $registrations->count() }} registrants</p>
                </div>
                <div class="flex items-center justify-between">
                    <a href="{{ url()->previous() }}"
                        class="bg-white text-green-600 font-semibold px-4 py-2 rounded hover:bg-gray-100">
                        ← Back
                    </a>
                    <button onclick="openRegistrationForm({{ $event->id }})"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 ml-4">
                        + Add
                    </button>

                    <a href="{{ route('registrations.export.pdf', $event->id) }}"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg ml-4">
                        Export PDF
                    </a>

                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-[8px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #
                            </th>
                            <th
                                class="px-6 py-3 text-left text-[8px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th
                                class="px-6 py-3 text-left text-[8px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-left text-[8px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Phone
                            </th>
                            <th
                                class="px-6 py-3 text-left text-[8px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Organization</th>
                            <th
                                class="px-6 py-3 text-left text-[8px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Position</th>
                            <th
                                class="px-6 py-3 text-left text-[8px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Events Name</th>
                            <th
                                class="px-6 py-3 text-left text-[8px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th
                                class="px-6 py-3 text-center text-[8px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($registrations as $i => $reg)
                            <tr class="hover:bg-green-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->organization }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reg->position }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $reg->event->title ?? 'No Event' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $reg->created_at->format('Y-m-d H:i') }}</td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    @if (auth()->user()->isAdmin() || auth()->user()->role === $event->program)
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Edit --}}
                                            <button
                                                onclick='openRegistrationForm({{ $event->id }}, @json($reg))'
                                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">
                                                Edit
                                            </button>


                                            {{-- Delete --}}
                                            <form action="{{ route('registrations.destroy', $reg->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)"
                                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                                    Delete
                                                </button>
                                            </form>


                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">No access</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                        @if ($registrations->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No registrations yet.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function openRegistrationForm(eventId, registration = null) {
                Swal.fire({
                    title: registration ? 'Edit Registration' : 'Register Participant',
                    width: '40rem',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    focusConfirm: false,
                    customClass: {
                        popup: 'rounded-2xl p-6'
                    },
                    html: `
                        <div class="text-left">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- Full Name -->
                                <div>
                                    <label class="block font-semibold mb-2">Full Name *</label>
                                    <input id="name" type="text"
                                        placeholder="Your full name"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-500"
                                        value="${registration?.name ?? ''}">
                                </div>

                                <!-- Age -->
                                <div>
                                    <label class="block font-semibold mb-2">Age</label>
                                    <input id="age" type="number"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-500"
                                        value="${registration?.age ?? ''}">
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label class="block font-semibold mb-2">Gender</label>
                                    <select id="gender"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-500">
                                        <option value="">Select</option>
                                        <option value="Male" ${registration?.gender === 'Male' ? 'selected' : ''}>Male</option>
                                        <option value="Female" ${registration?.gender === 'Female' ? 'selected' : ''}>Female</option>
                                    </select>
                                </div>

                                <!-- Vulnerable -->
                                <div>
                                    <label class="block font-semibold mb-2">
                                        Vulnerable <span class="text-red-500">*</span>
                                    </label>
                                    <select id="vulnerable"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-500">
                                        <option value="">Select</option>
                                        <option value="LGBTQIA+" ${registration?.vulnerable === 'LGBTQIA+' ? 'selected' : ''}>LGBTQIA+</option>
                                        <option value="Person with Disability" ${registration?.vulnerable === 'Person with Disability' ? 'selected' : ''}>Person with Disability</option>
                                        <option value="Indigenous people" ${registration?.vulnerable === 'Indigenous people' ? 'selected' : ''}>Indigenous people</option>
                                        <option value="Other" ${registration?.vulnerable === 'Other' ? 'selected' : ''}>Other</option>
                                    </select>
                                </div>

                                <!-- Allow Photo -->
                                <div>
                                    <label class="block font-semibold mb-2">Allow photo</label>
                                    <select id="allow_photos"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-500">
                                        <option value="">Select</option>
                                        <option value="1" ${registration?.allow_photos == 1 ? 'selected' : ''}>Yes</option>
                                        <option value="0" ${registration?.allow_photos == 0 ? 'selected' : ''}>No</option>
                                    </select>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block font-semibold mb-2">Email *</label>
                                    <input id="email" type="email"
                                        placeholder="you@example.com"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-500"
                                        value="${registration?.email ?? ''}">
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="block font-semibold mb-2">Phone Number</label>
                                    <input id="phone" type="text"
                                        placeholder="Your phone number"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-500"
                                        value="${registration?.phone ?? ''}">
                                </div>

                                <!-- Organization -->
                                <div>
                                    <label class="block font-semibold mb-2">Organization / University</label>
                                    <input id="organization" type="text"
                                        placeholder="Organization name"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-500"
                                        value="${registration?.organization ?? ''}">
                                </div>

                                <!-- Position -->
                                <div>
                                    <label class="block font-semibold mb-2">Position / Skills</label>
                                    <input id="position" type="text"
                                        placeholder="Your position"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-500"
                                        value="${registration?.position ?? ''}">
                                </div>

                                <!-- Location -->
                                <div>
                                    <label class="block font-semibold mb-2">
                                        Location (Province / District)
                                    </label>
                                    <input id="org_location" type="text"
                                        placeholder="e.g. Phnom Penh / Chamkarmon"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-500"
                                        value="${registration?.org_location ?? ''}">
                                </div>

                            </div>
                        </div>
                        `,
                    preConfirm: () => {
                        const name = document.getElementById('name').value.trim();
                        const email = document.getElementById('email').value.trim();
                        const vulnerable = document.getElementById('vulnerable').value;

                        if (!name || !email || !vulnerable) {
                            Swal.showValidationMessage('Please fill all required fields');
                            return false;
                        }

                        return {
                            name,
                            age: document.getElementById('age').value,
                            gender: document.getElementById('gender').value,
                            vulnerable,
                            allow_photos: document.getElementById('allow_photos').value,
                            email,
                            phone: document.getElementById('phone').value,
                            organization: document.getElementById('organization').value,
                            position: document.getElementById('position').value,
                            org_location: document.getElementById('org_location').value,
                        };
                    }
                }).then(result => {
                    if (!result.isConfirmed) return;

                    fetch(
                            registration ? `/registrations/${registration.id}` : `/registrations/${eventId}`, {
                                method: registration ? 'PUT' : 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(result.value)
                            }
                        )
                        .then(res => res.json())
                        .then(() => {
                            Swal.fire('Success', 'Saved successfully!', 'success')
                                .then(() => location.reload());
                        })
                        .catch(() => Swal.fire('Error', 'Something went wrong', 'error'));
                });
            }

            function confirmDelete(button) {
                const form = button.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This registration will be permanently deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626', // red
                    cancelButtonColor: '#6b7280', // gray
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
