@props(['breadcrumbItems' => []])

<nav class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-40">
    <div class="flex items-center gap-6 h-full overflow-hidden">
        <x-breadcrumb :items="$breadcrumbItems" />
        
        <div class="flex items-center h-full">
            {{ $slot }}
        </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-4">
        <x-navbar-link 
            :href="route('perfil')" 
            :active="request()->routeIs('perfil')">
            <div class="flex items-center gap-2">
                <i class="fas fa-user-circle text-lg text-gray-400"></i>
                <span class="hidden sm:inline">Mi Perfil</span>
            </div>
        </x-navbar-link>

        <div class="h-6 w-px bg-gray-200 mx-1"></div>

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 transition px-2 flex items-center gap-2">
                <i class="fas fa-sign-out-alt"></i>
                <span class="hidden sm:inline">Salir</span>
            </button>
        </form>
    </div>
</nav>