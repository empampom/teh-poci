<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    public function index()
    {
        $list_pengguna = DB::table('pengguna')->get();
        $list_cabang = DB::table('cabang')->get();

        return view('pengguna', compact('list_pengguna', 'list_cabang'));
    }

    public function store(Request $request)
    {
        $nama_lengkap = $request->nama_lengkap;
        $username = $request->username;
        $password = $request->password;
        $akses = $request->akses;
        // $cabang = $request->cabang;

        DB::table('pengguna')->insert([
            'created_at' => now(),
            'created_by' => auth()->user()->id,
            'nama_lengkap' => $nama_lengkap,
            'username' => $username,
            'password' => $password,
            'akses' => $akses
        ]);

        return redirect()->route('pengguna.index')->with('status', ['success', 'Data Berhasil di Tambahkan']);
    }
}
