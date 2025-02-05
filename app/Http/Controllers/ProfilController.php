<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function getProfil()
    {
        return User::find(auth()->user()->id)->select('name', 'email')->first();
    }

    public function updateProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        $user = User::find(auth()->user()->id);

        $user->name = $request->name;
        
        if ($user->email != $request->email) {
            $user->email = $request->email;
        }

        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
    
        return response()->json(['message' => 'Data pengguna berhasil diperbarui.']);
    }
}
