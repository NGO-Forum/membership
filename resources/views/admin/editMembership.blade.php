@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-8">
            <h1 class="text-3xl font-bold mb-6 text-green-700">Edit Membership</h1>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.update', $membership->id) }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')

                <!-- NGO Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">NGO Name <span class="text-red-500">*</span></label>
                    <input type="text" name="ngo_name" value="{{ old('ngo_name', $membership->ngo_name) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <!-- Director Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Director Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="director_name"
                        value="{{ old('director_name', $membership->director_name) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <!-- Director Phone -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Director Phone <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="director_phone"
                        value="{{ old('director_phone', $membership->director_phone) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <!-- Director Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Director Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="director_email"
                        value="{{ old('director_email', $membership->director_email) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <!-- Alternate Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Alternate Name</label>
                    <input type="text" name="alt_name" value="{{ old('alt_name', $membership->alt_name) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <!-- Alternate Phone -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Alternate Phone</label>
                    <input type="text" name="alt_phone" value="{{ old('alt_phone', $membership->alt_phone) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <!-- Alternate Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Alternate Email</label>
                    <input type="email" name="alt_email" value="{{ old('alt_email', $membership->alt_email) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <!-- Submit Button (full width on mobile, align right on md+) -->
                <div class="md:col-span-2 flex justify-end space-x-4">
                    <!-- Back Button -->
                    <a href="{{ route('admin.membership') }}"
                        class="px-4 py-3 bg-red-400 text-white font-semibold rounded-lg shadow hover:bg-red-500 transition flex items-center justify-center">
                        <!-- Optional: Back Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Back</span>
                    </a>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition flex items-center space-x-2">
                        <span>Update</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
