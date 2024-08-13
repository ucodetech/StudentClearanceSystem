<div>
    <div class="space-y-4">
        @if (count($documents) > 0)
            @foreach ($documents as $document)
                <div class="p-4 bg-white rounded-lg shadow">
                    <a href="{{ asset('storage/uploads/'.$document->file) }}" target="_blank" class="text-blue-500">View Document</a>
                </div>
            
            @endforeach
        @else
        <div class="p-4 bg-white rounded-lg shadow text-center text-2xl">
            <p class="text-red-600">You have not uploaded any document for clearance</p>
        </div>
        @endif
    </div>
</div>
