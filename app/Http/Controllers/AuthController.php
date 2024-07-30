<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login()
    {
        // Implementasi logika login Anda di sini
        return view('auth.login');
    }

    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password salah');
        }
    }

    public function logout()
    {
        Auth::logout();    
        return redirect()->route('login')->with('failed', 'Email atau Password salah');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_proses(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Simpan data pengguna baru ke dalam database
        $data = [
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 1
        ];

        User::create($data)->assignRole('pelanggan');

        // Redirect atau lakukan tindakan lain setelah berhasil mendaftar
        return redirect()->route('login')->with('success', 'Registrasi berhasil!');

        // dd($request->all());
    }
    public function kelolaPengguna()
    {
    // Ambil semua pengguna dari database
    $users = User::all();
    return view('admin.pengguna', ['users' => $users]);
    }   
    public function destroy(User $user)
    {
    $user->delete();
    return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil dihapus!');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message' => 'Pengguna berhasil ditambahkan.']);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menambahkan pengguna.'], 500);
        }
    }

    public function edit(User $user)
    {
        return response()->json(['data' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $user->update([
                'username' => $request->username,
                'email' => $request->email,
            ]);

            return response()->json(['message' => 'Data pengguna berhasil diperbarui.']);
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memperbarui pengguna.'], 500);
        }
    }
    
    public function getTotalUser()
    {
        
        $totalUsers = User::count(); // Ambil jumlah pengguna dari database
        return view('admin.dashboard', compact('totalUsers'));
    }
    
}
