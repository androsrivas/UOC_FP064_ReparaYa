@props(['title'])

<x-layouts.base :title="$title">
    <div class="min-h-screen flex flex-col items-center justify-center bg-bg px-4 py-12">
        
        <div class="mb-8 text-center">
            <a href="/" class="inline-block">
                <span class="text-4xl font-display font-bold text-accent tracking-tight">
                    Repara<span class="text-text">Ya</span>
                </span>
            </a>
            <div class="mt-2 flex items-center justify-center gap-2 text-muted">
                <span class="h-px w-8 bg-border"></span>
                <span class="text-xs font-medium uppercase tracking-widest text-muted/70">Gestió d'Avaries</span>
                <span class="h-px w-8 bg-border"></span>
            </div>
        </div>

        <div class="w-full max-w-md bg-surface p-8 rounded-custom shadow-md-custom border border-border relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-accent"></div>
            
            {{ $slot }}
        </div>

        <div class="mt-8 text-center space-y-4">
            <p class="text-xs text-muted/60 font-medium">
                &copy; {{ date('Y') }} ReparaYa S.L. &bull; Sistema de Control Intern
            </p>
            
            <div class="flex items-center justify-center gap-4 text-xs">
                <a href="#" class="text-muted hover:text-accent transition-colors">Privacitat</a>
                <span class="text-border">|</span>
                <a href="#" class="text-muted hover:text-accent transition-colors">Suport Tècnic</a>
            </div>
        </div>
    </div>
</x-layouts.auth.base>