<div>

    @if (auth()->user()->role != "student")
    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
      <h3 class="text-xl font-semibold text-gray-800 mb-4">Requests on Your Desk</h3>
      @if($studentRequests->isEmpty())
          <p class="text-gray-600">No requests available on your desk.</p>
      @else
          <table class="w-full table-auto">
              <thead>
                  <tr>
                      <th class="px-4 py-2 text-left text-gray-600">Desk ID</th>
                      <th class="px-4 py-2 text-left text-gray-600">Staff</th>
                      <th class="px-4 py-2 text-left text-gray-600">Flow</th>
                      <th class="px-4 py-2 text-left text-gray-600">Has Work</th>
                      <th class="px-4 py-2 text-left text-gray-600">Request Id</th>
                      <th class="px-4 py-2 text-left text-gray-600">Date Submitted</th>
                      <th class="px-4 py-2 text-left text-gray-600">Actions</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($studentRequests as $request)
                      <tr>
                          <td class="border px-4 py-2">{{ $request->id }}</td>
                          <td class="border px-4 py-2">{{ $request->staff->name }}</td>
                          <td class="border px-4 py-2">{{ ucfirst($request->flow) }}</td>
                          <td class="border px-4 py-2">{{ $request->HasWork ? "Yes": "No"  }}</td>
                          <td class="border px-4 py-2">{{ $request->request_id }}</td>
                          <td class="border px-4 py-2">{{ Carbon\Carbon::parse($request->created_at)->format("d-m-yy h:sa") }}</td>
                          <td class="border px-4 py-2">
                              <a href="{{ route('view.desk', ['desk' =>$request->id]) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600" wire.navigate>
                                  View Request
                              </a>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      @endif
    </div>
    @else
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Clearance Request Status</h3>
    
        @if($request_status)
            <table class="min-w-full bg-white text-center">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Request ID</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Current Flow</th>
                        <th class="py-2 px-4 border-b">Handled By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $request_status->id }}</td>
                        <td class="py-2 px-2 border-b bg-blue-500 text-blue-300 rounded-full text-center">{{ $request_status->status }}</td>
                        <td class="py-2 px-4 border-b capitalize">{{ $request_status->currentDesk->flow ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $request_status->currentDesk->staff->name ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-gray-600">No clearance request found.</p>
        @endif
    </div>
    
    @endif

</div>