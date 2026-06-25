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
        'npk' => 'required',
        'password' => 'required'
    ]);

    $npk = $request->input('npk');
    $password = $request->input('password');

    $user = Mauth::checkUser($npk);

    if ($user && isset($user['npk'])) {

        if (md5($password) == $user['password']) {

            // ✅ Mapping role
            $roleName = 'Unknown';

            if ($user['role_id'] == 80) {
                $roleName = 'PM';
            } elseif ($user['role_id'] == 81) {
                $roleName = 'PE';
            } elseif ($user['role_id'] == 82) {
                $roleName = 'QA';
            }

            // ✅ Simpan ke session
            session([
                'user' => $user,
                'role_id' => $user['role_id'],
                'role_name' => $roleName
            ]);

            return redirect('/progress')->with('success', 'Login berhasil sebagai ' . $roleName);

        } else {
            return back()->withErrors(['password' => 'Password salah!']);
        }

    } else {
        return back()->withErrors(['npk' => 'NPK tidak terdaftar!']);
    }
}

    public function logout()
    {
        session()->forget('user');
        return redirect('/pm')->with('success', 'Anda telah logout.');
    }


    public function project()
    {
        if (!session()->has('user')) {
            return redirect('/pm')->withErrors(['Silakan login terlebih dahulu.']);
        }

        $data = [
            'title' => 'Project',
            'content' => 'pm.progress'
        ];
        return view('template.wrapper', $data);
    }
}



