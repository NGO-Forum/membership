<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>NGOF Membership</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-600 font-sans">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">

        <header class="mb-8 text-center px-4 sm:px-0">
            <div class="flex flex-col items-center sm:flex-row sm:justify-center gap-3 mb-3 text-green-700">
                <i class="fas fa-handshake text-yellow-400 text-4xl sm:text-3xl"></i>
                <h1 class="text-2xl sm:text-3xl font-bold">NGOF Membership Reconfirmation</h1>
            </div>
            <p class="text-gray-600 font-light max-w-md mx-auto px-2 sm:px-0">
                Update your organization's membership information
            </p>
        </header>

        @if (session('success'))
            <div class="mb-6 p-4 rounded border border-green-400 bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('membership.submitUpload') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            {{-- Additional Info --}}
            <h3 class="text-lg font-semibold text-green-700 mb-3"><i class="fas fa-info-circle mr-2"></i> Additional
                Information about Your Organization</h3>

            <label for="mailing-address" class="block font-semibold mb-1">Mailing Address:</label>
            <input type="text" id="mailing-address" name="mailing-address" value="{{ old('mailing-address') }}"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"
                placeholder="Enter Mailing Address">
            @error('mailing-address')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label for="physical-address" class="block font-semibold mt-6 mb-1">Physical Address:</label>
            <input type="text" id="physical-address" name="physical-address" value="{{ old('physical-address') }}"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"
                placeholder="Enter Physical Address">
            @error('physical-address')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label for="facebook" class="block font-semibold mt-6 mb-1">Facebook:</label>
            <input type="text" id="facebook" name="facebook" value="{{ old('facebook') }}"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"
                placeholder="Enter Facebook URL">
            @error('facebook')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label for="website" class="block font-semibold mt-6 mb-1">Website:</label>
            <input type="text" id="website" name="website" value="{{ old('website') }}"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"
                placeholder="Enter Website URL">
            @error('website')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            {{-- Preferred Channel of Communication --}}
            <h3 class="text-lg font-semibold text-green-700 mt-6 mb-3">
                <i class="fas fa-envelope text-green-600 mr-4"></i>Preferred Channel of Communication
            </h3>
            <div class="space-y-4">

                @php $commChannelsOld = old('comm-channel', []); @endphp

                {{-- Telegram --}}
                <div>
                    <label class="inline-flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" id="comm-telegram" name="comm-channel[]" value="Telegram"
                            onchange="togglePhoneInput('telegram')" class="form-checkbox h-5 w-5 text-green-600"
                            {{ in_array('Telegram', $commChannelsOld) ? 'checked' : '' }}>
                        <span>Telegram</span>
                    </label>
                    <div id="phone-group-telegram" class="mt-2"
                        style="display: {{ in_array('Telegram', $commChannelsOld) ? 'block' : 'none' }};">
                        <label for="phone-telegram" class="block font-normal mb-1">Telegram Phone Number <span
                                class="text-red-600">*</span></label>
                        <input type="text" id="phone-telegram" name="phone-telegram"
                            placeholder="Telegram Phone Number" value="{{ old('phone-telegram') }}"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                        @error('phone-telegram')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Signal --}}
                <div>
                    <label class="inline-flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" id="comm-signal" name="comm-channel[]" value="Signal"
                            onchange="togglePhoneInput('signal')" class="form-checkbox h-5 w-5 text-green-600"
                            {{ in_array('Signal', $commChannelsOld) ? 'checked' : '' }}>
                        <span>Signal</span>
                    </label>
                    <div id="phone-group-signal" class="mt-2"
                        style="display: {{ in_array('Signal', $commChannelsOld) ? 'block' : 'none' }};">
                        <label for="phone-signal" class="block font-normal mb-1">Signal Phone Number <span
                                class="text-red-600">*</span></label>
                        <input type="text" id="phone-signal" name="phone-signal" placeholder="Signal Phone Number"
                            value="{{ old('phone-signal') }}"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                        @error('phone-signal')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label class="inline-flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" id="comm-whatsapp" name="comm-channel[]" value="WhatsApp"
                            onchange="togglePhoneInput('whatsapp')" class="form-checkbox h-5 w-5 text-green-600"
                            {{ in_array('WhatsApp', $commChannelsOld) ? 'checked' : '' }}>
                        <span>WhatsApp</span>
                    </label>
                    <div id="phone-group-whatsapp" class="mt-2"
                        style="display: {{ in_array('WhatsApp', $commChannelsOld) ? 'block' : 'none' }};">
                        <label for="phone-whatsapp" class="block font-normal mb-1">WhatsApp Phone Number <span
                                class="text-red-600">*</span></label>
                        <input type="text" id="phone-whatsapp" name="phone-whatsapp"
                            placeholder="WhatsApp Phone Number" value="{{ old('phone-whatsapp') }}"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                        @error('phone-whatsapp')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- Required Documents --}}
            <h3 class="text-lg font-semibold text-green-700 mt-6 mb-3">
                <i class="fas fa-file-alt text-green-600 mr-4"></i>Required Documents
            </h3>

            @foreach ([
                'letter' => 'Letter explaining why your organization wishes to join NGOF',
                'constitution' => "Organization's Constitution and/or By-Laws",
                'activities' => 'List or summary of current activities in Cambodia; brochures or other explanatory documents',
                'funding' => 'List of funding sources and Board Members/decision-making body',
                'registration' => 'Official authorization/Registration with MoI to operate in Cambodia',
                'strategic-plan' => "Organization's strategic plan",
                'fundraising-strategy' => 'Fundraising strategy (optional)',
                'audit-report' => 'Most recent Global audit report or Financial Report',
                'signature' => 'Signature',
            ] as $field => $label)
                <div class="mb-6 border border-gray-300 rounded-md p-4">
                    <label for="{{ $field }}" class="block font-normal mb-3">
                        {{ $label }}
                    </label>
                    <input type="file" id="{{ $field }}" name="{{ $field }}"
                        class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded file:border-0
                    file:text-sm file:font-semibold
                    file:bg-green-100 file:text-green-700 file:border-1
                    hover:file:bg-green-200">
                    @error($field)
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach



            {{-- Textareas --}}
            <label for="vision" class="block font-semibold mb-2">Vision Statement <span
                    class="text-red-600">*</span></label>
            <textarea id="vision" name="vision" required placeholder="Enter Vision Statement"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 mb-4">{{ old('vision') }}</textarea>
            @error('vision')
                <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
            @enderror

            <label for="mission" class="block font-semibold mb-2">Mission Statement <span
                    class="text-red-600">*</span></label>
            <textarea id="mission" name="mission" required placeholder="Enter Mission Statement"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 mb-4">{{ old('mission') }}</textarea>
            @error('mission')
                <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
            @enderror

            <label for="goal" class="block font-semibold mb-2">Goal Statement <span
                    class="text-red-600">*</span></label>
            <textarea id="goal" name="goal" required placeholder="Enter Goal Statement"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 mb-4">{{ old('goal') }}</textarea>
            @error('goal')
                <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
            @enderror

            <label for="objectives" class="block font-semibold mb-2">Objectives Statement (if any)</label>
            <textarea id="objectives" name="objectives" placeholder="Enter Objectives Statement"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 mb-6">{{ old('objectives') }}</textarea>
            @error('objectives')
                <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
            @enderror

            <div class="bg-green-100 p-4 rounded-md mb-6 text-green-900">
                <strong class="block mb-2">Pledge of Commitment</strong>
                <p class="text-sm">
                    On behalf of my organization, I accept the Mission statement and Values of the NGO Forum on Cambodia
                    and agree to abide by the By-Laws governing membership. I believe that my organization fully
                    qualifies for membership, as outlined in the NGO Forum's By-Laws, and have attached the required
                    documentary evidence.<br>
                    My organization agrees to participate regularly in member meetings and to pay annual membership fees
                    (except where exempt).
                </p>
            </div>

            <label for="director-name" class="block font-semibold mb-2">Name of Director <span
                    class="text-red-600">*</span></label>
            <input type="text" id="director-name" name="director-name" value="{{ old('director-name') }}"
                required placeholder="Enter Your Name"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 mb-4">
            @error('director-name')
                <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
            @enderror

            <label for="title" class="block font-semibold mb-2">Title <span class="text-red-600">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                placeholder="Enter Title"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 mb-4">
            @error('title')
                <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
            @enderror

            <label for="date" class="block font-semibold mb-2">Date <span class="text-red-600">*</span></label>
            <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 mb-6">
            @error('date')
                <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
            @enderror

            <div class="flex justify-between">
                <button type="button"
                    class="submit-btn bg-orange-400 hover:bg-orange-500 px-4 py-1 rounded-md text-white font-semibold flex items-center justify-center gap-2"
                    onclick="window.location.href='{{ route('membership.form') }}'">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </button>
                <button type="submit"
                    class="submit-btn bg-green-600 hover:bg-green-700 px-4 py-2 rounded-md text-white font-semibold flex items-center justify-center gap-2">
                    Submit
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>

    <script>
        function togglePhoneInput(channel) {
            var group = document.getElementById('phone-group-' + channel);
            var input = document.getElementById('phone-' + channel);
            var checkbox = document.getElementById('comm-' + channel);
            if (checkbox.checked) {
                group.style.display = 'block';
                input.required = true;
            } else {
                group.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        }
    </script>

</body>

</html>
