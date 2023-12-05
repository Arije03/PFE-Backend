<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
  public function register(Request $request)
  {
      // Validate the input data and create the user
      $user = User::create([
          'first_name' => $request->input('first_name'),
          'last_name' => $request->input('last_name'),
          'email' => $request->input('email'),
          'password' => Hash::make($request->input('password')),
          'user_type' => 'Job Seeker', // Assign the role during registration
      ]);
  
      return response()->json(['message' => 'Registration successful', 'user' => $user]);
  }

  public function login(Request $request)
  {
      
      $user = User::where('email', $request->input('email'))->first();

     
      if ($user && Hash::check($request->input('password'), $user->password)) {
          $token = $user->createToken('authToken')->plainTextToken;
          $user_type = $user->user_type;
          $id= $user->id;
          return response()->json(['message' => 'Login successful', 
          'token' => $token,
          'user_type'=> $user_type,
          'id' => $id,
        ]);
      }
  
      return response()->json(['message' => 'Invalid credentials'], 401);
  }

public function createChef(Request $request)
    {
        // Validate input data and create a new user with the 'Chef Department' role
        $chef = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'user_type' => 'Chef Department', // Assign the role to 'Chef Department'
        ]);

        return response()->json(['message' => 'Chef created', 'chef' => $chef]);
    }
    public function viewChefs()
    {
        // Retrieve users with the 'Chef Department' role
        $chefs = User::where('user_type', 'Chef Department')->get();

        return response()->json(['chefs' => $chefs]);
    }
    public function viewSeekers()
    {
        // Retrieve users with the 'Chef Department' role
        $seekers = User::where('user_type', 'Job Seeker')->get();

        return response()->json(['seekers' => $seekers]);
    }
    public function deleteChef($id){
        $chef= User::find($id);
        if($chef){
            $chef->delete();
            return response()->json([
              'status'=> 200,
              'message'=>'deleted successfuly'
            ]);
        }
        else{
            return response()->json([
                'staus'=> 404,
                'message'=> 'chef not found',
            ]);
        }
    }
    public function logout(Request $request){
      $request->user()->currentAccessToken()->delete();
      return response()->json([
       'status'=>200,
       'message'=>"logged Out successffuly"
      ]);
      
  }
  public function viewEditUser($id){
    $user = User::find($id);
    if($user){
        return response()->json([
          'status'=> 200,
          'user'=>$user
        ]);
    }
    else{
        return response()->json([
            'staus'=> 404,
            'message'=> 'user not found',
        ]);
    }

}
public function updateUser(Request $request, $id){
    
    $user = User::findOrFail($id);
    $user->first_name = $request->input('first_name');
    $user->last_name = $request->input('last_name');
    $user->email = $request->input('email');
   
   
    $user->save();
    return response()->json([
      'staus'=> 200,
      'message'=> 'updated successfully',
  ]);
  }
  }
  






