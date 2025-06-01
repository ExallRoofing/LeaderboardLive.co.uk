<div x-data="{ open: false }" class="lg:hidden">
    <button @click="open = true" class="p-4 text-gray-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <div x-show="open" class="fixed inset-0 z-50 bg-black bg-opacity-50" @click="open = false"></div>

    <aside x-show="open" class="fixed z-50 inset-y-0 left-0 w-64 bg-white shadow-xl p-6 overflow-y-auto" @click.away="open = false" x-transition>
        <div class="mb-6">
            <x-application-logo class="h-30 w-auto mx-auto" />
        </div>
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-brandGreen-dark' : 'hover:bg-gray-50 hover:text-brandGreen-dark text-gray-700' }}">
                Dashboard
            </a>
            <a href="{{ route('competitions.index') }}" class="block px-4 py-2 rounded {{ request()->routeIs('competitions.*') ? 'bg-gray-100 text-brandGreen-dark' : 'hover:bg-gray-50 hover:text-brandGreen-dark text-gray-700' }}">
                Competitions
            </a>
            <a href="{{ route('credit.index') }}" class="block px-4 py-2 rounded {{ request()->routeIs('credit.index') ? 'bg-gray-100 text-brandGreen-dark' : 'hover:bg-gray-50 hover:text-brandGreen-dark text-gray-700' }}">
                Credit History
            </a>
        </nav>
    </aside>
</div>

@include('layouts.sidebar-static')
