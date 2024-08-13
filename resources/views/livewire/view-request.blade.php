<div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    @if (session()->has('error'))
        <div class="mb-4 text-red-600 text-2xl">
            {{ session('error') }}
        </div>
    @endif
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Request Details</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Student Details -->
        <div>
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Student Information</h4>
            <p><strong>Name:</strong> {{ $requests->student->name }}</p>
            <p><strong>Email:</strong> {{ $requests->student->email }}</p>
            <p><strong>Department:</strong> {{ $requests->student->department }}</p>
            <p><strong>Level:</strong> {{ $requests->student->level }}</p>
        </div>
       
        <!-- Request Details -->
        <div class="flex flex-col space-y-2">
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Request Information</h4>
            <p><strong>Request ID:</strong> {{ $requests->id }}</p>
            <p><strong>Status:</strong> <span class="px-2 py-2 rounded-full bg-yellow-500 text-yellow-200">{{ ucfirst($requests->status) }}</span></p>
            <p><strong>Submitted On:</strong> {{ Carbon\Carbon::parse($requests->created_at)->format('d M Y') }}</p>
        </div>
    </div>
    <!-- Request Documents -->
    <div class="mt-6 mb-5">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">Request Documents</h4>
        @if($requestDocuments->isEmpty())
            <p class="text-gray-600">No documents attached to this request.</p>
        @else
            <div class="flex flex-row space-x-3 items-center justify-center
             text-gray-600 px-4 py-4">
                @foreach($requestDocuments as $document)
                    <li>
                        <a href="{{ asset('storage/uploads/' . $document->file) }}" target="_blank" class="text-blue-500 hover:underline">{{ $document->file }}</a>
                        <embed src="{{ asset('storage/uploads/' . $document->file) }}" width="100%" height="200px" class="mt-2"></embed>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Approve/Reject Buttons -->
    <div class="mt-10 flex space-x-4">
        <button wire:click="approveRequest({{ $desks->id }})" class="px-4 py-2 bg-green-500 text-white rounded-md shadow-sm hover:bg-green-600">
            Approve Request
        </button>
        <button wire:click="rejectRequest({{ $desks->id }})" class="px-4 py-2 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600">
            Reject Request
        </button>
    </div>
</div>

