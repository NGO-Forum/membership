<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-600 flex items-center justify-center min-h-screen px-4">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
        <!-- Logo and Text -->
        <div class="flex flex-col items-center mb-8">
            <img src="/logo.png" alt="Logo" class="h-36 w-56 mb-4" />

            <p class="text-gray-600 mt-1">Please login to your account</p>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-600 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                    value="{{ old('email') }}">
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox text-green-600">
                    <span class="ml-2 text-gray-700">Remember me</span>
                </label>
                <a href="#" class="text-green-600 hover:underline text-sm">Forgot password?</a>
            </div>
            <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-md font-semibold hover:bg-green-700 transition">Login</button>
        </form>

        <p class="mt-4 text-center text-gray-600">
            Don't have an account? <a href="{{ route('register') }}" class="text-green-600 hover:underline">Register here</a>
        </p>
    </div>
</body>
</html>
