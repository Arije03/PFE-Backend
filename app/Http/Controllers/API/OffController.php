<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Off;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OffController extends Controller
{
    public function createOff(Request $request)
    {
        {
            $data = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ]);
    
            $employee = Employee::findOrFail($data['employee_id']);
    
            // Calculate days_number based on start_date and end_date
            $daysNumber = Carbon::parse($data['start_date'])->diffInDays($data['end_date']);
    
            // Calculate total accumulated days for the employee's existing offs
            $totalAccumulatedDays = $employee->offs()->sum('days_number');
    
            if (($totalAccumulatedDays + $daysNumber) > 30) {
                return response()->json(['error' => 'Total accumulated leave days exceed 30'], 400);
            }
    
            // Create the "off" record
            $off = Off::create([
                'employee_id' => $data['employee_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'days_number' => $daysNumber,
            ]);
    
            // Update off_col for the employee if the accumulated days have reached 30
            if (($totalAccumulatedDays + $daysNumber) >= 30) {
                $employee->update(['off_col' => 1]);
            }
    
            return response()->json(['message' => 'Off record created successfully'], 201);
        }
    }
    public function viewOffs(Request $request){
        $offs= Off::with('employee')->with("employee.departement")->get();
        
        
         return(response()->json([
            'status'=>200,
            'offs'=>$offs
         ]));
     }
     public function viewOff($id){
        $off = Off::with('employee')->find($id);
        if($off){
            return response()->json([
              'status'=> 200,
              '$off'=>$off
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'off
                 not found',
            ]);
        }

    }
    public function updateOff(Request $request, $id){
    
        $off = Off::findOrFail($id);
        $off->off_col = $request->input('off_col');
        $off->start_date = $request->input('start_date');
        $off->end_date = $request->input('end_date');
        $off->days_number = $request->input('days_number');
        $off->employee_id = $request->input('employee_id');
       
        $off->save();
        return response()->json([
          'staus'=> 200,
          'message'=> 'updated successfully',
      ]);
      }
      public function deleteOff($id){
        $off= Off::find($id);
        if($off){
            $off->delete();
            return response()->json([
              'status'=> 200,
              'message'=>'deleted successfuly'
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'off not found',
            ]);
        }
    }
}

