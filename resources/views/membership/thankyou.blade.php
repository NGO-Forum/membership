<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOF Membership</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center p-2 sm:p-4">

    <div class="w-full max-w-3xl mx-auto">

        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-500 px-4 sm:px-4 py-4 sm:py-6 text-center">

                <!-- Icon -->
                <div
                    class="w-16 h-16 sm:w-24 sm:h-24 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg mb-4 sm:mb-6">
                    <i class="fas fa-check text-green-600 text-3xl sm:text-5xl"></i>
                </div>

                <!-- Title -->
                <h1 class="text-2xl sm:text-4xl font-bold text-white leading-tight">
                    You've done a great job!
                </h1>

            </div>

            <!-- Content -->
            <div class="p-5 sm:p-8 md:p-12">

                <h2 class="text-base sm:text-xl font-bold text-green-700 mb-5">
                    Dear {{ Auth::user()->name ?? 'Valued NGOF Member' }},
                </h2>

                <div class="space-y-5 text-gray-700 text-base leading-relaxed">

                    <p>
                        Thank you for your submission. Your request and supporting
                        documents have been successfully received by
                        <strong>The NGO Forum on Cambodia (NGOF)</strong>.
                    </p>

                    <p>
                        Our management team will carefully review the information
                        provided and contact you should any additional
                        clarification or documentation be required.
                    </p>

                    <p>
                        We sincerely appreciate your engagement and continued
                        contribution to strengthening civil society collaboration
                        in Cambodia.
                    </p>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
