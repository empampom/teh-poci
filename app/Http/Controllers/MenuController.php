<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $list_menu = DB::table('menu')->orderBy('harga')->get();

        return view('menu', compact('list_menu'));
    }

    public function store(Request $request)
    {
        $nama = $request->nama;
        $harga = $request->harga;

        $file = $request->file('gambar');
        $nama_gambar = $file->getClientOriginalName();
        $ekstensi = Str::afterLast($nama_gambar, '.');
        $destinasi = public_path() . '/gambar_menu';

        $id = DB::table('menu')->insertGetId([
            'created_at' => now(),
            'created_by' => auth()->user()->id,
            'nama' => $nama,
            'harga' => $harga
        ]);

        $nama_baru = $id . '.' . $ekstensi;
        $file->move($destinasi, $nama_baru);

        DB::table('menu')
            ->where('id', $id)
            ->update(['gambar' => $nama_baru]);

        return redirect()->route('menu.index')->with('status', ['success', 'Data Berhasil di Tambahkan']);
    }
}
