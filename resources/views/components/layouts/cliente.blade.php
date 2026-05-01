<x-layouts.base :title="$title">
    <x-navbar-client />
    <main class="max-w-4xl mx-auto p-4 mt-20">
        {{ $slot }}
    </main>
    <x-footer />
</x-layouts.base>