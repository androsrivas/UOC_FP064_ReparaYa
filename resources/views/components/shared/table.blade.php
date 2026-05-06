<div {{ $attributes->merge(['class' => 'w-full overflow-x-auto border border-slate-200 rounded-2xl shadow-sm']) }}>
    <table class="w-full text-left border-collapse bg-white">
        <thead class="bg-slate-50 text-slate-500 font-sans uppercase text-xs tracking-wider">
            <tr>
                {{ $thead }}
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
            {{ $slot }}
        </tbody>
    </table>
</div>