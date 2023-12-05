<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function createEmployee(EmployeeRequest $request)
    {
        try{
            // Create the employee
            $employee = Employee::create([
                'name' => $request->input('name'),
                'age' => $request->input('age'),
                'salary' => $request->input('salary'),
                'function' => $request->input('function'),
                'sexe' => $request->input('sexe'),
                'date_of_employement' => $request->input('date_of_employement'),
                'phone_number' => $request->input('phone_number'),
                
                'departement_id' =>$request->input('departement_id'),
            ]);
            // Return a response with the newly created employee data and a status code of 201 (Created)
            return response()->json(['data' => $employee], Response::HTTP_CREATED);
        }catch(\exception $exception){
            return response()->json($exception->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }
    public function viewEmployees(){
        $employee= Employee::with('departement')->get();
        
        
         return(response()->json([
            'status'=>200,
            'employees'=>$employee
         ]));
    }
    public function viewEmployee($id){
        $employee = Employee::with('departement')->find($id);
        if($employee){
            return response()->json([
              'status'=> 200,
              'employee'=>$employee
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'employee not found',
            ]);
        }
    
    }
    public function updateEmployee(Request $request, $id){
    
        $employee = Employee::findOrFail($id);
        $employee->name = $request->input('name');
        $employee->age = $request->input('age');
        $employee->salary = $request->input('salary');
        $employee->function = $request->input('function');
        $employee->sexe = $request->input('sexe');
        $employee->date_of_employement = $request->input('date_of_employement');
        $employee->phone_number = $request->input('phone_number');
        $employee->departement_id = $request->input('departement_id');
       
        $employee->save();
        return response()->json([
          'staus'=> 200,
          'message'=> 'updated successfully',
      ]);
      }
      public function deleteEmployee($id){
        $employee = Employee::find($id);
        if($employee){
            $employee->delete();
            return response()->json([
              'status'=> 200,
              'message'=>'deleted successfuly'
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'employee not found',
            ]);
        }
    
    
    }
    public function getEmployeesByDepartment(Request $request)
    {
        $departmentId = $request->input('departement_id');
        $employees = Employee::where('departement_id', $departmentId)->get();
        return response()->json(['employees' => $employees]);
    }
}
