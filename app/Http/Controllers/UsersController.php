<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $user = new UserResource(
            User::findOrFail($request->user()->id)
        );

        return $user;
    }

    public function search($query)
    {
        $users = UserResource::collection(
            User::where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->paginate(30)
        );

        return $users;
    }

    public function update(Request $request, User $user, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user = $user::findOrFail($id);

        if ($request->email !== $user->email) {
            $request->validate([
                'email' => 'unique:users'
            ]);

            $user->update([
                'email' => $request->email,
                'email_verified_at' => null
            ]);

            event(new Registered($user));
        }

        $user->update([
            'name' => $request->name
        ]);

        if ($user->save()) {
            return response()->json(['message' => 'Account updated.']);
        }
    }

    public function updatePermission(Request $request, User $user, $id)
    {
        $request->validate([
            'role_id' => 'required'
        ]);

        $user = $user::findOrFail($id);

        $user->update([
            'role_id' => $request->role_id
        ]);

        if ($user->save()) {
            return response()->json(['message' => 'Permissions updated.']);
        }
    }

    public function delete(User $user, $id)
    {
        $user = $user::findOrFail($id);

        if ($user->delete()) {
            return response()->json(['message' => 'Account deleted.']);
        }
    }
}
