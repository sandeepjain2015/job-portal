<?php

namespace App\Http\Controllers;

use \Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use \Spatie\Permission\Models\Permission;
 use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware( 'permission:view roles',only: ['index'] ),
            new Middleware( 'permission:edit roles',only: ['edit'] ),
            new Middleware( 'permission:create roles',only: ['create', 'store'] ),
            new Middleware( 'permission:delete roles',only: ['destroy'] ),
            new Middleware( 'permission:show roles',only: ['show'] ),
            new Middleware( 'permission:update roles',only: ['update'] ),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Assuming you have a Role model
       
        $roles = Role::with('permissions')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $permissions = Permission::get();
        
        return view('roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
                   $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        $permission = $role->permissions;

        return view('roles.show', compact('role', 'permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(request $request, string $id)
    {
        
        $role = Role::findOrFail($id);
        $permissions = Permission::get();
        $hasPermissions = $role->permissions->pluck('name');

        return view('roles.edit', compact('role', 'permissions', 'hasPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'array',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        
        // Check if the role has any users assigned
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Role cannot be deleted because it is assigned to users.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}