<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Application Form</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-600 min-h-screen p-2">
    <div class="max-w-4xl mx-auto bg-white border-4 border-green-600 rounded-lg p-6 sm:p-8">
        <h2 class="text-green-700 font-bold text-3xl mb-6 text-center">Application Details</h2>

        <form action="{{ route('memberships.storeForm') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Organization Names -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold block mb-2">Organization Name in English (Required)</label>
                    <input type="text" name="org_name_en" placeholder="Enter Name NGO"
                        class="border rounded w-full p-2" required>
                </div>
                <div>
                    <label class="font-semibold block mb-2">Organization Name in Khmer (Required)</label>
                    <input type="text" name="org_name_kh" placeholder="Enter Name NGO"
                        class="border rounded w-full p-2" required>
                </div>
            </div>

            <!-- Membership -->
            <div>
                <label class="font-semibold block mb-2">
                    Wishes to apply for membership of the "NGO Forum on Cambodia" as: (Required)
                </label>
                <div class="flex flex-col gap-2 mt-2">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="membership_type" value="Full member" required> Full member
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="membership_type" value="Associate member" required> Associate member
                    </label>
                </div>
                <p class="text-sm mt-3">Please tick one:</p>
                <ul class="list-disc pl-5 text-sm mt-2 leading-6 space-y-1">
                    <li>Full member (for NGOs implementing projects in Cambodia)</li>
                    <li>Associate member (for NGOs not operational in Cambodia that supports Cambodia’s development)</li>
                </ul>
            </div>

            <!-- Director Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold block mb-2">Name of Director *</label>
                    <input type="text" name="director_name" placeholder="Enter your name"
                        class="border rounded w-full p-2" required>
                </div>
                <div>
                    <label class="font-semibold block mb-2">E-mail address of Director *</label>
                    <input type="email" name="director_email" placeholder="Enter Email"
                        class="border rounded w-full p-2" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold block mb-2">Phone Number of Director *</label>
                    <input type="text" name="director_phone" placeholder="Enter your phone"
                        class="border rounded w-full p-2" required>
                </div>
                <div>
                    <label class="font-semibold block mb-2">Phone Number of the Alternative (if any)</label>
                    <input type="text" name="alt_phone" placeholder="Enter phone"
                        class="border rounded w-full p-2">
                </div>
            </div>

            <!-- Website & Social Media -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold block mb-2">Website Address</label>
                    <input type="url" name="website" placeholder="Enter your URL"
                        class="border rounded w-full p-2">
                </div>
                <div>
                    <label class="font-semibold block mb-2">Social Media (Facebook, Instagram, LinkedIn,...)</label>
                    <input type="text" name="social_media" placeholder="Enter your Name"
                        class="border rounded w-full p-2">
                </div>
            </div>

            <!-- Representative -->
            <div>
                <p class="mb-2">All member organizations are required to participate in Members Meetings. Please list below the name of the person who will most often represent your organization at Quarterly Members Meetings:</p>
            </div>

            <!-- Representative Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold block mb-2">Full Name *</label>
                    <input type="text" name="representative_name" placeholder="Enter your name"
                        class="border rounded w-full p-2" required>
                </div>
                <div>
                    <label class="font-semibold block mb-2">E-mail address *</label>
                    <input type="email" name="representative_email" placeholder="Enter Email"
                        class="border rounded w-full p-2" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold block mb-2">Phone Number *</label>
                    <input type="text" name="representative_phone" placeholder="Enter your phone"
                        class="border rounded w-full p-2" required>
                </div>
                <div>
                    <label class="font-semibold block mb-2">Position *</label>
                    <input type="text" name="representative_position" placeholder="Enter your position"
                        class="border rounded w-full p-2" required>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-8">
                <button type="button" onclick="window.location='{{ route('membership.menbershipDetail') }}'"
                        class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Back
                </button>
                <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Next
                </button>
            </div>
        </form>
    </div>
</body>
</html>
