<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Competitions') }}
        </h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-16">

        <!-- OPEN COMPETITIONS -->
        <section>
            <h3 class="text-xl font-bold text-brandGreen-dark mb-6 flex items-center gap-2">
                <img src="{{ asset('images/icons/competition.svg') }}" alt="Competitions" class="size-6 shrink-0">
                Open Competitions
            </h3>

            <div class="grid md:grid-cols-2 gap-6">
                @forelse($openCompetitions as $competition)
                    <div class="bg-brandGreen-lightest shadow-xl hover:shadow-2xl rounded-xl p-6 transition-all flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-xl font-bold text-brandGreen-dark">{{ $competition->competition_name }}</h4>
                                <p class="text-sm text-brandGreen-dark">Hosted by your club</p>
                            </div>
                        </div>

                        <div class="mt-4 text-sm text-gray-600 space-y-1">
                            <div class="flex items-center gap-2">
                                <x-zondicon-calendar class="w-4 h-4 text-gray-400" />
                                {{ $competition->competition_date->toFormattedDateString() }}
                            </div>
                            <div class="flex items-center gap-2">
                                <x-zondicon-time class="w-4 h-4 text-gray-400" />
                                Reg. closes: {{ $competition->registration_deadline->format('D, d F H:i') }}
                            </div>
                        </div>

                        <div class="mt-6">
                            <form method="POST" action="{{ route('competitions.enter', $competition->id) }}">
                                @csrf
                                <x-primary-button class="w-full justify-center">Enter This Competition</x-primary-button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No competitions available to enter right now.</p>
                @endforelse
            </div>
        </section>

        <!-- MY ENTRIES -->
        <section>
            <h3 class="text-xl font-bold text-brandGreen-dark mb-6 flex items-center gap-2">
                <img src="{{ asset('images/icons/my-entries.svg') }}" alt="Entries" class="size-6 shrink-0">
                My Entries
            </h3>

            <div class="grid md:grid-cols-2 gap-6">
                @forelse($userCompetitions as $entry)
                    @php
                        $comp = $entry->clubCompetition;
                        $hasSubmitted = !is_null($entry->played_at);
                        $verified = $entry->verified;
                        $isPastDeadline = $comp->registration_deadline->isPast();
                    @endphp

                    <div class="relative bg-white rounded-xl shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden flex flex-col justify-between">

                        <!-- Status Ribbon -->
                        @if($hasSubmitted && $verified)
                            <div class="absolute top-0 right-0 bg-brandYellow-light text-brandGreen-dark text-xs font-bold px-3 py-1 shadow z-10 rounded-bl-md">
                                <x-zondicon-checkmark class="w-4 h-4 mr-1 inline" /> Verified
                            </div>
                        @elseif($hasSubmitted && !$verified)
                            <div class="absolute top-0 right-0 bg-brandYellow-light text-brandGreen-dark text-xs font-bold px-3 py-1 shadow z-10 rounded-bl-md">
                                <x-zondicon-time class="w-4 h-4 mr-1 inline" /> Score Submitted
                            </div>
                        @else
                            <div class="absolute top-0 right-0 bg-brandYellow-light text-brandGreen-dark text-xs font-bold px-3 py-1 shadow z-10 rounded-bl-md">
                                <x-zondicon-exclamation-outline class="w-4 h-4 mr-1 inline" /> Awaiting Score
                            </div>
                        @endif

                        <!-- Card Content -->
                        <div class="p-6">
                            <h4 class="text-xl font-bold text-brandGreen-dark">{{ $comp->competition_name }}</h4>
                            <p class="text-sm text-brandGreen-light mb-4">Entered competition</p>

                            <div class="text-sm text-brandGreen-light space-y-1">
                                <div class="flex items-center gap-2">
                                    <x-zondicon-calendar class="w-4 h-4 text-brandGreen-light" />
                                    {{ $comp->competition_date->toFormattedDateString() }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-zondicon-time class="w-4 h-4 text-brandGreen-light" />
                                    Reg. closes: {{ $comp->registration_deadline->format('D H:i') }}
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-2">
                                @if(!$hasSubmitted && !$isPastDeadline)
                                    <form method="POST" action="{{ route('competitions.unregister', $comp->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full justify-center border border-brandGreen-light text-brandGreen-dark bg-brandGreen-light hover:bg-brandGreen-dark hover:text-white focus:outline-none focus:ring-2 focus:ring-brandGreen-light rounded-md px-4 py-2 text-sm font-semibold tracking-wide transition duration-200 appearance-none">
                                            UNREGISTER
                                        </button>
                                    </form>
                                @endif

                                @if(!$hasSubmitted)
                                    <a href="{{ route('scores.submit', $entry->id) }}">
                                        <button type="button"
                                                class="w-full justify-center bg-brandYellow-dark text-brandGreen-dark hover:bg-brandYellow-light hover:text-brandGreen-dark focus:outline-none focus:ring-2 focus:ring-brandYellow-light rounded-md px-4 py-2 text-sm font-semibold tracking-wide transition-colors duration-200 appearance-none">
                                            SUBMIT SCORE
                                        </button>
                                    </a>
                                @elseif($hasSubmitted)
                                    <a href="{{ route('scores.view', $entry->id) }}">
                                        <button type="button"
                                                class="w-full justify-center bg-brandGreen-light text-white focus:outline-none focus:ring-2 focus:ring-brandGreen-light rounded-md px-4 py-2 text-sm font-semibold tracking-wide transition-colors duration-200 appearance-none">
                                            VIEW SUBMITTED SCORE
                                        </button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">You haven’t entered any competitions yet.</p>
                @endforelse
            </div>
        </section>

    </div>
</x-app-layout>
