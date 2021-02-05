<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        $role = RoleResource::collection(
            Role::paginate(50)
        );

        return $role;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role = new Role([
            'name' => $request->name
        ]);

        if ($role->save()) {
            return response()->json(['message' => 'Role created.']);
        }
    }

    public function update(Request $request, Role $role, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role = $role::findOrFail($id);

        $role->update([
            'name' => $request->name
        ]);

        if ($role->save()) {
            return response()->json(['message' => 'Role updated.']);
        }
    }

    public function delete(Role $role, $id)
    {
        $role = $role::findOrFail($id);

        if ($role->delete()) {
            return response()->json(['message' => 'Role deleted.']);
        }
    }
}
