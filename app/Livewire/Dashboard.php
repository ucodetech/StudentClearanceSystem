<?php

namespace App\Livewire;

use App\Models\Desk;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\ClearanceRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

#[Layout("layouts.app")]
class Dashboard extends Component
{
    public $studentRequests = [];
    public $staffId;
    public $studentId;
    public $request_status;


    public function mount()
    {
        $this->staffId = Auth::user()->id;
        $this->studentId = Auth::user()->id;
        $this->loadRequests();
        $this->getStudentRequestStatus();
    }

    public function loadRequests()
    {
       $this->studentRequests = Desk::with('staff')->where('staff_id', $this->staffId)->where('HasWork', false)->get();
    }

    public function getStudentRequestStatus()
    {

        // Get the student's request with its current desk and status
        $request = ClearanceRequest::where('student_id', $this->studentId)
            ->with(['currentDesk' => function ($query) {
                $query->select('id', 'request_id', 'flow', 'staff_id');
            }])
            ->select('id', 'status')
            ->first();

         $this->request_status = $request;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
