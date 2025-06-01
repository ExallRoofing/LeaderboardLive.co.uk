<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Entries') }}
        </h2>
    </x-slot>
    <div class="py-10 px-4 max-w-7xl mx-auto">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-sm text-gray-700 text-left">
                <tr>
                    <th class="px-4 py-3">Player</th>
                    <th class="px-4 py-3">Competition</th>
                    <th class="px-4 py-3">Submitted?</th>
                    <th class="px-4 py-3">Verified?</th>
                    <th class="px-4 py-3">Gross</th>
                    <th class="px-4 py-3">Net</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 text-sm">
                @forelse($entries as $entry)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $entry->user->name }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div>
                                <div class="font-medium text-gray-800">
                                    {{ $entry->clubCompetition->competition_name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $entry->clubCompetition->competition_date->toFormattedDateString() }}
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if($entry->played_at)
                                <span class="text-brandGreen-mid font-semibold">Yes</span>
                            @else
                                <span class="text-brandYellow-dark">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($entry->verified)
                                <span class="text-brandGreen-mid font-semibold">Yes</span>
                            @else
                                <span class="text-brandYellow-dark font-semibold">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            {{ $entry->gross_score ?? '—' }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $entry->net_score ?? '—' }}
                        </td>
                        <td class="px-4 py-3 flex items-center gap-2">
                            @if($entry->played_at)
                                <a href="{{ route('scores.view', $entry->id) }}"
                                   class="text-indigo-600 hover:underline">View</a>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            No entries found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
