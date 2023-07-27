<?php
// tambah apa kek ini
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function LoginForm()
    {
        return view('login');
    }

    public function LoginAction(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $username = $data['username'];
        $password = $data['password'];
        $cek_username = DB::table('pengguna')->where('username', $username)->first();
        if (isset($cek_username)) {
            $cek_password = DB::table('pengguna')->where('username', $username)->where('password', $password)->first();
            if (isset($cek_password)) {
                if (empty($cek_password->deleted_at)) {
                    Auth::loginUsingId($cek_password->id);
                    return redirect()->route('admin.index');
                } else {
                    return redirect()->route('login')->with('status', ['error', 'Akun tidak aktif']);
                }
            } else {
                return redirect()->route('login')->with('status', ['error', 'Username & Password salah']);
            }
        } else {
            return redirect()->route('login')->with('status', ['error', 'Username tidak terdaftar']);
        }
    }
}
