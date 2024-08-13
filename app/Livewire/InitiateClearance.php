<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Desk;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\RequestDocument;
use Livewire\Attributes\Layout;
use App\Models\ClearanceRequest;
use Illuminate\Support\Facades\Auth;

#[Layout("layouts.app")]
class InitiateClearance extends Component
{
    use WithFileUploads;

    public $documents = [];
    public $studentId;
    public bool $initiatedPrevious = false;
    public $sort = 1;
    public $staff_id;
    public $hasWork = false;
    public $noStaff = false;
  

    public function mount()
    {
        $this->studentId = Auth::user()->id;
        $initiatedBefore = ClearanceRequest::where('student_id', $this->studentId)->first();
        if($initiatedBefore){
            session()->flash('message', 'You have already initiated clearance.');
            $this->initiatedPrevious = true;
          
        }else{
            $this->initiatedPrevious = false;

        }

        //check if admission office is onboard
        $admissionOffice = User::where('role', "admission_office")->get();
        if($admissionOffice->isEmpty()){
            session()->flash('error', 'You can not initiate clearance because no staff from admission office have be on boarded, reach out to your department!.');
            $this->noStaff = true;
            return false;
        } else{
            $this->staff_id = $admissionOffice->first()->id;
        }
    }

    public function initiateClearance()
    {
        $this->validate([
            'documents.*' => 'required|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB Max
        ]);
        //if student have initiated request before
        $initiatedBefore = ClearanceRequest::where('student_id', $this->studentId)->first();
        if($initiatedBefore){
            session()->flash('message', 'You have already initiated clearance.');
            $this->initiatedPrevious = true;
            return false;
        }

        $initiate = new ClearanceRequest();
        $initiate->student_id = $this->studentId;
        $initiate->status = "processing";

        if($initiate->save()){
            foreach ($this->documents as $document) {
                $fileName = 'clearance_'. Str::random(15) .$this->studentId.'.'.$document->extension();
                $document->storeAs('public/uploads/', $fileName);

                RequestDocument::create([
                    'request_id' => $initiate->id,
                    'file' => $fileName,
                    'created_at' => Carbon::now()
                ]);
            }

            $desk = new Desk();
            $desk->staff_id = $this->staff_id;
            $desk->request_id = $initiate->id;
            $desk->flow = "admin";
            $desk->sort = $this->sort;
            $desk->HasWork = $this->hasWork;
            $desk->created_at = Carbon::now();
            $desk->save();
            
            session()->flash('message', 'Clearance Initiated successfully.');
            $this->redirectRoute('dashboard');
        }
    }

    public function render()
    {
        return view('livewire.initiate-clearance');
    }
}
