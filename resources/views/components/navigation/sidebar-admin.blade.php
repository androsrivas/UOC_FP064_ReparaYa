<aside class="w-64 bg-gray-900 text-white flex flex-col shrink-0">

    <div class="h-16 flex items-center justify-center border-b border-gray-700">
        <span class="text-xl font-bold text-blue-400">🔧 ReparaYa</span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

        @auth
            @if(auth()->user()->esAdmin())
                <x-navigation.sidebar-link route="dashboard"         icon="🏠" label="Panel" />
                <x-navigation.sidebar-link route="incidencias.index" icon="📋" label="Incidencias" />
                <x-navigation.sidebar-link route="tecnicos.index"    icon="👷" label="Técnicos" />
                <x-navigation.sidebar-link route="especialidades.index" icon="🔧" label="Especialidades" />
                <x-navigation.sidebar-link route="gestoras.index"    icon="🏢" label="Gestoras" />
                <x-navigation.sidebar-link route="comisiones.index"  icon="💰" label="Liquidaciones" />
                <x-navigation.sidebar-link route="calendario"        icon="📅" label="Calendario" />
            @endif

            @if(auth()->user()->esTecnico())
                <x-navigation.sidebar-link route="tecnico.agenda"    icon="📅" label="Mi agenda" />
            @endif

            @if(auth()->user()->esParticular())
                <x-navigation.sidebar-link route="client.incidencias"   icon="📋" label="Mis avisos" />
                <x-navigation.sidebar-link route="client.nova"          icon="➕" label="Nueva solicitud" />
                <x-navigation.sidebar-link route="client.perfil"        icon="👤" label="Mi perfil" />
            @endif

            @if(auth()->user()->esGestora())
                <x-navigation.sidebar-link route="gestora.incidencias"  icon="📋" label="Mis serveis" />
                <x-navigation.sidebar-link route="gestora.nova"         icon="➕" label="Nueva incidencia" />
                <x-navigation.sidebar-link route="gestora.comisiones"   icon="💰" label="Mis comisiones" />
            @endif
        @endauth

    </nav>

    <div class="p-4 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full text-left text-sm text-gray-400 hover:text-white transition flex items-center gap-2">
                🚪 Cerrar sesión
            </button>
        </form>
    </div>
</aside>