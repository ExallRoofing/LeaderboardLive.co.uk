<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <h2 class="text-xl font-semibold leading-tight text-brandGreen-dark">
                {{ $competition->competition_name }}
            </h2>
            <span class="inline-block px-3 py-1 text-sm font-medium rounded bg-brandGrey-light text-brandGreen-dark">
                {{ \Carbon\Carbon::parse($competition->competition_date)->format('l, F j, Y') }}
            </span>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-6">
            <!-- 2-Column Grid for Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Competition Details Card -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Competition Details</h3>
                    <p><strong>Date:</strong> {{ $competition->competition_date->toFormattedDateString() }}</p>
                    <p><strong>Time:</strong> {{ $competition->competition_time }}</p>
                    <p><strong>Format:</strong> {{ $competition->format }}</p>
                </div>

                <!-- Entries Card -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Entries</h3>
                    <ul class="space-y-2">
                        @foreach($entries as $entry)
                            <li class="text-gray-700">{{ $entry->user->name }} - Handicap: {{ $entry->playing_handicap }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Payment Info Card -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Payment</h3>
                    <p><strong>Entry Fee:</strong> {{ $competition->entry_fee }} credits</p>
                    <p class="mt-2 text-gray-600">You have {{ auth()->user()->credit_balance }} credits remaining.</p>
                </div>

                <!-- Gallery / Media Card -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Media Gallery</h3>
                    @if($competition->media->isNotEmpty())
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($competition->media as $media)
                                <img src="{{ Storage::url($media->file_path) }}" class="rounded-lg">
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No media uploaded yet.</p>
                    @endif
                </div>

                <!-- Noticeboard Card -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Noticeboard</h3>
                    @if($competition->notices->isNotEmpty())
                        <ul class="list-disc ml-5 space-y-2">
                            @foreach($competition->notices as $notice)
                                <li>{{ $notice->content }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No notices yet.</p>
                    @endif
                </div>

                <!-- Add to Calendar Card -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Add to Calendar</h3>
                    <a href="{{ route('competitions.calendar', $competition->id) }}" class="text-blue-600 hover:underline">Download iCal</a>
                </div>

            </div>

            <!-- Full-width Course Overview Card -->
            <div class="mt-6 bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Course Overview</h3>
                <table class="w-full text-sm text-center">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2">Hole</th>
                        @foreach($competition->course->hole_data as $i => $hole)
                            <th>{{ $i + 1 }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="py-2 font-semibold">Par</td>
                        @foreach($competition->course->hole_data as $hole)
                            <td>{{ $hole['par'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold">Yardage</td>
                        @foreach($competition->course->hole_data as $hole)
                            <td>{{ $hole['yardage'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold">SI</td>
                        @foreach($competition->course->hole_data as $hole)
                            <td>{{ $hole['si'] }}</td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
</x-app-layout>
