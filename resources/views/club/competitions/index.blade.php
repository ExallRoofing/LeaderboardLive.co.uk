<x-club-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Competitions') }}
            </h2>

            <a href="{{ route('club.competitions.create') }}" class="inline-flex items-center px-3 py-1.5 bg-brandGreen-dark text-white text-sm font-semibold rounded-md shadow hover:bg-brandGreen-light transition duration-150">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Competition
            </a>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <x-success-notification />
        <x-error-notification />
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase">
                <tr>
                    <th class="px-6 py-3">Competition Name</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Registration Deadline</th>
                    <th class="px-6 py-3">Entries</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($competitions as $competition)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $competition->competition_name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $competition->competition_date->format('M j, Y') }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $competition->registration_deadline->format('M j, Y') }}</td>
                        <td class="px-6 py-4 text-center">{{ $competition->entries_count }}</td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('club.competitions.toggle', $competition->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="relative inline-flex h-5 w-14 items-center rounded-full border border-transparent transition-colors duration-200 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:ring-offset-1
                {{ $competition->is_open ? 'bg-brandGreen-mid' : 'bg-brandGrey-light' }}"
                                        role="switch" aria-checked="{{ $competition->is_open ? 'true' : 'false' }}">

            <span class="absolute left-1 text-[10px] font-semibold text-white leading-none">
                {{ $competition->is_open ? 'Open' : '' }}
            </span>
                                    <span class="absolute right-1 text-[10px] font-semibold text-white leading-none">
                {{ !$competition->is_open ? 'Closed' : '' }}
            </span>

                                    <span aria-hidden="true"
                                          class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition duration-200 ease-in-out
                    {{ $competition->is_open ? 'translate-x-9' : 'translate-x-0' }}">
            </span>
                                </button>
                            </form>
                        </td>

                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('club.competitions.edit', $competition->id) }}" class="text-indigo-600 hover:underline">Edit</a>

                            @if($competition->entries_count === 0)
                                <form method="POST" action="{{ route('club.competitions.destroy', $competition->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this competition?')" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            @else
                                <span class="text-gray-400 cursor-not-allowed">Delete</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No competitions found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-club-admin-app-layout>
