<nav class="fixed top-0 z-50 w-full bg-surface border-b border-border shadow-sm">
    <div class="px-6 py-3 flex items-center justify-between">
        
        <div class="flex items-center gap-8">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <span class="text-2xl font-display font-bold text-accent tracking-tight">
                    Repara<span class="text-text">Ya</span>
                </span>
                <span class="hidden sm:block px-2 py-0.5 text-[10px] font-bold bg-accent/10 text-accent rounded uppercase tracking-widest border border-accent/20">
                    Admin
                </span>
            </a>
            
            <div class="hidden lg:block">
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-muted group-focus-within:text-accent transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input 
                        type="text" 
                        placeholder="Buscar ID d'avaria, client o tècnic..." 
                        class="w-80 pl-10 pr-4 py-1.5 bg-bg border border-border rounded-custom text-sm focus:ring-1 focus:ring-accent focus:border-accent outline-none transition-all placeholder:text-muted/50"
                    >
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            
            <button class="relative p-2 text-muted hover:text-accent hover:bg-bg rounded-full transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-2 right-2.5 w-2.5 h-2.5 bg-error border-2 border-surface rounded-full"></span>
            </button>

            <div class="h-8 w-px bg-border mx-2"></div>

            <div class="flex items-center gap-3 pl-2 group cursor-pointer">
                <div class="flex flex-col items-end sm:flex">
                    <span class="text-sm font-bold text-text leading-none">{{ auth()->user()->name ?? 'Administrador' }}</span>
                    <span class="text-[10px] text-muted font-medium uppercase mt-1 tracking-tighter">Super Administrador</span>
                </div>
                
                <div class="relative">
                    <div class="w-9 h-9 rounded-custom bg-accent text-white flex items-center justify-