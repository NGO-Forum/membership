<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Application Form</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-green-600 min-h-screen p-2">

    <div class="bg-white rounded-lg shadow-lg p-6 md:p-10 max-w-4xl mx-auto">
        <!-- Title -->
        <div class="flex items-center justify-center mb-4 space-x-3">
            <h1 class="text-xl md:text-4xl font-bold text-green-700">The NGO Forum on Cambodia</h1>
        </div>

        <!-- Subtitle -->
        <h2 class="text-lg md:text-3xl font-semibold text-blue-900 text-center mb-6">Membership Form</h2>

        <!-- Description -->
        <p class="text-green-600 text-lg font-semibold md:text-xl leading-8 mb-4">
            Welcome to the NGO Forum on Cambodia membership page!
        </p>
        <p class="text-gray-700 text-base md:text-lg leading-8 mb-4">
            Thank you for your interest being a member of the NGO Forum on Cambodia (NGOF).
        </p>

        <!-- Links -->
        <p class="text-base md:text-lg mb-2">You are encouraged to meet with NGO Forum staff and learn about NGO Forum’s
            vision, mission, and current program focuses, activities and please review the following documents:</p>
        <ul class="list-disc list-inside leading-8 text-base md:text-lg mb-4">
            <li class="text-blue-600">
                <a href="https://53786707-5124-4ac6-84ff-9389bf387232.usrfiles.com/ugd/537867_fd395c42ad7246cd87360877c6424c93.pdf"
                    target="_blank" class="hover:underline">NGO Forum By-Laws</a>
            </li>
            <li class="text-blue-600">
                <a href="https://53786707-5124-4ac6-84ff-9389bf387232.usrfiles.com/ugd/537867_00ea787fff40470ca049a4a2c85a7c21.pdf"
                    target="_blank" class="hover:underline">NGO Forum METRI Strategic Plan</a>
            </li>
            <li class="text-blue-600">
                <a href="https://api.ngoforum.site/storage/librarys/8RO3WMYo64Xij67pZLcM6u2Bcg6IskTXeR1WHvHC.pdf"
                    target="_blank" class="hover:underline">NGO Forum Membership Fee</a>
            </li>
        </ul>

        <!-- Footer text -->
        <p class="text-gray-800 text-base md:text-lg leading-8 mb-2">
            Being a member of the NGOF, you will gain:
        </p>
        <ol class="space-y-4 text-base md:text-lg mb-6">
            <li class="flex items-center">
                <span
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-green-700 text-white font-semibold mr-4">
                    1
                </span>
                <span class="text-gray-800 font-medium">Advocacy & Influence</span>
            </li>
            <li class="flex items-center">
                <span
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-green-700 text-white font-semibold mr-4">
                    2
                </span>
                <span class="text-gray-800 font-medium">Networking & Collaboration</span>
            </li>
            <li class="flex items-center">
                <span
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-green-700 text-white font-semibold mr-4">
                    3
                </span>
                <span class="text-gray-800 font-medium">Information & Resources</span>
            </li>
            <li class="flex items-center">
                <span
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-green-700 text-white font-semibold mr-4">
                    4
                </span>
                <span class="text-gray-800 font-medium">Logistical & Financial Support</span>
            </li>
            <li class="flex items-center">
                <span
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-green-700 text-white font-semibold mr-4">
                    5
                </span>
                <span class="text-gray-800 font-medium">Capacity Development and Learning</span>
            </li>
            <li class="flex items-center">
                <span
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-green-700 text-white font-semibold mr-4">
                    6
                </span>
                <span class="text-gray-800 font-medium">And many more</span>
            </li>
        </ol>



        <!-- Next Button -->
        <div class="flex justify-between mt-6">
            <a href="{{ route('home') }}"
                class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 hover:scale-105 transition-transform duration-200">
                Back
            </a>
            <a href="{{ route('membership.membershipForm') }}"
                class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 hover:scale-105 transition-transform duration-200">
                Next
            </a>
        </div>
    </div>

</body>

</html>
