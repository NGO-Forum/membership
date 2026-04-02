<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register for {{ $event->title }}</title>

    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-emerald-700 via-green-600 to-lime-500 px-4 py-4">

    <div class="mx-auto max-w-3xl">
        <div class="overflow-hidden rounded-[28px] border border-white/30 bg-white/95 shadow-2xl backdrop-blur-sm">
            <div class="relative px-6 py-8 md:px-10 md:py-10">
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(34,197,94,0.10),transparent_30%),radial-gradient(circle_at_bottom_left,rgba(16,185,129,0.10),transparent_28%)]">
                </div>

                <div class="relative">
                    <div class="mb-8 text-center">
                        <img src="/logo.png" alt="Logo" class="mx-auto mb-5 h-20 md:h-28" />

                        <div
                            class="inline-flex items-center rounded-full border border-green-200 bg-green-50 px-4 py-1.5 text-sm font-semibold text-green-700">
                            Event Registration
                        </div>

                        <h2 class="mt-4 text-base text-left font-semibold tracking-tight text-slate-700 md:text-lg">
                            Register for: <span
                                class="mt-2 ml-2 text-lg font-bold text-green-700 tracking-tight md:text-xl">
                                {{ $event->title }}
                            </span>
                        </h2>

                    </div>

                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm">
                            <div class="mb-2 flex items-center gap-2 text-sm font-bold">
                                <span>⚠</span>
                                <span>Please fix the following errors:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div
                            class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-center text-green-700 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-center text-red-700 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($event->registration_close_date && now()->gte($event->registration_close_date))
                        <div
                            class="rounded-2xl border border-red-200 bg-red-50 px-5 py-5 text-center text-red-700 shadow-sm">
                            <div class="text-lg font-bold">❌ Registration is closed for this event.</div>
                        </div>
                    @else
                        <form action="{{ route('events.register.store', $event->id) }}" method="POST"
                            enctype="multipart/form-data" class="grid grid-cols-1 gap-4 md:gap-8 md:grid-cols-2">
                            @csrf

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Full Name</label>
                                <input type="text" name="name" required value="{{ old('name') }}"
                                    placeholder="Your full name"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100" />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Age</label>
                                <input type="number" name="age" min="1" max="120"
                                    value="{{ old('age') }}" placeholder="Enter your age"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100" />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Gender</label>
                                <select name="gender"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 focus:border-green-500 focus:ring-4 focus:ring-green-100">
                                    <option value="">Select</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Vulnerable <span class="text-red-500">*</span>
                                </label>

                                <select name="vulnerable" required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 focus:border-green-500 focus:ring-4 focus:ring-green-100">
                                    <option value="">Select</option>
                                    <option value="lgbtqia" {{ old('vulnerable') === 'lgbtqia' ? 'selected' : '' }}>
                                        1. LGBTQIA+ Community
                                    </option>

                                    <option value="disability"
                                        {{ old('vulnerable') === 'disability' ? 'selected' : '' }}>
                                        2. Person with Disability
                                    </option>

                                    <option value="indigenous"
                                        {{ old('vulnerable') === 'indigenous' ? 'selected' : '' }}>
                                        3. Indigenous people
                                    </option>

                                    <option value="women" {{ old('vulnerable') === 'women' ? 'selected' : '' }}>
                                        4. Vulnerable women
                                    </option>

                                    <option value="poor" {{ old('vulnerable') === 'poor' ? 'selected' : '' }}>
                                        5. Poor people
                                    </option>

                                    <option value="monks" {{ old('vulnerable') === 'monks' ? 'selected' : '' }}>
                                        6. Monks
                                    </option>

                                    <option value="other" {{ old('vulnerable') === 'none' ? 'selected' : '' }}>
                                        7. None
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Allow Photo</label>
                                <select name="allow_photos"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 focus:border-green-500 focus:ring-4 focus:ring-green-100">
                                    <option value="">Select</option>
                                    <option value="1" {{ old('allow_photos') == '1' ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="0" {{ old('allow_photos') === '0' ? 'selected' : '' }}>No
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100" />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    placeholder="Your phone number"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100" />
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-sm font-semibold text-slate-700">Organization/University/School</label>
                                <input type="text" name="organization" value="{{ old('organization') }}"
                                    placeholder="Organization name"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100" />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Position/Skills of
                                    study</label>
                                <input type="text" name="position" value="{{ old('position') }}"
                                    placeholder="Your position"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-3 block text-sm font-semibold text-slate-700">
                                    Where do you from?
                                </label>

                                <div class="grid grid-cols-1 gap-4 md:gap-8 md:grid-cols-2">
                                    <label
                                        class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-300 bg-white px-4 py-4 shadow-sm transition hover:border-green-400 hover:bg-green-50">
                                        <input type="radio" name="residence_type" value="phnom_penh"
                                            class="h-4 w-4 accent-green-600"
                                            {{ old('residence_type') == 'phnom_penh' ? 'checked' : '' }}>
                                        <div>
                                            <p class="font-semibold text-slate-800">Phnom Penh</p>
                                        </div>
                                    </label>

                                    <label
                                        class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-300 bg-white px-4 py-4 shadow-sm transition hover:border-green-400 hover:bg-green-50">
                                        <input type="radio" name="residence_type" value="community"
                                            class="h-4 w-4 accent-green-600"
                                            {{ old('residence_type') == 'community' ? 'checked' : '' }}>
                                        <div>
                                            <p class="font-semibold text-slate-800">Province</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div id="address_fields" class="hidden md:col-span-2">
                                <div class="grid grid-cols-1 gap-4 md:gap-8 md:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">Village</label>
                                        <input type="text" id="village" name="village"
                                            value="{{ old('village') }}" placeholder="Enter village"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100" />
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">Commune</label>
                                        <input type="text" id="commune" name="commune"
                                            value="{{ old('commune') }}" placeholder="Enter commune"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100" />
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">District</label>
                                        <input type="text" id="district" name="district"
                                            value="{{ old('district') }}" placeholder="Enter district"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100" />
                                    </div>

                                    <div id="org_location_field" class="hidden">
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Province
                                        </label>
                                        <input type="text" id="org_location" name="org_location"
                                            value="{{ old('org_location') }}" placeholder="e.g. Kampong Cham"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100" />
                                    </div>
                                </div>
                            </div>

                            <div class="hidden md:col-span-2" id="dsa_section">
                                <label class="mb-1 block text-sm font-semibold text-slate-700">
                                    Daily Support Allowance (DSA)
                                </label>
                                <p class="mb-3 text-sm text-slate-500">
                                    Please indicate who will cover your DSA for this event
                                </p>

                                <div class="grid grid-cols-1 gap-4 md:gap-8 md:grid-cols-2">
                                    <label id="dsa_own_card"
                                        class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-300 bg-white px-4 py-4 shadow-sm transition hover:border-green-400 hover:bg-green-50">
                                        <input type="radio" name="dsa_covered_by" value="own"
                                            class="h-4 w-4 accent-green-600"
                                            {{ old('dsa_covered_by') == 'own' ? 'checked' : '' }}>
                                        <div>
                                            <p class="font-semibold text-slate-800">Self Support</p>
                                        </div>
                                    </label>

                                    <label id="dsa_ngof_card"
                                        class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-300 bg-white px-4 py-4 shadow-sm transition hover:border-green-400 hover:bg-green-50">
                                        <input type="radio" name="dsa_covered_by" value="ngof"
                                            class="h-4 w-4 accent-green-600"
                                            {{ old('dsa_covered_by') == 'ngof' ? 'checked' : '' }}>
                                        <div>
                                            <p class="font-semibold text-slate-800">Need support from NGOF</p>
                                        </div>
                                    </label>
                                </div>
                            </div>



                            <div class="md:col-span-2 mt-2 flex items-center justify-center">
                                <button type="submit"
                                    class="inline-flex min-w-[180px] items-center justify-center rounded-2xl bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-3.5 text-base font-bold text-white shadow-lg shadow-green-500/20 transition duration-200 hover:-translate-y-0.5 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-200">
                                    Register
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const residenceRadios = document.querySelectorAll('input[name="residence_type"]');
        const dsaRadios = document.querySelectorAll('input[name="dsa_covered_by"]');
        const ownRadio = document.querySelector('input[name="dsa_covered_by"][value="own"]');
        const ngofRadio = document.querySelector('input[name="dsa_covered_by"][value="ngof"]');

        const dsaSection = document.getElementById('dsa_section');
        const orgLocationField = document.getElementById('org_location_field');
        const orgLocation = document.getElementById('org_location');

        const addressFields = document.getElementById('address_fields');
        const village = document.getElementById('village');
        const commune = document.getElementById('commune');
        const district = document.getElementById('district');

        const dsaNgofCard = document.getElementById('dsa_ngof_card');

        function getSelectedResidence() {
            return document.querySelector('input[name="residence_type"]:checked')?.value || '';
        }

        function resetAddressFields() {
            addressFields.classList.add('hidden');
            village.value = '';
            commune.value = '';
            district.value = '';

            village.removeAttribute('required');
            commune.removeAttribute('required');
            district.removeAttribute('required');
        }

        function resetLocationField() {
            orgLocationField.classList.add('hidden');
            orgLocation.value = '';
            orgLocation.removeAttribute('required');
        }

        function enableNgofOption() {
            ngofRadio.disabled = false;
            dsaNgofCard.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-slate-100');
            dsaNgofCard.classList.add('hover:border-green-400', 'hover:bg-green-50');
        }

        function disableNgofOption() {
            ngofRadio.disabled = true;
            dsaNgofCard.classList.add('opacity-50', 'cursor-not-allowed', 'bg-slate-100');
            dsaNgofCard.classList.remove('hover:border-green-400', 'hover:bg-green-50');
        }

        function updateResidenceUI() {
            const selectedResidence = getSelectedResidence();

            dsaSection.classList.add('hidden');
            resetLocationField();
            resetAddressFields();
            enableNgofOption();

            if (selectedResidence === 'phnom_penh') {
                orgLocation.value = 'Phnom Penh';
                ownRadio.checked = true;
                ngofRadio.checked = false;
                disableNgofOption();
            } else if (selectedResidence === 'community') {
                dsaSection.classList.remove('hidden');

                orgLocationField.classList.remove('hidden');
                orgLocation.setAttribute('required', 'required');

                addressFields.classList.remove('hidden');
                village.setAttribute('required', 'required');
                commune.setAttribute('required', 'required');
                district.setAttribute('required', 'required');

                @if (old('residence_type') !== 'community')
                    dsaRadios.forEach(radio => radio.checked = false);
                @endif
            } else {
                dsaRadios.forEach(radio => radio.checked = false);
            }
        }

        residenceRadios.forEach(radio => {
            radio.addEventListener('change', updateResidenceUI);
        });

        window.addEventListener('load', updateResidenceUI);
    </script>

</body>

</html>
