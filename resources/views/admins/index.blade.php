@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 px-3 py-4 md:px-0 md:py-0">
            <h1 class="text-3xl font-bold text-green-700">Admins</h1>

            <!-- Create Button -->
            <div x-data="{ openCreate: false }">
                <button @click="openCreate = true"
                    class="px-5 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
                    + Create
                </button>

                <!-- Create Modal -->
                <div x-show="openCreate" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="bg-white rounded-lg shadow-xl w-80 md:w-96 p-6" @click.away="openCreate = false">
                        <h2 class="text-xl font-bold mb-4">Create Admin</h2>
                        <form action="{{ route('admins.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-gray-700">Name</label>
                                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                            </div>
                            <div class="mb-3">
                                <label class="block text-gray-700">Email</label>
                                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
                            </div>
                            <div class="mb-3">
                                <label class="block text-gray-700">NGO</label>
                                <input type="text" name="ngo" class="w-full border rounded px-3 py-2" required>
                            </div>
                            <div class="mb-3">
                                <label class="block text-gray-700">Role</label>
                                <select name="role" class="w-full border rounded px-3 py-2" required>
                                    <option value="admin">Admin</option>
                                    <option value="board">Board</option>
                                    <option value="ed">ED</option>
                                    <option value="board">Manager</option>
                                    <option value="operations">Operations</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-gray-700">Password</label>
                                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
                            </div>
                            <div class="mb-3">
                                <label class="block text-gray-700">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="block text-gray-700">Profile Image</label>
                                <input type="file" name="image" accept="image/*"
                                    class="w-full border rounded px-3 py-2">
                            </div>
                            <div class="flex justify-end space-x-2 mt-4">
                                <button type="button" @click="openCreate = false"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
                <thead class="bg-green-600 text-white border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">NGO</th>
                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-gray-800 font-medium">
                                @if ($admin->image)
                                    <img src="{{ asset('storage/' . $admin->image) }}" alt="{{ $admin->name }}"
                                        class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-200">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5.121 17.804A11.955 11.955 0 0112 15c2.486 0 4.779.755 6.879 2.045M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-800 font-medium">{{ $admin->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $admin->email }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $admin->ngo }}</td>
                            <td class="px-6 py-4 text-gray-700 font-semibold capitalize">{{ $admin->role }}</td>
                            <td class="px-2 py-2 text-center text-sm">
                                <div x-data="{ openMenu: false, openDelete: false, openEdit: false }" class="inline-block text-left">

                                    <!-- Kebab Menu -->
                                    <button @click="openMenu = !openMenu"
                                        class="p-2 rounded hover:bg-gray-200 transition focus:outline-none focus:ring focus:ring-blue-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <circle cx="12" cy="5" r="1.5" />
                                            <circle cx="12" cy="12" r="1.5" />
                                            <circle cx="12" cy="19" r="1.5" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown -->
                                    <div x-show="openMenu" @click.away="openMenu = false"
                                        class="absolute right-8 mt-0 w-22 bg-white border rounded shadow-lg z-10 flex flex-col p-1 space-y-1">

                                        <!-- Edit -->
                                        <button @click="openEdit = true; openMenu=false"
                                            class="flex items-center px-2 py-1 text-sm text-green-700 hover:bg-green-100 rounded transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                            Edit</button>

                                        <!-- Delete -->
                                        <button @click="openDelete = true; openMenu=false"
                                            class="flex items-center px-2 py-1 text-sm text-red-600 hover:bg-red-100 rounded transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                            </svg>
                                            Delete</button>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div x-show="openEdit"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                        <div class="bg-white rounded-lg shadow-xl w-80 md:w-96 p-6"
                                            @click.away="openEdit = false">
                                            <h2 class="text-xl font-bold mb-4">Edit Admin</h2>
                                            <form action="{{ route('admins.update', $admin->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="block text-gray-700">Name</label>
                                                    <input type="text" name="name" value="{{ $admin->name }}"
                                                        class="w-full border rounded px-3 py-2" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="block text-gray-700">Email</label>
                                                    <input type="email" name="email" value="{{ $admin->email }}"
                                                        class="w-full border rounded px-3 py-2" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="block text-gray-700">NGO</label>
                                                    <input type="text" name="ngo" value="{{ $admin->ngo }}"
                                                        class="w-full border rounded px-3 py-2" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="block text-gray-700">Role</label>
                                                    <select name="role" class="w-full border rounded px-3 py-2"
                                                        required>
                                                        <option value="admin"
                                                            {{ $admin->role == 'admin' ? 'selected' : '' }}>
                                                            Admin</option>
                                                        <option value="ed"
                                                            {{ $admin->role == 'ed' ? 'selected' : '' }}>ED
                                                        </option>
                                                        <option value="board"
                                                            {{ $admin->role == 'board' ? 'selected' : '' }}>
                                                            Board</option>
                                                        <option value="operations"
                                                            {{ $admin->role == 'operations' ? 'selected' : '' }}>Operations
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="block text-gray-700">Profile Image</label>
                                                    @if ($admin->image)
                                                        <img src="{{ asset('storage/' . $admin->image) }}"
                                                            class="h-16 w-16 object-cover rounded mb-2">
                                                    @endif
                                                    <input type="file" name="image" accept="image/*"
                                                        class="w-full border rounded px-3 py-2">
                                                </div>

                                                <div class="flex justify-end space-x-2 mt-4">
                                                    <button type="button" @click="openEdit = false"
                                                        class="px-4 py-2 bg-orange-300 text-white rounded hover:bg-orange-400">Cancel</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div x-show="openDelete"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                        <div class="bg-white rounded-lg shadow-xl w-80 md:w-96 p-6"
                                            @click.away="openDelete = false">
                                            <div class="flex flex-col items-center mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-16 w-16 text-red-600 mb-2" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01M4.93 19h14.14c1.1 0 1.75-1.18 1.25-2.09l-7.07-12.17a1.5 1.5 0 00-2.56 0L3.68 16.91c-.5.91.14 2.09 1.25 2.09z" />
                                                </svg>
                                                <h2 class="text-xl font-bold text-gray-800">Confirm Deletion</h2>
                                            </div>
                                            <p class="mb-6 text-gray-600 text-center">Are you sure you want to delete this
                                                user?</p>
                                            <div class="flex justify-end space-x-2">
                                                <button @click="openDelete = false"
                                                    class="px-4 py-2 bg-orange-300 text-white rounded hover:bg-orange-400">Cancel</button>
                                                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
