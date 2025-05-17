<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $users
            ]);
        }

        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $user
            ]);
        }

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|string|in:admin,user',
            'origin'   => 'nullable|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        logActivity(
            'Create',
            'User',
            $user->id,
            'Pendaftaran pengguna dengan email ' . $validated['email'] . '.'
        );

        return response()->json([
            'Data' => $user,
            'Message' => 'User berhasil dibuat.'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'role'     => 'sometimes|string|in:admin,user',
            'origin'   => 'nullable|string|max:255',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        logActivity(
            'Update',
            'User',
            $user->id,
            'Pembaruan pengguna dengan ID ' . $user->id . '.'
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $user,
                'Message' => 'User berhasil diperbarui.'
            ]);
        }

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        logActivity(
            'Delete',
            'User',
            $user->id,
            'Penghapusan pengguna dengan ID ' . $user->id . '.'
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $user,
                'Message' => 'User berhasil dihapus.'
            ]);
        }

        return redirect()->route('users.index');
    }

    public function auth()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'Error' => ['Email atau password salah.']
            ]);
        }

        Auth::login($user);

        $token = $user->createToken('authToken')->plainTextToken;

        logActivity(
            'Login',
            'User',
            $user->id,
            'Pengguna dengan ID ' . $user->id . ' melakukan login.'
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Data'    => $user,
                'Token'   => $token
            ]);
        }

        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('home');
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user()->currentAccessToken()->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'Message' => 'Logout berhasil. Selamat Tinggal.'
            ], 200);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        logActivity(
            'Logout',
            'User',
            $user->id,
            'Pengguna dengan ID ' . $user->id . ' melakukan logout.'
        );
        
        return redirect()->route('auth');
    }
}
