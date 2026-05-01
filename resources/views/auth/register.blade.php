<x-layouts.auth title="Crear compte">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-display text-text font-bold">Uneix-te a ReparaYa</h2>
        <p class="text-muted text-sm mt-1">Crea un compte per gestionar les teves avaries</p>
    </div>

    <x-alert-msg />

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <x-ui.form 
            label="Nom complet" 
            name="nombre" 
            placeholder="Ex: Joan Marc" 
            required 
        />

        <x-ui.form
            label="Correu electrònic" 
            name="email" 
            type="email" 
            placeholder="correu@exemple.com" 
            required 
        />

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="password" class="text-sm font-medium text-text">Contrasenya</label>
                <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-border rounded-custom bg-surface mt-1 outline-none focus:ring-1 focus:ring-accent">
            </div>
            <div>
                <label for="password_confirmation" class="text-sm font-medium text-text">Confirma-la</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-4 py-2 border border-border rounded-custom bg-surface mt-1 outline-none focus:ring-1 focus:ring-accent">
            </div>
        </div>

        <div class="pt-2">
            {{-- <p class="text-[10px] text-muted leading-tight mb-4">
                En registrar-te, acceptes els nostres <a href="#" class="underline">termes de servei</a> i la <a href="#" class="underline">política de privacitat</a>.
            </p> --}}
            <x-ui.button type="submit" class="w-full py-3">
                Crear el meu compte
            </x-ui.button>
        </div>
    </form>

    <div class="mt-8 pt-6 border-t border-border text-center">
        <p class="text-sm text-muted">
            Ja tens un compte? 
            <a href="{{ route('login') }}" class="text-accent font-bold hover:underline">Inicia sessió</a>
        </p>
    </div>
</x-layouts.auth>