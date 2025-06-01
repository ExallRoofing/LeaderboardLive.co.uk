<x-club-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}
        </h2>
    </x-slot>

    <div class="py-6 space-y-8">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <div class="text-sm text-gray-500">Total Competitions</div>
                <div class="text-3xl font-bold text-brandGreen-dark mt-2">{{ $competitionCount }}</div>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <div class="text-sm text-gray-500">Total Entries</div>
                <div class="text-3xl font-bold text-brandGreen-dark mt-2">{{ $entryCount }}</div>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <div class="text-sm text-gray-500">Total Players</div>
                <div class="text-3xl font-bold text-brandGreen-dark mt-2">{{ $playerCount }}</div>
            </div>
        </div>

        <!-- Recent Entries -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Entries</h3>

            <table class="min-w-full table-auto">
                <thead>
                <tr class="text-left text-sm text-gray-600 border-b">
                    <th class="py-2">Player</th>
                    <th class="py-2">Competition</th>
                    <th class="py-2">Date</th>
                </tr>
                </thead>
                <tbody>
                @forelse($recentEntries as $entry)
                    <tr class="text-sm text-gray-700 border-b">
                        <td class="py-2">{{ $entry->user->name }}</td>
                        <td class="py-2">{{ $entry->clubCompetition->competition_name }}</td>
                        <td class="py-2">{{ $entry->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-400">No recent entries</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-club-admin-app-layout>
