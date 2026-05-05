<x-layouts.base title="Nova incidència">
    <div class="max-w-3xl">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('incidencias.index') }}"
               class="text-gray-400 hover:text-gray-600 transition">←</a>
            <h1 class="text-2xl font-semibold text-gray-800">Nueva incidencia</h1>
        </div>

        <x-ui.alert-msg />

        <form method="POST" action="{{ route('incidencias.store') }}"
              class="bg-white rounded-xl border border-gray-200 p-6">
            @csrf
            @include('incidencias._form')
            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-100">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    Crear incidencia
                </button>
                <a href="{{ route('incidencias.index') }}"
                   class="px-6 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-layouts.base>