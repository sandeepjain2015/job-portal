<?php

namespace App\Http\Controllers;

use \App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
 use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class UserController extends Controller implements HasMiddleware
{
     public static function middleware(){
        return [
            new Middleware( 'permission:view users',only: ['index'] ),
            new Middleware( 'permission:edit users',only: ['edit'] ),
            new Middleware( 'permission:create users',only: ['create', 'store'] ),
            new Middleware( 'permission:delete users',only: ['destroy'] ),
            new Middleware( 'permission:show users',only: ['show'] ),
            new Middleware( 'permission:update users',only: ['update'] ),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch users with pagination
        $users = User::paginate(10);

        // Return the view with users
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new user
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Redirect to the users index with a success message
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Return the view for showing a specific user
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);
        $roles =    Role::latest()->get();
        // Fetch all roles for the user
        $hasRoles = $user->roles->pluck('id');
       
        // Return the view for editing a specific user
        return view('users.edit', compact('user', 'roles', 'hasRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Update user details
        $user->name = $request->name;
        $user->syncRoles($request->input('roles'));
        $user->save();

        // Redirect to the users index with a success message
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Redirect to the users index with a success message
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    public  function usercheck(){
        $user = User::find(1);
        
        $user->jobs()->attach(1);
    }
}
