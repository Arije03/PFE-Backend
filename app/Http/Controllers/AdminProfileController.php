<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function update(Request $request, $id)
    {
        // Validez les données du formulaire
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        ]);

        // Récupérez l'utilisateur authentifié
        $user = Auth::user();

        // Vérifiez si l'utilisateur est un administrateur
        /*if (!$user || !$user->isAdmin()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }*/

        // Mettez à jour le profil de l'administrateur
        $admin = User::findOrFail($id);
        $admin->first_name = $validatedData['first_name'];
        $admin->last_name = $validatedData['last_name'];
        $admin->email = $validatedData['email'];
        $admin->save();

        return response()->json(['message' => 'Profil administrateur mis à jour avec succès']);
    }
}