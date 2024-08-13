<div>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Initiate Clearance</h3>
        
        @if (session()->has('message'))
            <div class="mb-4 text-green-600">
                {{ session('message') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="mb-4 text-red-600">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="initiateClearance" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="documents">
                    Upload Documents for Clearance
                </label>
                <input type="file" wire:model="documents" multiple class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm">
                @error('documents.*') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- List of Selected Files -->
            @if ($documents)
                <div class="mb-4">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Selected Documents:</h4>
                    <ul class="list-disc list-inside text-gray-600">
                        @foreach ($documents as $document)
                            <li>{{ $document->getClientOriginalName() }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
             @if (!$initiatedPrevious)
                 @if (!$noStaff)
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600">
                        Initiate Clearance
                    </button>
                @endif
             @endif
           
        </form>

        <div wire:loading wire:target="documents" class="text-blue-500 mt-2">
            Uploading...
        </div>
    </div>
</div>
