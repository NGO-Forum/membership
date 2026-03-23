<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration - Thank You</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-green-600 p-4 sm:p-6 lg:p-8">
    <div class="text-center w-full max-w-3xl">
        <!-- Header Section -->
        <div class="flex flex-row items-center justify-center text-white mb-4 sm:mb-6">
            <i class="fas fa-calendar-check text-yellow-400 text-2xl sm:text-4xl mr-4 sm:mr-6 mb-0"></i>
            <h1 class="text-2xl sm:text-4xl font-bold">
                Event Registration
            </h1>
        </div>

        <!-- Subtitle -->
        <p class="text-lg sm:text-xl mb-8 sm:mb-10 text-white">
            @if (session('closed'))
                Thank you for your interest in this event.
            @else
                Thank you for registering for our event! Your information has been successfully submitted.
            @endif
        </p>

        <!-- Main Content Card -->
        <div class="w-full shadow-2xl bg-gray-50 rounded-lg border border-gray-200">
            <div class="p-6 sm:p-8">
                <h2 class="text-left text-green-600 mb-4 text-xl">
                    Dear Participant,
                </h2>
                @if (session('closed'))
                    <p class="text-left text-gray-700 leading-relaxed">
                        Thank you for your interest in this event. Unfortunately, registration is now closed.
                        We hope to see you in future events.
                    </p>
                @else
                    <p class="text-left text-gray-700 leading-relaxed">
                        Your registration has been successfully recorded. We look forward to seeing you at the event.
                        If you have any questions, please contact our support team.
                    </p>
                @endif
            </div>

            <!-- Thank You Section -->
            <div
                class="flex flex-col items-center justify-center p-8 sm:p-14 bg-white rounded-lg border-t border-gray-100">
                <!-- Checkmark Icon -->
                <div class="{{ session('closed') ? 'bg-yellow-100' : 'bg-green-100' }} rounded-full mb-6 sm:mb-8 p-4 sm:p-6">
                    <i class="fas {{ session('closed') ? 'fa-exclamation-circle text-yellow-500' : 'fa-check-circle text-green-500' }} text-4xl sm:text-8xl"></i>
                </div>
                <h2 class="text-xl sm:text-4xl font-semibold mb-4 {{ session('closed') ? 'text-yellow-600' : 'text-green-600' }}">
                    {{ session('closed') ? 'Registration Closed' : 'Thank You!' }}
                </h2>
                <p
                    class="text-md sm:text-lg text-center {{ session('closed') ? 'text-yellow-700' : 'text-green-700' }}">
                    @if (session('closed'))
                        Registration is now closed, but we appreciate your interest.
                    @else
                        Your registration has been successfully submitted. We are excited to welcome you to the event!
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>

</html>
