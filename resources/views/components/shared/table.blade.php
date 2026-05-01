<div class="w-full overflow-x-auto border border-border rounded-custom shadow-sm-custom">
    <table class="w-full text-left border-collapse bg-surface">
        <thead class="bg-bg text-muted font-body uppercase text-xs tracking-wider">
            <tr>
                {{ $thead }}
            </tr>
        </thead>
        <tbody class="divide-y divide-border text-sm text-text">
            {{ $slot }}
        </tbody>
    </table>
</div>