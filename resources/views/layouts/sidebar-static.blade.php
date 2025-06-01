<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
        <div class="flex h-30 shrink-0 items-center">
            <x-application-logo class="h-24 w-auto mx-auto" />
        </div>
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}" class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-gray-50 text-brandGreen-dark' : 'text-gray-700 hover:bg-gray-50 hover:text-brandGreen-dark' }}">
                                <img src="{{ asset('images/icons/dashboard.svg') }}" alt="Dashboard" class="size-6 shrink-0">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('entries.index') }}" class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('entries.index') ? 'bg-gray-50 text-brandGreen-dark' : 'text-gray-700 hover:bg-gray-50 hover:text-brandGreen-dark' }}">
                                <img src="{{ asset('images/icons/my-entries.svg') }}" alt="My Entries" class="size-6 shrink-0">
                                My Entries
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('competitions.index') }}" class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('competitions.*') ? 'bg-gray-50 text-brandGreen-dark' : 'text-gray-700 hover:bg-gray-50 hover:text-brandGreen-dark' }}">
                                <img src="{{ asset('images/icons/competition.svg') }}" alt="Competition" class="size-6 shrink-0">
                                Competitions
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('results.index') }}" class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('results.index') ? 'bg-gray-50 text-brandGreen-dark' : 'text-gray-700 hover:bg-gray-50 hover:text-brandGreen-dark' }}">
                                <img src="{{ asset('images/icons/results.svg') }}" alt="Results" class="size-6 shrink-0">
                                Results
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('leaderboard.index') }}" class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-brandGreen-dark">
                                <img src="{{ asset('images/icons/leaderboard.svg') }}" alt="Leaderboard" class="size-6 shrink-0">
                                National Leaderboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('credit.index') }}" class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('credit.index') ? 'bg-gray-50 text-brandGreen-dark' : 'text-gray-700 hover:bg-gray-50 hover:text-brandGreen-dark' }}">
                                <img src="{{ asset('images/icons/credit.svg') }}" alt="Credit History" class="size-6 shrink-0">
                                Credit History
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- Profile section -->
        <div class="mt-auto border-t border-gray-200 pt-4">
            <div class="flex items-center gap-x-4">
                <a href="{{ route('profile.edit') }}">
                    <img src="{{ asset('images/icons/profile.svg') }}" alt="Profile" class="h-8 w-8 rounded-full bg-gray-100">
                </a>
                <div>
                    <div class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-green-600 font-medium">£{{ number_format(Auth::user()->credit_balance, 2) }} credit</div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-700 hover:text-red-600">Logout</button>
        </form>
    </div>
</div>
