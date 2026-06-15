<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan Halaman Form Login (Akses: Publik/Admin)
     */
    public function showLogin()
    {
        // Jika admin sudah terlanjur login, langsung alihkan ke dashboard admin
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
        // 1. Validasi input username dan password dari form login
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        \Log::info('Login attempt for username: ' . $credentials['username']);

        // 2. Coba cocokkan kredensial ke database MySQL (Otomatis memverifikasi hash password Bcrypt)
        if (Auth::attempt($credentials)) {
            \Log::info('Login successful for username: ' . $credentials['username']);
            // Jika sukses, buat ulang session untuk mencegah serangan Session Fixation
            $request->session()->regenerate();

            // Dialihkan ke rute proteksi dashboard admin
            return redirect()->intended('dashboard');
        }

        \Log::warning('Login failed for username: ' . $credentials['username']);

        // 3. Jika gagal cocok, kembalikan ke halaman login dengan pesan error (Sesuai Activity Diagram)
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    /**
     * Memproses Logika Logout (Menghancurkan Session)
     */
    public function logout(Request $request)
    {
        // Melakukan logout pengguna dari guard auth Laravel
        Auth::logout();

        // Menghancurkan seluruh data session yang aktif
        $request->session()->invalidate();

        // Membuat ulang token CSRF baru demi keamanan non-fungsional sistem
        $request->session()->regenerateToken();

        // Redirect kembali ke halaman utama / beranda warta publik jemaat
        return redirect('/');
    }
}