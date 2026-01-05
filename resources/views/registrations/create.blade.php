<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register for {{ $event->title }}</title>

    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-600 flex items-center justify-center min-h-screen px-4">

    <div class="bg-white p-8 mt-6 mb-6 rounded-2xl shadow-2xl max-w-4xl w-full">

        <!-- LOGO -->
        <img src="/logo.png" alt="Logo" class="h-24 md:h-40 mx-auto mb-6" />

        <!-- TITLE -->
        <h2 class="text-lg md:text-2xl font-extrabold mb-8 text-center text-gray-500">
            Register for:
            <span class="block text-xl md:text-3xl text-green-800 mt-2">
                {{ $event->title }}
            </span>
        </h2>

        <!-- ERRORS -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-400 text-red-700 rounded-md p-4">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- SUCCESS -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 rounded-md p-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('events.register.store', $event->id) }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- NAME -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="Your full name"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-green-300 focus:border-green-500" />
            </div>

            <!-- AGE -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Age</label>
                <input type="number" name="age" min="1" max="120" value="{{ old('age') }}"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-green-300 focus:border-green-500" />
            </div>

            <!-- GENDER -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Gender</label>
                <select name="gender"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-green-300 focus:border-green-500">
                    <option value="">Select</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <!-- VULNERABLE -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Vulnerable <span class="text-red-500">*</span>
                </label>

                <select name="vulnerable" required
                    class="w-full rounded-lg border px-4 py-3 focus:ring-green-300 focus:border-green-500">
                    <option value="">Select</option>

                    <option value="LGBTQIA+" {{ old('vulnerable') === 'LGBTQIA+' ? 'selected' : '' }}>
                        1. LGBTQIA+ Community
                    </option>

                    <option value="Person with Disability"
                        {{ old('vulnerable') === 'Person with Disability' ? 'selected' : '' }}>
                        2. Person with Disability
                    </option>

                    <option value="Indigenous people"
                        {{ old('vulnerable') === 'Indigenous people' ? 'selected' : '' }}>
                        3. Indigenous people
                    </option>

                    <option value="Other" {{ old('vulnerable') === 'Other' ? 'selected' : '' }}>
                        4. Other
                    </option>
                </select>
            </div>

            <!-- Allow photo -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Allow photo
                </label>

                <select name="allow_photos"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-green-300 focus:border-green-500">

                    <option value="">Select</option>

                    <option value="1" {{ old('allow_photos') == '1' ? 'selected' : '' }}>
                        Yes
                    </option>

                    <option value="0" {{ old('allow_photos') === '0' ? 'selected' : '' }}>
                        No
                    </option>

                </select>
            </div>



            <!-- EMAIL -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" required value="{{ old('email') }}" placeholder="you@example.com"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-green-300 focus:border-green-500" />
            </div>

            <!-- PHONE -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Your phone number"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-green-300 focus:border-green-500" />
            </div>

            <!-- ORGANIZATION -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Organization/University</label>
                <input type="text" name="organization" value="{{ old('organization') }}"
                    placeholder="Organization name"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-green-300 focus:border-green-500" />
            </div>

            <!-- POSITION -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Position/Skills</label>
                <input type="text" name="position" value="{{ old('position') }}" placeholder="Your position"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-green-300 focus:border-green-500" />
            </div>

            <!-- ORG LOCATION -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Location (Province / District)
                </label>
                <input type="text" name="org_location" value="{{ old('org_location') }}"
                    placeholder="e.g. Phnom Penh / Chamkarmon"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-green-300 focus:border-green-500" />
            </div>

            <!-- SUBMIT -->
            <div class="md:col-span-2 flex items-center justify-center">
                <button type="submit"
                    class="px-4 bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition">
                    Register
                </button>
            </div>

        </form>
    </div>

</body>

</html>
