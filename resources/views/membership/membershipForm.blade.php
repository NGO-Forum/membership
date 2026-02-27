<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Membership Form</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-600 min-h-screen p-2">
    <div class="max-w-4xl mx-auto bg-white border-4 border-green-600 rounded-lg p-6 sm:p-8 shadow">
        <h2 class="text-green-700 font-bold text-3xl mb-6 text-center">Membership Details</h2>

        <form action="{{ route('memberships.storeForm') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
                    <p class="font-semibold mb-2">Please fix the following:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Organization Names -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold block mb-2 text-gray-700">Organization Name in English
                        (Required)</label>
                    <input type="text" name="org_name_en" placeholder="Enter Name NGO"
                        value="{{ old('org_name_en') }}"
                        class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                        required>
                    @error('org_name_en')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="font-semibold block mb-2 text-gray-700">Acronym of your Organization in English
                        (Required)</label>
                    <input type="text" name="org_name_abbreviation" placeholder="Enter Acronym"
                        value="{{ old('org_name_abbreviation') }}"
                        class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                        required>
                    @error('org_name_abbreviation')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="font-semibold block mb-2 text-gray-700">Organization Name in Khmer (Required)</label>
                    <input type="text" name="org_name_kh" placeholder="Enter Name NGO"
                        value="{{ old('org_name_kh') }}"
                        class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                        required>
                    @error('org_name_kh')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="font-semibold block mb-2 text-gray-700">Contact and Address (Required)</label>
                    <textarea name="address" rows="3" placeholder="Enter your full contact and address"
                        class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                        required>{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="font-semibold block mb-2 text-gray-700">Website Address</label>
                    <input type="url" name="website" placeholder="Enter your URL" value="{{ old('website') }}"
                        class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    @error('website')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="font-semibold block mb-2 text-gray-700">Facebook Page</label>
                    <input type="text" name="facebook" placeholder="Enter your Page or URL"
                        value="{{ old('facebook') }}"
                        class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    @error('facebook')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="font-semibold block mb-2 text-gray-700">LinkedIn Page</label>
                    <input type="text" name="linkedin" placeholder="Enter your Page or URL"
                        value="{{ old('linkedin') }}"
                        class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    @error('linkedin')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Membership -->
            <div>
                <label class="font-semibold block mb-2 text-gray-700">
                    Wishes to apply for membership of the "NGO Forum on Cambodia" as: (Required)
                </label>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-2">
                    <label
                        class="flex items-center gap-3 p-3 border border-gray-300 rounded-lg cursor-pointer hover:border-green-600 transition">
                        <input type="radio" name="membership_type" value="Full member" class="accent-green-600"
                            {{ old('membership_type') === 'Full member' ? 'checked' : '' }} required>
                        <span class="font-medium text-gray-700">Full member</span>
                    </label>

                    <label
                        class="flex items-center gap-3 p-3 border border-gray-300 rounded-lg cursor-pointer hover:border-green-600 transition">
                        <input type="radio" name="membership_type" value="Associate member" class="accent-green-600"
                            {{ old('membership_type') === 'Associate member' ? 'checked' : '' }} required>
                        <span class="font-medium text-gray-700">Associate member</span>
                    </label>
                </div>

                @error('membership_type')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Director Info -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Director Information:</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700">Name of Director *</label>
                        <input type="text" name="director_name" placeholder="Enter director name"
                            value="{{ old('director_name') }}"
                            class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                            required>
                        @error('director_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-semibold block mb-2 text-gray-700">E-mail address of Director *</label>
                        <input type="email" name="director_email" placeholder="Enter director email"
                            value="{{ old('director_email') }}"
                            class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                            required>
                        @error('director_email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-semibold block mb-2 text-gray-700">Phone Number of Director *</label>
                        <input type="text" name="director_phone" placeholder="Enter director phone"
                            value="{{ old('director_phone') }}"
                            class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                            required>
                        @error('director_phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-semibold block mb-2 text-gray-700">Phone Number of the Alternative (if
                            any)</label>
                        <input type="text" name="alt_phone" placeholder="Enter alternative phone"
                            value="{{ old('alt_phone') }}"
                            class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                        @error('alt_phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Representative -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Alternative Contact Person:</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700">Full Name *</label>
                        <input type="text" name="representative_name" placeholder="Enter full name"
                            value="{{ old('representative_name') }}"
                            class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                            required>
                        @error('representative_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-semibold block mb-2 text-gray-700">Position *</label>
                        <input type="text" name="representative_position" placeholder="Enter position"
                            value="{{ old('representative_position') }}"
                            class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                            required>
                        @error('representative_position')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-semibold block mb-2 text-gray-700">E-mail address *</label>
                        <input type="email" name="representative_email" placeholder="Enter email"
                            value="{{ old('representative_email') }}"
                            class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                            required>
                        @error('representative_email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-semibold block mb-2 text-gray-700">Phone Number *</label>
                        <input type="text" name="representative_phone" placeholder="Enter phone number"
                            value="{{ old('representative_phone') }}"
                            class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                            required>
                        @error('representative_phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-between mt-8">
                <button type="button" onclick="window.location='{{ route('membership.menbershipDetail') }}'"
                    class="bg-white border border-green-600 text-green-700 px-6 py-2 rounded-lg hover:bg-green-50 transition font-semibold">
                    Back
                </button>

                <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                    Next
                </button>
            </div>
        </form>
    </div>
</body>

</html>
