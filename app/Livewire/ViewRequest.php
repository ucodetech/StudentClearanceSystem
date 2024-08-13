<?php

namespace App\Livewire;

use App\Models\ClearanceRequest;
use App\Models\Desk;
use Livewire\Component;
use App\Models\RequestDocument;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

#[Layout("layouts.app")]
class ViewRequest extends Component
{
    public $desks;
    public $staffId;
    public $desk;
    public $requestDocuments;
    public $requests;

    protected $queryString = ['desk'];


    public function mount()
    {
        $this->staffId = Auth::user()->id;
        $this->viewRequest($this->desk);
        
    }
    
    public function viewRequest($deskId)
    {
        // Fetch all requests on the logged-in staff's desk
        $this->desks = Desk::where('id', $deskId)->first();
        
        $this->requests = ClearanceRequest::with('student')->where('id', $this->desks->request_id)->first();
        
        $this->getDocuments($this->requests->id);
    }

    public function getDocuments($requestId){
        $this->requestDocuments = RequestDocument::where('request_id', $requestId)->get();
    }

    public function approveRequest($requestId)
    {
        $p = $this->processRequest($requestId, true);
        if($p){
            $this->redirectRoute("dashboard");
        }
       
    }

    public function rejectRequest($requestId)
    {
        $p = $this->processRequest($requestId, false);
        if($p){
            $this->redirectRoute("dashboard");
        }
       
    }

    protected function processRequest($deskId, $approved)
    {
        Log::info("request and approval ". $deskId . " " . $approved);
        Log::info("Staff Id ". $this->staffId);

        $desk = Desk::where('id', $deskId)
                    ->where('staff_id', $this->staffId)
                    ->first();
        $workflow = [
            'admin' => 'court',
            'court' => 'student_affairs',
            'student_affairs' => 'department',
            'department' => 'final_admin',
            'final_admin' => null, // No next step after final_admin
        ];
        Log::info("desks ", [$desk]);
        if ($desk) {
            // Update the desk
            $desk->update(['HasWork' => true]);
            
            $sort = $desk->sort;
            $flow = $desk->flow;
            $nextSort = $sort+1;
            $role = User::where('id', $desk->staff_id)->first()->role;
            Log::info("role ", [$role]);
            Log::info("next sort ", [$nextSort]);


            $nextRole = match ($role) {
                'admission_office' => 'court',
                'court' => 'student_affairs',
                'student_affairs' => 'department',
                'department' => 'final_admin',
                default => "final_admin", 
            };

            $nextFlow = match ($flow) {
                'admin' => 'court',
                'court' => 'student_affairs',
                'student_affairs' => 'department',
                'department' => 'final_admin',
                default => "admin", 
            };
            Log::info("next role ", [$nextRole]);
            Log::info("next flow ", [$nextFlow]);

            if ($approved) {
                if(Auth::user()->role == "final_admin"){
                    Log::info("final  role ", [$nextRole]);
                    $desk->HasWork = true;
                    $desk->updated_at = Carbon::now();
                    $desk->save();
                    $request = ClearanceRequest::where('id', $desk->request_id)->first();
                    if($request != null){
                        $request->status = $approved ? 'approved.' : 'rejected';
                        $request->save();
                    }
                    session()->flash('message', $approved ? 'Request approved.' : 'Request rejected`to student.');
                }else{
                    // If approved, create a new desk entry for the next staff member
                    $newDesks = Desk::create([
                        'request_id' => $desk->request_id,
                        'staff_id' => $this->getNextStaffId($nextRole), 
                        'sort' => $nextSort,
                        'flow' => $nextFlow,
                        'HasWork' => false,
                        'updated_at' => Carbon::now()
                    ]);
                    Log::info("new desk ", [$newDesks]);

                    session()->flash('message', $approved ? 'Request passed to next staff.' : 'Request rejected to student.');
                }
                 return true;
            }
            $this->reset('request', 'requestDocuments');
        }else{
            session()->flash('error', 'Desk is empty can not process request');
            return false;
        }
       
        
    }

    protected function getNextStaffId($role)
    {
        
        // Fetch all staff IDs who are currently active and can handle requests
        $staffId = User::where('role', $role)->first()->id;  // Get all active staff IDs

        if ($staffId == null) {
            throw new \Exception("No available staff members to assign the request.");
        }
       return $staffId;
    }


    public function render()
    {
        return view('livewire.view-request');
    }
}
