<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminsController extends Controller
{
    public function index(Request $request)
    {
        $admin = new AdminResource(
            Admin::findOrFail($request->user()->id)
        );

        return $admin;
    }

    public function read()
    {
        $admins = AdminResource::collection(
            Admin::paginate(50)
        );

        return $admins;
    }

    public function search($query)
    {
        $admins = AdminResource::collection(
            Admin::where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->paginate(30)
        );

        return $admins;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            throw ValidationException::withMessages([
                'email' => ['No such admin.'],
            ]);
        }

        if (!Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'password' => ['Incorrect password.'],
            ]);
        }

        return $admin->createToken($request->email)->plainTextToken;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|confirmed|min:8',
        ]);

        $admin = new Admin([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($admin->save()) {
            event(new Registered($admin));
            return response()->json(['message' => 'Account created.']);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out.']);
    }

    public function update(Request $request, Admin $admin, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $admin = $admin::findOrFail($id);

        if ($request->email !== $admin->email) {
            $request->validate([
                'email' => 'unique:admins'
            ]);

            $admin->update([
                'email' => $request->email,
                'email_verified_at' => null
            ]);

            event(new Registered($admin));
        }

        $admin->update([
            'name' => $request->name
        ]);

        if ($admin->save()) {
            return response()->json(['message' => 'Account updated.']);
        }
    }

    public function updatePassword(Request $request, Admin $admin, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8'
        ]);

        $admin = $admin::findOrFail($id);

        if (!Hash::check($request->current_password, $admin->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Incorrect password.'],
            ]);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        if ($admin->save()) {
            return response()->json(['message' => 'Password changed.']);
        }
    }

    public function delete(Admin $admin, $id)
    {
        $admin = $admin::findOrFail($id);

        if ($admin->delete()) {
            return response()->json(['message' => 'Account deleted.']);
        }
    }
}
