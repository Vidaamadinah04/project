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
            'role' => 'required|string|max:255',
        ]);

        // Simpan data pengguna baru ke dalam database
        $data = [
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role')
        ];

        User::create($data);

        // Redirect atau lakukan tindakan lain setelah berhasil mendaftar
        return redirect()->route('login')->with('success', 'Registrasi berhasil!');

        // dd($request->all());
    }
    public function kelolaPengguna()
    {
    // Ambil semua pengguna dari database
    $users = User::all();
    return view('pengguna.index', ['users' => $users]);
    }   
    public function destroy(User $user)
    {
    $user->delete();
    return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
    }

    public function store(Request $request)
{
    // Validasi data yang dikirim dari form
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8', 
        'role' => 'required|string|max:255',
    ]);

    // Simpan data pengguna baru ke dalam database
    User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    // Redirect atau lakukan tindakan lain setelah berhasil mendaftar
    return redirect()->route('pengguna.index')->with('success', 'Registrasi berhasil!');
}

public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|string|max:255',
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'Data pengguna berhasil diperbarui.']);
    }

    public function edit(User $user)
    {
        return response()->json(['data' => $user]);
    }
    
    
}
