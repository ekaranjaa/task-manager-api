<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
<<<<<<< HEAD

class UsersController extends Controller
{
    public function index()
=======
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

    public function read()
>>>>>>> 8f9de2fcbc92b00e54b8f91ce7318c52e5b542f0
    {
        $users = UserResource::collection(
            User::with('tasks')->paginate(50)
        );

        return $users;
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

<<<<<<< HEAD
=======
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['No such user.'],
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Incorrect password.'],
            ]);
        }

        return $user->createToken($request->email)->plainTextToken;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user->save()) {
            event(new Registered($user));
            return response()->json(['message' => 'Account created.']);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out.']);
    }

>>>>>>> 8f9de2fcbc92b00e54b8f91ce7318c52e5b542f0
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

<<<<<<< HEAD
    public function updatePermission(Request $request, User $user, $id)
    {
        $request->validate([
            'role_id' => 'required'
=======
    public function updatePassword(Request $request, User $user, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8'
>>>>>>> 8f9de2fcbc92b00e54b8f91ce7318c52e5b542f0
        ]);

        $user = $user::findOrFail($id);

<<<<<<< HEAD
        $user->update([
            'role_id' => $request->role_id
        ]);

        if ($user->save()) {
            return response()->json(['message' => 'User permision updated.']);
=======
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Incorrect password.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        if ($user->save()) {
            return response()->json(['message' => 'Password changed.']);
>>>>>>> 8f9de2fcbc92b00e54b8f91ce7318c52e5b542f0
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
