@if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm">
        ❌ {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif