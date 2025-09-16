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

    <div class="bg-white p-8 mt-4 mb-4 rounded-2xl shadow-2xl max-w-4xl w-full">
        <img src="/logo.PNG" alt="" class="h-24 md:h-40 mx-auto mb-6" />
        <h2 class="text-lg md:text-2xl font-extrabold mb-8 text-center text-gray-500">Register for: <span class="text-xl md:text-3xl text-green-800">{{ $event->title }}</span></h2>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-400 text-red-700 rounded-md p-4">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 rounded-md p-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('events.register.store', $event->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    required
                    value="{{ old('name') }}"
                    placeholder="Your full name"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-green-300 focus:border-green-500 transition"
                />
            </div>

            <div>
                <label for="gender" class="block text-gray-700 font-semibold mb-2">Gender</label>
                <select
                    name="gender"
                    id="gender"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-green-300 focus:border-green-500 transition"
                >
                    <option value="">Select</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    required
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-green-300 focus:border-green-500 transition"
                />
            </div>

            <div>
                <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                <input
                    type="text"
                    name="phone"
                    id="phone"
                    value="{{ old('phone') }}"
                    placeholder="Your phone number"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-green-300 focus:border-green-500 transition"
                />
            </div>

            <div>
                <label for="organization" class="block text-gray-700 font-semibold mb-2">Organization</label>
                <input
                    type="text"
                    name="organization"
                    id="organization"
                    value="{{ old('organization') }}"
                    placeholder="Your organization"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-green-300 focus:border-green-500 transition"
                />
            </div>

            <div>
                <label for="position" class="block text-gray-700 font-semibold mb-2">Position</label>
                <input
                    type="text"
                    name="position"
                    id="position"
                    value="{{ old('position') }}"
                    placeholder="Your position"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-green-300 focus:border-green-500 transition"
                />
            </div>

            <div class="md:col-span-2">
                <button
                    type="submit"
                    class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition"
                >
                    Register
                </button>
            </div>
        </form>
    </div>

</body>
</html>
