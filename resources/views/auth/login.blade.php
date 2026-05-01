<x-layouts.auth title="Iniciar Sessió">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-display text-text font-bold">Benvingut de nou</h2>
        <p class="text-muted text-sm mt-1">Introdueix les teves credencials per accedir</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <x-ui.form
            label="Correu electrònic" 
            name="email" 
            type="email" 
            placeholder="correu@exemple.com" 
            required 
            autofocus 
        />

        <div>
            <div class="flex justify-between mb-1">
                <label for="password" class="text-sm font-medium text-text">Contrasenya</label>
                {{-- <a href="{{ route('password.request') }}" class="text-xs text-accent hover:underline font-medium">L'has oblidat?</a> --}}
            </div>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required
                class="w-full px-4 py-2 border border-border rounded-custom bg-surface text-text focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-custom"
            >
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-accent border-border rounded focus:ring-accent">
            <label for="remember_me" class="ml-2 text-sm text-muted">Recorda'm en aquest dispositiu</label>
        </div>

        <x-ui.button type="submit" class="w-full py-3 shadow-sm">
            Entrar al sistema
        </x-ui.button>
    </form>

    <div class="mt-8 pt-6 border-t border-border text-center">
        <p class="text-sm text-muted">
            Encara no tens compte? 
            <a href="{{ route('register') }}" class="text-accent font-bold hover:underline">Registra't aquí</a>
        </p>
    </div>
</x-layouts.auth>