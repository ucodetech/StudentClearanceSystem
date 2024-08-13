<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden  sm:rounded-lg">
                <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
                    <div class="flex flex-col sm:flex-row">
                      <!-- First Column: User Image, Name, and Email -->
                      <div class="flex flex-col items-center justify-center sm:items-start sm:w-1/3 p-4">
                        <!-- User Image -->
                        <img class="w-28  h-28 rounded-full mb-2 border-2 border-sky-600" src="{{ asset('storage/uploads/avatar.jpg') }}" alt="User Image">
                        <!-- User Name -->
                        <h1 class="text-lg font-bold text-sky-800 text-center uppercase">{{ auth()->user()->name }}</h1>
                        <!-- User Email -->
                        <p class="text-gray-600 text-center">{{ auth()->user()->email }}</p>
                        <p class="text-gray-600 uppercase font-bold text-center">{{ auth()->user()->role }}</p>
                      </div>
                      
                      <!-- Second Column: Additional Details -->
                      <div class="sm:w-2/3 p-4 bg-gray-100 rounded-lg">
                        <!-- Name -->
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ auth()->user()->name }}</h2>
                        <!-- Department -->
                        <p class="text-gray-700"><strong>Department:</strong> {{ auth()->user()->department }}</p>
                        <!-- Level -->
                        <p class="text-gray-700 capitalize"><strong>Level:</strong> {{ auth()->user()->level }}</p>
                        <!-- JAMB No -->
                        @if(auth()->user()->role == "student")
                          <p class="text-gray-700"><strong>JAMB/Form No:</strong> {{ auth()->user()->level == "ND1"?  
                          auth()->user()->jamb_no : auth()->user()->form_no }}</p>
                        @endif
                        <!-- Phone No -->
                        <p class="text-gray-700"><strong>Phone No:</strong> {{ auth()->user()->phone_no }}</p>
                      </div>
                    </div>
                </div>
            </div>
            @if (auth()->user()->role == "student")
              <!-- Documents Row -->
              <div class=" overflow-hidden  sm:rounded-lg mt-5">
                <div class="max-w-5xl mx-auto p-6 bg-white rounded-lg shadow-md">
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Uploaded Documents</h3>
                        @livewire('student-document', ['studentId' => auth()->user()->id])
                    </div>
                </div>
              </div>
            @endif

            <div>
              @livewire('dashboard')
              // ['user' => $user], key($user->id)
              
            </div>
          
        </div>
    </div>
</x-app-layout>
