<x-layouts.admin title="Tauler de Control" active="dashboard">
    
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-display text-accent font-bold">Bon dia, {{ auth()->user()->name ?? 'Administrador' }}</h1>
            <p class="text-muted mt-1">Això és el que està passant avui a ReparaYa.</p>
        </div>
        <x-ui.button variant="primary" class="flex gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Registrar Nova Avaria
        </x-ui.button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <x-ui.card class="border-l-4 border-l-accent">
            <p class="text-xs font-bold text-muted uppercase tracking-wider">Avaries Obertes</p>
            <p class="text-3xl font-display text-text mt-2">24</p>
            <p class="text-xs text-success mt-2 font-medium">↑ 12% respecte ahir</p>
        </x-ui.card>

        <x-ui.card class="border-l-4 border-l-warning">
            <p class="text-xs font-bold text-muted uppercase tracking-wider">Pendents d'Assignar</p>
            <p class="text-3xl font-display text-text mt-2">7</p>
            <p class="text-xs text-error mt-2 font-medium">Requereix atenció</p>
        </x-ui.card>

        <x-ui.card class="border-l-4 border-l-success">
            <p class="text-xs font-bold text-muted uppercase tracking-wider">Tècnics Actius</p>
            <p class="text-3xl font-display text-text mt-2">12</p>
            <p class="text-xs text-muted mt-2 font-medium">De 15 en plantilla</p>
        </x-ui.card>

        <x-ui.card class="border-l-4 border-l-text">
            <p class="text-xs font-bold text-muted uppercase tracking-wider">Facturació Mes</p>
            <p class="text-3xl font-display text-text mt-2">14.250€</p>
            <p class="text-xs text-success mt-2 font-medium">Objectiu: 85% assolit</p>
        </x-ui.card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-display text-text font-bold">Últimes Avaries Rebrudes</h2>
                <a href="#" class="text-sm text-accent hover:underline">Veure-les totes</a>
            </div>
            <x-shared.table>
                <x-slot name="thead">
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Client / Servei</th>
                    <th class="px-6 py-3">Estat</th>
                    <th class="px-6 py-3 text-right">Accions</th>
                </x-slot>
                
                <tr>
                    <td class="px-6 py-4 font-mono text-xs text-muted">#AV-8821</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-text">Marta Sánchez</p>
                        <p class="text-xs text-muted italic">Lampisteria (Fuita cuina)</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-error-bg text-error text-[10px] font-bold rounded uppercase">Urgent</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <x-ui.button variant="secondary" class="py-1 px-3 text-xs">Assignar</x-ui.button>
                    </td>
                </tr>
                </x-shared.table>
        </div>

        <div class="space-y-6">
            <h2 class="text-xl font-display text-text font-bold mb-4">Activitat en temps real</h2>
            <x-ui.card title="Alertes del sistema">
                <ul class="space-y-4">
                    <li class="flex gap-3">
                        <div class="w-2 h-2 mt-1.5 rounded-full bg-success"></div>
                        <div>
                            <p class="text-sm text-text font-medium">Marc (Electricista) ha tancat #AV-8810</p>
                            <p class="text-xs text-muted">Fa 5 minuts</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <div class="w-2 h-2 mt-1.5 rounded-full bg-warning"></div>
                        <div>
                            <p class="text-sm text-text font-medium">Nova sol·licitud de servei a Arenys</p>
                            <p class="text-xs text-muted">Fa 12 minuts</p>
                        </div>
                    </li>
                </ul>
            </x-ui.card>
        </div>
    </div>

</x-layouts.admin>