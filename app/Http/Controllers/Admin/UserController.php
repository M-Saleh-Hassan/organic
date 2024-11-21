<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', 2)->paginate(10); // Adjust role_id if needed
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'id_type' => 'required|in:national_id,passport',
            'id_number' => 'required|string|max:50|unique:users,id_number',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|max:2048',
        ]);

        User::create([
            'role_id' => 2, // Default role for users
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'id_type' => $validated['id_type'],
            'id_number' => $validated['id_number'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:15',
            'id_type' => 'required|in:national_id,passport',
            'id_number' => 'required|string|max:50|unique:users,id_number,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update(array_merge(
            $validated,
            $request->filled('password') ? ['password' => Hash::make($request->password)] : []
        ));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
