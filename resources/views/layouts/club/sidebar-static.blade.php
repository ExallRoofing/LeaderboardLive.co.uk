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
                            <a href="{{ route('club.dashboard') }}" class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('club.dashboard') ? 'bg-gray-50 text-brandGreen-dark' : 'text-gray-700 hover:bg-gray-50 hover:text-brandGreen-dark' }}">
                                <img src="{{ asset('images/icons/dashboard.svg') }}" alt="Dashboard" class="size-6 shrink-0">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('club.competitions') }}" class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('club.competitions') ? 'bg-gray-50 text-brandGreen-dark' : 'text-gray-700 hover:bg-gray-50 hover:text-brandGreen-dark' }}">
                                <img src="{{ asset('images/icons/competition.svg') }}" alt="Competition" class="size-6 shrink-0">
                                Competitions
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('club.results') }}" class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('club.results') ? 'bg-gray-50 text-brandGreen-dark' : 'text-gray-700 hover:bg-gray-50 hover:text-brandGreen-dark' }}">
                                <img src="{{ asset('images/icons/results.svg') }}" alt="Results" class="size-6 shrink-0">
                                Results
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- Profile section -->
        <div class="mt-auto border-t border-gray-200 pt-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('club.profile.edit') }}" class="flex items-center gap-3">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar_url }}" alt="Profile" class="h-9 w-9 rounded-full object-cover bg-gray-100">
                    @else
                        <div class="h-9 w-9 rounded-full bg-gray-300 flex items-center justify-center text-white text-sm font-medium">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
