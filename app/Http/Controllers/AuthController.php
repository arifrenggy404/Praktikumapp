<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan Halaman Form Login (Akses: Publik/Admin)
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('login');
    }

    /**
     * Memproses Logika Autentikasi Login (Mengecek Kredensial)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        \Log::info('Login attempt for username: ' . $credentials['username']);

        if (Auth::attempt($credentials)) {
            \Log::info('Login successful for username: ' . $credentials['username']);
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        \Log::warning('Login failed for username: ' . $credentials['username']);

        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    /**
     * Memproses Pengubahan Nama Admin, Username, & Password
     */
    public function updateProfilAdmin(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'password_lama' => 'required|string',
            'password_baru' => 'nullable|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama yang Anda masukkan tidak sesuai.']);
        }

        // Update Nama Lengkap Administrator
        if ($user->jemaat) {
            $user->jemaat->update(['nama_lengkap' => $request->nama_admin]);
        } else {
            $jemaat = Jemaat::create([
                'nama_lengkap' => $request->nama_admin,
                'tempat_lahir' => 'Waingapu',
                'tanggal_lahir' => '1990-01-01',
                'alamat_domisili' => 'Kandara',
                'status_baptis' => 'Sudah',
                'status_sidi' => 'Sudah',
            ]);
            $user->jemaat_id = $jemaat->id;
        }

        $user->username = $request->username;

        if ($request->filled('password_baru')) {
            $user->password = Hash::make($request->password_baru);
        }

        $user->save();

        return back()->with('success', 'Nama Admin, Username, & Password akun login berhasil diperbarui!');
    }

    /**
     * Memproses Logika Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}