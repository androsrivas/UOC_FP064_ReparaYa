<x-layouts.base :title="$title ?? 'Panel de Control'">
    <div class="flex min-h-screen bg-slate-50 font-sans">
        
        <x-navigation.sidebar />

        <div class="ml-64 flex flex-1 flex-col">
            <x-navigation.navbar :breadcrumbItems="$breadcrumbItems ?? []" />

            <main class="p-8 lg:p-10">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layouts.base>