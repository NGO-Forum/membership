<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-600 min-h-screen flex items-center justify-center px-4">

<div class="bg-white w-full max-w-md rounded-xl shadow-xl p-8">

    <!-- Logo -->
    <div class="flex flex-col items-center mb-6">
        <img src="/logo.png" alt="NGOF Logo" class="h-32 mb-3">
        <h2 class="text-2xl font-bold text-green-600">
            Forgot Your Password?
        </h2>
        <p class="text-gray-600 text-center mt-2 text-sm">
            No problem. Enter your registered email address and we’ll send you a secure link to reset your password.
        </p>
    </div>

    <!-- Status -->
    @if (session('status'))
        <div class="mb-4 text-green-700 bg-green-100 border border-green-200 p-3 rounded text-center text-sm">
            {{ session('status') }}
        </div>
    @endif

    <!-- Errors -->
    @if ($errors->any())
        <div class="mb-4 text-red-700 bg-red-100 border border-red-200 p-3 rounded text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-1">
                Email Address
            </label>
            <input type="email" name="email" required
                placeholder="example@email.com"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <button type="submit"
            class="w-full bg-green-600 text-white py-2.5 rounded-md font-semibold hover:bg-green-700 transition">
            Send Password Reset
        </button>
    </form>

    <!-- Back to login -->
    <div class="mt-6 text-center">
        <a href="{{ route('login') }}"
           class="text-sm text-green-600 hover:underline">
            ← Back to Login
        </a>
    </div>

</div>

</body>
</html>
