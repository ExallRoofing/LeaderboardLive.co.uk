<x-club-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Account Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Avatar Upload Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Profile Photo</h3>

                    <div class="flex items-center space-x-4">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar_url }}" class="h-20 w-20 rounded-full" alt="User Avatar">
                        @else
                            <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center text-white">
                                <span class="text-lg">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                        @endif

                        <form action="{{ route('club.profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-2">
                                <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-brandGreen-light file:text-white hover:file:bg-brandGreen-dark"/>

                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-brandGreen-dark text-white text-sm font-semibold rounded-md shadow hover:bg-brandGreen-light transition duration-150">
                                    Update Avatar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update Profile Info -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-club-admin-app-layout>
