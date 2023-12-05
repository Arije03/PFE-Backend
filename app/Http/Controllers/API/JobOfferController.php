<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Joboffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function createJobOffer(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            
            'name_offer' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'diploma' => 'required|string|max:255',
            'department_id'=>'required'
        ]);

        
        $joboffer = Joboffer::create([
            'name_offer' => $request->input('name_offer'),
            'description' => $request->input('description'),
            'experience' => $request->input('experience'),
            'diploma' => $request->input('diploma'),
            'department_id' => $request->input('department_id'),
        ]);

        // Return a response with the newly created jobOffer data and a status code of 201 (Created)
        return response()->json(['data' => $joboffer], 201);
    }
    public function viewJobOffers(Request $request){
        $joboffers=Joboffer::with("department")->get();
        ;
        return(response()->json([
           'status'=>200,
           'joboffers'=>$joboffers 
        ]));
    }
    public function viewJobOffer($id){
        $joboffer = Joboffer::find($id);
        if($joboffer){
            return response()->json([
              'status'=> 200,
              'joboffer'=>$joboffer
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'job offer not found',
            ]);
        }
    
    }
    public function updateJobOffer(Request $request, $id){
    
        $joboffer= Joboffer::findOrFail($id);
        $joboffer->name_offer = $request->input('name_offer');
        $joboffer->description = $request->input('description');
        $joboffer->experience = $request->input('experience');
        $joboffer->diploma = $request->input('diploma');
        $joboffer->department_id = $request->input('department_id');
        $joboffer->save();
        return response()->json([
          'staus'=> 200,
          'message'=> 'updated successfully',
      ]);
      }
      public function deleteJobOffer($id){
        $joboffer= Joboffer::find($id);
        if($joboffer){
            $joboffer->delete();
            return response()->json([
              'status'=> 200,
              'message'=>'deleted successfuly'
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'job offer not found',
            ]);
        }
    }
}
