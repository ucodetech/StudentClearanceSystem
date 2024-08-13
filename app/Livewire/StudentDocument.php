<?php

namespace App\Livewire;

use App\Models\ClearanceRequest;
use App\Models\RequestDocument;
use Livewire\Component;

class StudentDocument extends Component
{
    public $studentId;

    public function mount($studentId)
    {
        $this->studentId = $studentId;
      
    }

    public function render()
    {
        $request = ClearanceRequest::where('student_id', $this->studentId)->first();
        $documents = RequestDocument::where('request_id', $request->id)->get();
       
        return view('livewire.student-document', [
            'request' => $request,
            'documents' => $documents
        ]);
    }
}
