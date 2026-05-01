<nav class="fixed top-0 z-50 w-full bg-surface border-b border-border shadow-sm">
    <div class="px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <span class="text-2xl font-display font-bold text-accent">Repara<span class="text-text">Ya</span></span>
            
            <div class="hidden md:block ml-10">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-muted">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" placeholder="Buscar avaria o tècnic..." class="pl-10 pr-4 py-1.5 bg-bg border border-border rounded-custom text-sm focus:ring-1 focus:ring-accent outline-none w-64 transition-all">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button class="p-2 text-muted hover:text-accent transition-colors relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
            </button>
            <div class="flex items-center gap-2 border-l pl-4 border-border">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-text">Admin ReparaYa</p>
                    <p class="text-[10px] text-muted uppercase">Gestor</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-xs shadow-sm">
                    AD
                </div>
            </div>
        </div>
    </div>
</nav>