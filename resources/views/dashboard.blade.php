<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome back, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Recent Scores Card -->
        <div class="bg-white border-l-4 border-brandGreen-dark rounded-lg shadow p-6 hover:shadow-lg transition">
            <h3 class="text-lg font-semibold text-brandGreen-dark mb-4">Recent Scores</h3>
            @forelse ($recentEntries as $entry)
                <div class="flex justify-between text-sm text-gray-700 mb-2">
                    <span>{{ $entry->clubCompetition->competition_name ?? 'Unknown' }}</span>
                    <span class="font-semibold text-brandGreen-dark">{{ $entry->net_score }}</span>
                </div>
            @empty
                <p class="text-gray-500">No scores submitted yet.</p>
            @endforelse
        </div>

        <!-- Top Players Card -->
        <div class="bg-white border-l-4 border-brandYellow-dark rounded-lg shadow p-6 hover:shadow-lg transition">
            <h3 class="text-lg font-semibold text-brandYellow-dark mb-4">Weekly Leaderboard</h3>
            @forelse ($topPlayers as $entry)
                <div class="flex justify-between text-sm text-gray-700 mb-2">
                    <span>{{ $entry->user->name }}</span>
                    <span class="font-semibold text-brandYellow-dark">{{ $entry->net_score }}</span>
                </div>
            @empty
                <p class="text-gray-500">No leaderboard entries yet.</p>
            @endforelse
        </div>

        <!-- Upcoming Competitions Card -->
        <div class="bg-white border-l-4 border-brandGreen-light rounded-lg shadow p-6 hover:shadow-lg transition">
            <h3 class="text-lg font-semibold text-brandGreen-light mb-4">Upcoming Competitions</h3>
            @forelse ($upcomingCompetitions as $competition)
                <div class="mb-2">
                    <div class="text-sm font-semibold text-gray-800">
                        <a href="{{ route('competitions.show', $competition->id) }}" class="text-brandGreen-dark hover:underline">
                            {{ $competition->competition_name }}
                        </a>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($competition->competition_date)->format('M j, Y') }}
                    </div>
                </div>
            @empty
                <p class="text-gray-500">None scheduled yet.</p>
            @endforelse
        </div>
    </div>

</x-app-layout>
