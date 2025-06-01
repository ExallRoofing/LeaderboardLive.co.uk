<x-club-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Competition') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto">
        <x-error-notification />
        <form action="{{ route('club.competitions.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
            @csrf

            <div>
                <label for="competition_name" class="block text-sm font-medium text-gray-700">Competition Name</label>
                <input type="text" id="competition_name" name="competition_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('competition_name') }}" required>
            </div>
            <div>
                <label for="course_id" class="block text-sm font-medium text-gray-700">Select Course</label>
                <select name="course_id" id="course_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="competition_date" class="block text-sm font-medium text-gray-700">Competition Date</label>
                <input type="date" id="competition_date" name="competition_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('competition_date') }}" required>
            </div>
            <div>
                <label for="registration_deadline" class="block text-sm font-medium text-gray-700">Registration Deadline</label>
                <input type="date" id="registration_deadline" name="registration_deadline" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('registration_deadline') }}" required>
            </div>
            <div class="text-right">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-brandGreen-dark text-white text-sm font-semibold rounded-md shadow hover:bg-brandGreen-light transition">
                    Create Competition
                </button>
            </div>
        </form>
    </div>
</x-club-admin-app-layout>
