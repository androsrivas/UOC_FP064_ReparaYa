<div class="flex justify-around w-full items-center">
    
    <x-navigation.navbar-link route="cliente.incidencias" :active="request()->routeIs('cliente.incidencias*')">
        <div class="flex flex-col items-center gap-1">
            <i class="fa-solid fa-clipboard-list text-xl"></i>
            <span class="text-[10px] uppercase font-black tracking-tighter">Mis Avisos</span>
        </div>
    </x-navigation.navbar-link>

    <a href="{{ route('cliente.incidencias.nueva-incidencia') }}" 
       class="flex flex-col items-center justify-center -mt-10 w-16 h-16 bg-sky-600 rounded-full shadow-xl text-white border-4 border-white transition-all hover:bg-sky-500 active:scale-90 z-10">
        <i class="fa-solid fa-plus text-2xl"></i>
    </a>

    <x-navigation.navbar-link route="dashboard" :active="request()->routeIs('dashboard')">
        <div class="flex flex-col items-center gap-1">
            <i class="fa-solid fa-user-gear text-xl"></i>
            <span class="text-[10px] uppercase font-black tracking-tighter">Mi Cuenta</span>
        </div>
    </x-navigation.navbar-link>
</div>