<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-600 flex items-center justify-center min-h-screen px-4">
    <div class="bg-white p-8 mt-4 mb-4 rounded-2xl shadow-2xl max-w-3xl w-full">
        <h2 class="text-3xl font-extrabold mb-8 text-center text-green-800">Register</h2>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-400 text-red-700 rounded-md p-4">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            <div>
                <label for="ngo" class="block text-gray-700 font-semibold mb-2">Name NGO</label>
                <input
                    type="text"
                    name="ngo"
                    id="ngo"
                    required
                    value="{{ old('ngo') }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition"
                    placeholder="Enter NGO name"
                />
            </div>

            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Username</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    required
                    value="{{ old('name') }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition"
                    placeholder="Your full name"
                />
            </div>

            <div class="md:col-span-2">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    required
                    value="{{ old('email') }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition"
                    placeholder="you@example.com"
                />
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition"
                    placeholder="Enter password"
                />
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition"
                    placeholder="Re-enter password"
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


        <p class="mt-6 text-center text-gray-700">
            Already have an account?
            <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">Login here</a>
        </p>
    </div>
</body>
</html>
