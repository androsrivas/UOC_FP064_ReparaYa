@props(['active' => 'dashboard'])

<aside class="fixed left-0 top-0 z-40 w-64 h-screen pt-20 transition-transform bg-surface border-r border-border">
    <div class="h-full px-3 py-4 overflow-y-auto flex flex-col justify-between">
        <ul class="space-y-2 font-medium">
            <li>
                <x-sidebar-link icon="grid" label="Tauler Principal" :active="$active === 'dashboard'" />
            </li>
            <li>
                <x-sidebar-link icon="tool" label="Avaries Actives" :active="$active === 'avaries'" />
            </li>
            <li>
                <x-sidebar-link icon="users" label="Tècnics" :active="$active === 'tecnics'" />
            </li>
            <li>
                <x-sidebar-link icon="chart" label="Estadístiques" :active="$active === 'stats'" />
            </li>
        </ul>

        <div class="pt-4 border-t border-border">
            <a href="#" class="flex items-center p-2 text-muted hover:text-error hover:bg-error-bg rounded-custom transition-all group">
                <svg class="w-5 h-5 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="ml-3">Tancar sessió</span>
            </a>
        </div>
    </div>
</aside>