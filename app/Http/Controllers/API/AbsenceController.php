<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function createAbsence(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'hours' => 'required|integer',
        ]);

        
        $absence = Absence::create([
            'employee_id' => $request->input('employee_id'),
            'hours' => $request->input('hours'),
            
        ]);

        // Return a response with the newly created employee data and a status code of 201 (Created)
        return response()->json(['data' => $absence], 201);
    }
    public function viewAbsences(Request $request){
        $absences=Absence::with('employee')->with("employee.departement")->get();;
        return(response()->json([
           'status'=>200,
           'absences'=>$absences
        ]));
    }
    public function viewAbsence($id){
        $absence = Absence::with('employee')->with("employee.departement")->find($id);
        if($absence){
            return response()->json([
              'status'=> 200,
              'absence'=>$absence
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'absence
                 not found',
            ]);
        }

    }
    public function updateAbsence(Request $request, $id){
    
        $absence= Absence::findOrFail($id);
        $absence->hours = $request->input('hours');
        $absence->employee_id = $request->input('employee_id');
       
        $absence->save();
        return response()->json([
          'staus'=> 200,
          'message'=> 'updated successfully',
      ]);
      }
      public function deleteAbsence($id){
        $absence= Absence::find($id);
        if($absence){
            $absence->delete();
            return response()->json([
              'status'=> 200,
              'message'=>'deleted successfuly'
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'absence not found',
            ]);
        }
    }
}
