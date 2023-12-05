<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function createDepartment(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            
            'name_department' => 'required|string|max:255',
           
        ]);

        
        $department = Department::create([
            'name_department' => $request->input('name_department'),
            'user_id' => $request->input('user_id'),
            
        ]);

        // Return a response with the newly created employee data and a status code of 201 (Created)
        return response()->json(['data' =>$department], 201);
    }
    public function viewDepartments(Request $request){
        $departments=Department::with("user")->get();
        return(response()->json([
           'status'=>200,
           'departments'=>$departments
        ]));
    }
    public function viewDepartment($id){
        $department = Department::find($id);
        if($department){
            return response()->json([
              'status'=> 200,
              'department'=>$department
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'department not found',
            ]);
        }
    
    }
    public function deleteDepartment($id){
        $department= Department::find($id);
        if($department){
            $department->delete();
            return response()->json([
              'status'=> 200,
              'message'=>'deleted successfuly'
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'department not found',
            ]);
        }
    }
    public function viewDepartmentInf()
    {
        // Retrieve users with the 'Chef Department' role
        $info = Department::where('name_department', 'informatique')->get();

        return response()->json(['info' => $info]);
    }
    public function viewDepartmentMec()
    {
        // Retrieve users with the 'Chef Department' role
        $mec = Department::where('name_department', 'Mécanique')->get();

        return response()->json(['mec' => $mec]);
    }
    public function viewDepartmentElec()
    {
        // Retrieve users with the 'Chef Department' role
        $elec = Department::where('name_department', 'électrique')->get();

        return response()->json(['elec' => $elec]);
    }
 
}
