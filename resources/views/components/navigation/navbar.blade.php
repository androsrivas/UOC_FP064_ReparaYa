@props(['breadcrumbItems' => []])

<nav class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-40">
    <div class="flex items-center gap-4">
        <div class="lg:hidden font-serif font-bold text-blue-950 mr-4">
            ReparaYa
        </div>
        
        <x-navigation.breadcrumb :items="$breadcrumbItems" />
    </div>

    <div class="flex items-center gap-4">
        <span class="text-sm text-slate-500 mr-2">{{ auth()->user()->name }} ({{ auth()->user()->rol }})</span>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium transition-colors 
                {{ auth()->user()->isAdmin() ? 'text-red-600 hover:bg-red-50' : 'text-slate-600 hover:bg-slate-100' }}">
                <span>Cerrar Sesión</span>
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
</nav>