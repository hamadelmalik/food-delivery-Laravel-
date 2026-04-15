<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // 🟢 Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => 'uploadimages/default.png', // default image

        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'code' => 201,
            'message' => 'REGISTER SUCCESS',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token,
            ]
        ], 201);
    }

    // 🟢 Login
   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (!auth()->attempt($request->only('email', 'password'))) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid email or password'
        ], 401);
    }

    $user = auth()->user();
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status' => true,
        'message' => 'Login successful',
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user
    ], 200);
}
// 🟢 Get Profile
public function profile(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'code' => 401,
            'message' => 'Unauthenticated'
        ], 401);
    }

    return response()->json([
        'code' => 200,
        'message' => 'PROFILE DATA',
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'address' => $user->address ?? '',
            'visa' => $user->visa ?? '',
            'image' => $user->image && $user->image !== ''
    ? url('storage/' . $user->image)
    : url('storage/uploadimages/default.jpg'),


            'token' => $request->bearerToken(),
        ]
    ]);
}
    // 🟢 Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'code' => 200,
            'message' => 'LOGGED OUT'
        ]);
    }
    //update profile

    public function updateProfile(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'code' => 401,
            'message' => 'Unauthenticated'
        ], 401);
    }

    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'address' => 'nullable|string',
        'visa' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update fields
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->address = $validated['address'] ?? $user->address;
    $user->visa = $validated['visa'] ?? $user->visa;

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($user->image && \Storage::exists('public/' . $user->image)) {
            \Storage::delete('public/' . $user->image);
        }

        $path = $request->file('image')->store('uploadimages', 'public');
        $user->image = $path;
    }

    $user->save();

    return response()->json([
        'code' => 200,
        'message' => 'PROFILE UPDATED SUCCESSFULLY',
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'address' => $user->address ?? '',
            'visa' => $user->visa ?? '',
            'image' => $user->image
                ? url('storage/' . $user->image)
                : url('storage/uploadimages/default.jpg'),
            'token' => $request->bearerToken(),
        ]
    ]);
}

}
