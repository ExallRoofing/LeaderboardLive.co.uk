<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Competitions') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 max-w-7xl mx-auto">
        <div class="space-y-8">
            @forelse ($competitions as $competition)
                <div class="bg-white shadow rounded-xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-brandGreen-dark">{{ $competition->competition_name }}</h3>
                            <p class="text-sm text-gray-500">{{ $competition->competition_date->toFormattedDateString() }}</p>
                        </div>
                        <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full">Results Published</span>
                    </div>

                    <table class="w-full text-sm text-left text-gray-700">
                        <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <th class="px-4 py-2">Position</th>
                            <th class="px-4 py-2">Player</th>
                            <th class="px-4 py-2">Gross</th>
                            <th class="px-4 py-2">Net</th>
                            <th class="px-4 py-2">Handicap</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($competition->entries->sortBy('net_score') as $index => $entry)
                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-2 font-bold">#{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $entry->user->name }}</td>
                                <td class="px-4 py-2">{{ $entry->gross_score }}</td>
                                <td class="px-4 py-2">{{ $entry->net_score }}</td>
                                <td class="px-4 py-2">{{ $entry->playing_handicap }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <p class="text-gray-600">No competition results have been published yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
