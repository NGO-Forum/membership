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
            <i class="fas fa-handshake text-yellow-400 text-4xl sm:text-5xl mr-3"></i>
            <h1 class="text-xl md:text-4xl font-bold text-green-700">The NGO Forum on Cambodia</h1>
        </div>

        <!-- Subtitle -->
        <h2 class="text-lg md:text-2xl font-semibold text-center mb-6">Membership Application Form</h2>

        <!-- Description -->
        <p class="text-gray-700 text-base md:text-lg leading-8 mb-4">
            Before applying for membership, NGOs are encouraged to meet with NGO FORUM staff and learn about NGO FORUM’s purpose, mission, and current activities. NGOs are permitted to join in NGO Forum activities for up to one year before deciding on whether to apply for membership. After one year, NGOs who wish to continue their involvement are expected to apply for membership. Local NGOs which have been active participants for at least one year will be offered free membership.
        </p>

        <!-- Links -->
        <p class="text-base md:text-lg mb-2">The following set of NGO FORUM documents may be obtained from the NGO Forum:</p>
        <ul class="list-disc list-inside leading-8 text-base md:text-lg mb-4">
            <li class="text-blue-600">
                <a href="https://53786707-5124-4ac6-84ff-9389bf387232.usrfiles.com/ugd/537867_fd395c42ad7246cd87360877c6424c93.pdf" 
                   target="_blank" class="hover:underline">The NGO FORUM By-Laws</a>
            </li>
            <li class="text-blue-600">
                <a href="https://53786707-5124-4ac6-84ff-9389bf387232.usrfiles.com/ugd/537867_00ea787fff40470ca049a4a2c85a7c21.pdf" 
                   target="_blank" class="hover:underline">NGO FORUM METRI Strategic Plan</a>
            </li>
            <li><span class="text-gray-700">details of Membership fees</span></li>
        </ul>

        <!-- Footer text -->
        <p class="text-gray-700 text-base md:text-lg leading-8 mb-6">
            Membership applications are considered by the NGO Forum's Management Committee, which meets every three months. Specific responsibilities of members include attending Quarterly Members Meetings, Annual General Meeting, and voting on all issues brought to the membership, including Management Committee elections.
        </p>

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
