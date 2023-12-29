<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Administrator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        if ($token = JWTAuth::attempt($credentials)) {
            // Get the authenticated user
            $user = Auth::user();
    
            // Include user information in the token payload
            $customClaims = [
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                // Add any other user-related information you want
            ];
    
            // Add custom claims to the token
            $token = JWTAuth::claims($customClaims)->attempt($credentials);
    
            // Decode the token
            $decodedToken = JWTAuth::setToken($token)->toUser();
            $username = $decodedToken->username;
            $role = $decodedToken->role;
    
            // Redirect to the /crud page with the decoded token
            return redirect('/crud')->with('username', $username)->with('role', $role);
        }
    
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
