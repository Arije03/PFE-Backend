<?php

namespace App\Http\Controllers\API;

use App\Events\JobApplicationCreated;
use App\Http\Controllers\Controller;
use App\Mail\jobapplicationMail;
use App\Mail\jobapplicationMailRefus;
use App\Models\Jobapplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class JobappController extends Controller
{
    public function createJobApplication(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            
            'job_offer_id' => 'required',
            'user_id' => 'required',
            'text' => 'required|string|max:255',
            'salary' => 'required',
            
        ]);

        
        $jobapplication = Jobapplication::create([
            'job_offer_id' => $request->input('job_offer_id'),
            'user_id' => $request->input('user_id'),
            'text' => $request->input('text'),
            'salary' => $request->input('salary'),
          
           
        ]);

        
        Event::dispatch(new JobApplicationCreated($jobapplication));

    return response()->json(['jobapplication' => $jobapplication], 201);
    }
    public function viewJobApplications(Request $request){
        $jobapplication = Jobapplication::with("user")->with("joboffer.department.user")->get();
        return(response()->json([
           'status'=>200,
           'jobapplication'=>$jobapplication
        ]));
    }
    public function acceptJobApplication(Request $request, $id)
    {
        $jobapplication = jobapplication::findOrFail($id);
    
        if($jobapplication->status === 'pending'){
            $jobapplication->status = 'accepted';
            $jobapplication->save();
            $message="accepté";
    
            Mail::to("boubakerarije@gmail.com")->send(new jobapplicationMail($message));
           // $parent = User::find($jobapplication->user_parent_id);
           // $parent->notify(new MeetingRequestStatus('accepted'));
    
            return response()->json(['message' => 'job application accepted successfully']);
        }
        else{
            return response()->json(['error' => 'Meeting request has already been accepted or declined']);
        }
    }
    public function refuseJobApplication(Request $request, $id)
{
    $jobapplication = jobapplication::findOrFail($id);

    if($jobapplication->status === 'pending'){
        $jobapplication->status = 'refused';
        $jobapplication->save();
        $message="refus";
    
        Mail::to("boubakerarije@gmail.com")->send(new jobapplicationMailRefus($message));
        //$parent = User::find($jobapplication->user_parent_id);
       // $parent->notify(new MeetingRequestStatus('refused'));

        return response()->json(['message' => 'job application refused successfully']);
      
    }
    else{
        return response()->json(['error' => 'Meeting request has already been accepted or declined']);
    }
}
public function viewJobsPending()
{
    // Retrieve users with the 'Chef Department' role
    $jobs = jobapplication::where('status', 'pending')->get();

    return response()->json(['jobs' => $jobs]);
}
public function viewJobsAccepted()
{
    // Retrieve users with the 'Chef Department' role
    $jobss = jobapplication::where('status', 'accepted')->get();

    return response()->json(['jobss' => $jobss]);
}
}
