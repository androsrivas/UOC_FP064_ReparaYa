<x-layouts.base :title="$title ?? 'ReparaYa'">
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-blue-600">🔧 ReparaYa</h1>
                <p class="text-gray-500 text-sm mt-1">Gestión professional de reparaciones</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-8">
                {{ $slot }}
            </div>

            <x-navigation.footer />
        </div>
    </div>
</x-layouts.base>