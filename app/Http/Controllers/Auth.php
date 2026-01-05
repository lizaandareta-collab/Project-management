<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mauth;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    // Proses login
    // public function zzz_login(Request $request)
    // {
    //     $request->validate([
    //         'npk' => 'required',
    //         'password' => 'required'
    //     ]);

    //     $npk = $request->input('npk');
    //     $password = $request->input('password');

    //     // Cek user di Oracle
    //     $user = Mauth::checkUser($npk);

    //     if ($user && isset($user['npk'])) {

    //         if (Hash::check($password, $user['password'])) {
    //             session(['user' => $user]);
    //             return redirect('/dashboard')->with('success', 'Login berhasil!');
    //         } else {
    //             return back()->withErrors(['password' => 'Password salah!']);
    //         }
    //     } else {
    //         return back()->withErrors(['npk' => 'NPK tidak ditemukan di Oracle!']);
    //     }
    // }

    public function zzz_login(Request $request)
    {
        $request->validate([
            'npk' => 'required'
        ]);

        $npk = $request->input('npk');
        $user = Mauth::checkUser($npk);

        if ($user && isset($user['npk'])) {
            session(['user' => $user]);
            return redirect('/dashboard')->with('success', 'Login berhasil tanpa password!');
        } else {
            return back()->withErrors(['npk' => 'NPK tidak terdaftar!']);
        }
    }

    public function logout()
    {
        session()->forget('user');
        return redirect('/pm')->with('success', 'Anda telah logout.');
    }


    public function dashboard()
    {
        if (!session()->has('user')) {
            return redirect('/pm')->withErrors(['Silakan login terlebih dahulu.']);
        }

        $data = [
            'title' => 'Dashboard',
            'content' => 'pm.dashboard'
        ];
        return view('template.wrapper', $data);
    }
}
