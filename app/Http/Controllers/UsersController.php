<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
{
    public function getAllUsers()
    {
        $users = Users::all();

        return view('crud', ['users' => $users]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required',
        ]);

        Users::create($data);

        return redirect()->back()->with('success', 'User added successfully!');
    }
    public function getUserData($id)
    {
        $user = Users::find($id);

        return response()->json(['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $employee = Users::find($id);

        $employee->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
        ]);

        return response()->json(['message' => 'User updated successfully']);
    }
    public function delete($id)
    {
        $user = Users::find($id);
    
        if (!$user) {
            return redirect('/crud')->with('error', 'User not found');
        }
    
        $user->delete();
    
        return redirect('/crud')->with('success', 'User deleted successfully');
    }
}
